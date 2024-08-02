<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserInfo()
    {
        $usuario = auth()->user(); // Obtén el usuario autenticado

        // Si necesitas pasar más datos al view
        $userName = $usuario->nombre;
        $userType = $usuario->tipo_usuario; // Asumiendo que "tipo_usuario" almacena el rol

        return view('plantilla', compact('userName', 'userType'));
    }

    public function index()
    {
        $usuarios = User::all(); // 
        return view('Usuarios.ver_usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_documento' => 'required|string|max:20|unique:users', // s
            'email' => 'required|email|unique:users', // s
            'numero_telefono' => 'required|string|max:15',
            'direccion_residencia' => 'required|string|max:255',
            'numero_secundario' => 'nullable|string|max:15',
            'numero_terciario' => 'nullable|string|max:15',
            'tipo_usuario' => 'required|string|in:admin,cliente',
            'password' => 'nullable|string|min:6', // Validación opcional para contraseña
        ]);

        // Crear un nuevo usuario en la base de datos
        $usuarioData = [
            'nombre' => $request->input('nombre'),
            'numero_documento' => $request->input('numero_documento'),
            'email' => $request->input('email'),
            'numero_telefono' => $request->input('numero_telefono'),
            'direccion_residencia' => $request->input('direccion_residencia'),
            'numero_secundario' => $request->input('numero_secundario'),
            'numero_terciario' => $request->input('numero_terciario'),
            'tipo_usuario' => $request->input('tipo_usuario'),
        ];

        if ($request->input('tipo_usuario') === 'admin') {
            $usuarioData['password'] = bcrypt($request->input('password'));
        }

        User::create($usuarioData); // 

        // Redirigir a la vista de creación con un mensaje de éxito
        return redirect()->route('ver_usuarios')->with('success', 'Usuario creado exitosamente.');
    }

    public function editar($id)
    {
        $usuario = User::findOrFail($id); // s
        return view('Usuarios.editar_usuario', compact('usuario'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_documento' => 'required|string|max:20|unique:users,numero_documento,' . $id, // s
            'email' => 'required|email|unique:users,email,' . $id, // s
            'numero_telefono' => 'required|string|max:15',
            'direccion_residencia' => 'required|string|max:255',
            'numero_secundario' => 'nullable|string|max:15',
            'numero_terciario' => 'nullable|string|max:15',
            'tipo_usuario' => 'required|string|in:admin,cliente',
            'password' => 'nullable|string|min:6', // Validación opcional para contraseña
        ]);

        $usuario = User::findOrFail($id); // 
        $usuarioData = [
            'nombre' => $request->input('nombre'),
            'numero_documento' => $request->input('numero_documento'),
            'email' => $request->input('email'),
            'numero_telefono' => $request->input('numero_telefono'),
            'direccion_residencia' => $request->input('direccion_residencia'),
            'numero_secundario' => $request->input('numero_secundario'),
            'numero_terciario' => $request->input('numero_terciario'),
            'tipo_usuario' => $request->input('tipo_usuario'),
        ];

        if ($request->input('tipo_usuario') === 'admin' && $request->filled('password')) {
            $usuarioData['password'] = bcrypt($request->input('password'));
        }

        $usuario->update($usuarioData); // 

        return redirect()->route('ver_usuarios')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function eliminarUsuarios(Request $request)
    {
        $ids = $request->query('ids');
        $idsArray = explode(',', $ids);

        try {
            User::whereIn('id', $idsArray)->delete(); // 
            Session::flash('message', 'Usuarios eliminados exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Hubo un problema al eliminar los usuarios.');
        }

        return redirect()->route('ver_usuarios');
    }

    
    // Método para buscar usuarios y proporcionar autocompletado
    public function buscarUsuarios(Request $request)
    {
        $term = $request->get('term');
        $usuarios = User::where('numero_documento', 'LIKE', '%' . $term . '%')->get();

        $results = [];
        foreach ($usuarios as $usuario) {
            $results[] = [
                'value' => $usuario->numero_documento,
                'nombre' => $usuario->nombre,
                'correo' => $usuario->email,
                'telefono' => $usuario->numero_telefono,
            ];
        }

        return response()->json($results);
    }

    // Método para obtener un usuario por cédula
    public function getUsuarioByCedula($cedula)
    {
        $usuario = User::where('numero_documento', $cedula)->first();

        if ($usuario) {
            return response()->json($usuario);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    
}