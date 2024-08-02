<?php

namespace App\Http\Controllers;

use App\Mail\FacturaMail;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Models\Fianza;
use App\Models\Producto;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;

class FianzaController extends Controller
{
    public function index()
    {
        $fianzas = Fianza::join('users', 'fianzas.user_id', '=', 'users.id')
            ->select('fianzas.nu_fianza', 'fianzas.fecha', 'users.nombre', 'users.numero_telefono as telefono', 'fianzas.precio', 'fianzas.estado')
            ->get();

        return view('Finanzas.ver_finanzas', compact('fianzas'));
    }

    public function index_two()
    {
        $fianzas = Fianza::join('users', 'fianzas.user_id', '=', 'users.id')
            ->select('fianzas.nu_fianza', 'fianzas.fecha', 'users.nombre', 'users.numero_telefono as telefono', 'fianzas.precio', 'fianzas.estado')
            ->where('fianzas.estado', false) // Filtrar por estado = false
            ->get();

        return view('Finanzas.generar_pago', compact('fianzas'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('Finanzas.crear_finanzas', compact('productos'));
    }

    public function sendSecurityCode(Request $request, TwilioService $twilio)
    {
        $request->validate([
            'telefono' => 'required',
            'productos' => 'required|array',
        ]);

        $telefono = $request->telefono;
        if (substr($telefono, 0, 1) !== '+') {
            $telefono = '+57' . $telefono;
        }

        $code = rand(100000, 999999);
        Session::put('security_code', $code);

        $productos = $request->productos;
        $productosNombres = Producto::whereIn('id', $productos)->pluck('nombre')->toArray();
        $productosList = implode(', ', $productosNombres);

        $message = "Te están facturando los siguientes productos: $productosList. Tu código de seguridad es: $code.";
        $twilio->sendSms($telefono, $message);

        return response()->json(['message' => 'Código de seguridad enviado.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'security_code' => 'required|integer',
            'cedula' => 'required|string',
            'precio_total' => 'required|numeric',
            'descripcion' => 'required|string',
            'producto' => 'required|array',
            'cantidad' => 'required|array',
            'producto.*' => 'exists:productos,id',
            'cantidad.*' => 'numeric|min:1',
        ]);

        $inputCode = $request->input('security_code');
        $storedCode = Session::get('security_code');

        if ($inputCode != $storedCode) {
            return back()->withErrors(['security_code' => 'El código de seguridad es incorrecto.']);
        }

        $usuario = User::where('numero_documento', $request->input('cedula'))->firstOrFail();

        $fianza = new Fianza();
        $fianza->user_id = $usuario->id;
        $fianza->fecha = now();
        $fianza->precio = $request->input('precio_total');
        $fianza->estado = false;
        $fianza->descripcion = $request->input('descripcion');
        $fianza->save();

        $productos = $request->input('producto');
        $cantidades = $request->input('cantidad');

        foreach ($productos as $index => $productoId) {
            if (isset($cantidades[$index])) {
                $fianza->productos()->attach($productoId, ['cantidad' => $cantidades[$index]]);
            }
        }

        return redirect()->route('ver_finanzas')->with('success', 'Fianza creada exitosamente.');
    }

    public function procesarPagos(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'fianzas' => 'required|string',
        ]);
    
        $fianzaNuFianzas = explode(',', $request->input('fianzas'));
    
        try {
            // Iniciar una transacción para asegurar la integridad de los datos
            DB::transaction(function () use ($fianzaNuFianzas) {
                // Obtener el ID del usuario asociado con las fianzas
                $usuarioId = $this->obtenerUsuarioIdParaFianzas($fianzaNuFianzas);
                $usuario = User::findOrFail($usuarioId);
    
                // Crear una nueva factura
                $factura = $this->crearFactura($usuarioId, $fianzaNuFianzas);
    
                // Asociar las fianzas con la factura y actualizar el estado de las fianzas
                $this->asociarFianzasConFactura($factura, $fianzaNuFianzas);
    
                // Generar el PDF de la factura
                $pdf = $this->generarPDF($factura, $usuario, $fianzaNuFianzas);
    
                // Enviar el correo con el PDF adjunto
                $this->enviarCorreo($usuario, $pdf, $factura);
    
            });
    
            return redirect()->route('crear_pago')->with('success', 'Las fianzas seleccionadas han sido marcadas como pagadas y la factura ha sido generada y enviada.');
        } catch (\Exception $e) {
            Log::error('Error procesando pagos: ' . $e->getMessage());
            return redirect()->route('crear_pago')->withErrors(['error' => 'Hubo un problema al procesar los pagos. Por favor, inténtelo de nuevo.']);
        }
    }
    
    private function obtenerUsuarioIdParaFianzas(array $fianzaNuFianzas)
    {
        return Fianza::whereIn('nu_fianza', $fianzaNuFianzas)->firstOrFail()->user_id;
    }
    
    private function crearFactura($usuarioId, array $fianzaNuFianzas)
    {
        return Factura::create([
            'user_id' => $usuarioId,
            'fecha' => now(),
            'descripcion' => 'Factura para fianzas: ' . implode(', ', $fianzaNuFianzas),
            'total' => Fianza::whereIn('nu_fianza', $fianzaNuFianzas)->sum('precio'),
        ]);
    }
    
    private function asociarFianzasConFactura(Factura $factura, array $fianzaNuFianzas)
    {
        foreach ($fianzaNuFianzas as $nuFianza) {
            $fianza = Fianza::where('nu_fianza', $nuFianza)->firstOrFail();
            $fianza->update(['estado' => true]);
    
            DB::table('factura_fianza')->insert([
                'factura_id' => $factura->id,
                'fianza_id' => $fianza->nu_fianza,
                'precio' => $fianza->precio,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    private function generarPDF(Factura $factura, User $usuario, array $fianzaNuFianzas)
    {
        $fianzas = Fianza::whereIn('nu_fianza', $fianzaNuFianzas)->with('productos')->get();
        $fianzasConProductos = $fianzas->map(function ($fianza) {
            return [
                'fianza' => $fianza,
                'productos' => $fianza->productos,
            ];
        });

        return FacadePdf::loadView('Facturas.pdf_pago', [
            'factura' => $factura,
            'usuario' => $usuario,
            'fianzasConProductos' => $fianzasConProductos,
        ]);
    }
    
    private function enviarCorreo(User $usuario, $pdf, Factura $factura)
    {
        Mail::to($usuario->email)
            ->send(new FacturaMail($pdf->output(), $factura, $usuario));
    }
}