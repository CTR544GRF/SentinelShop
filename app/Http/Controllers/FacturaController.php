<?php

namespace App\Http\Controllers;

use App\Mail\FacturaMailV2;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Fianza;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;

class FacturaController extends Controller
{
// Funcion para enviar datos a la tabla de facturas
    public function index()
    {
        $facturas = Factura::with('user')->get(); // Usa la relación 'user'

        // Verifica si alguna factura no tiene un usuario asociado
        foreach ($facturas as $factura) {
            if (!$factura->user) {
                Log::warning('Factura sin usuario asociado: ' . $factura->id);
            }
        }

        return view('Facturas.ver_facturas', compact('facturas'));
    }

    public function showGenerarFactura()
    {
        $fianzas = Fianza::where('estado', false)->get(); // Solo fianzas por pagar
        return view('Facturas.facturas_cobro', compact('fianzas'));
    }

    public function generarFacturasCobro(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'fianzas' => 'required|string',
        ]);

        // Obtener los IDs de las fianzas desde el request
        $fianzasIds = explode(',', $request->input('fianzas'));

        // Obtener las fianzas pendientes que coincidan con los IDs proporcionados
        $fianzasPendientes = Fianza::whereIn('nu_fianza', $fianzasIds)->where('estado', false)->get();

        // Agrupar las fianzas por ID de usuario
        $fianzasAgrupadas = $fianzasPendientes->groupBy('user_id');

        // Iterar sobre cada grupo de fianzas agrupadas por usuario
        foreach ($fianzasAgrupadas as $userId => $fianzas) {
            // Obtener el usuario asociado con el ID
            $user = User::find($userId);

            if (!$user) {
                Log::warning('Usuario no encontrado para ID: ' . $userId);
                continue; // O maneja el caso como prefieras
            }

            // Obtener los números de fianza
            $fianzaNuFianzas = $fianzas->pluck('nu_fianza')->toArray();

            // Crear una nueva factura
            $factura = $this->crearFactura($userId, $fianzaNuFianzas);

            // Asociar las fianzas con la factura
            $this->asociarFianzasConFactura($factura, $fianzaNuFianzas);

            // Generar el PDF para la factura
            $pdf = $this->generarPDF($factura, $user, $fianzaNuFianzas);

            // Enviar el correo con el PDF adjunto
            $this->enviarCorreo($user, $pdf, $factura, $fianzaNuFianzas);
        }

        // Redirigir a la ruta 'generar_factura_cobro' con un mensaje de éxito
        return redirect()->route('generar_factura_cobro')->with('success', 'Facturas generadas correctamente.');
    }

    private function obtenerUsuarioIdParaFianzas(array $fianzaNuFianzas)
    {
        return Fianza::whereIn('nu_fianza', $fianzaNuFianzas)->firstOrFail()->usuario_id;
    }

    private function crearFactura($userId, array $fianzaNuFianzas)
    {
        return Factura::create([
            'user_id' => $userId,
            'fecha' => now(),
            'descripcion' => 'Factura para fianzas: ' . implode(', ', $fianzaNuFianzas),
            'total' => Fianza::whereIn('nu_fianza', $fianzaNuFianzas)->sum('precio'),
        ]);
    }

    private function asociarFianzasConFactura(Factura $factura, array $fianzaNuFianzas)
    {
        foreach ($fianzaNuFianzas as $nuFianza) {
            $fianza = Fianza::where('nu_fianza', $nuFianza)->firstOrFail();
            
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

        return FacadePdf::loadView('Facturas.pdf_cobro', [
            'factura' => $factura,
            'usuario' => $usuario,
            'fianzasConProductos' => $fianzasConProductos,
        ]);
    }

    private function enviarCorreo(User $usuario, $pdf, Factura $factura, array $fianzaNuFianzas)
    {
        Mail::to($usuario->email)
            ->send(new FacturaMailV2($pdf->output(), $factura, $usuario, $fianzaNuFianzas));
    }
    
}