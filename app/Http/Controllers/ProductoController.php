<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  Funcion Idex Trae los datos de la base de datos 
    public function index()
    {
        $productos = Producto::all();
        return view('Productos.ver_productos', compact('productos')); 
    }

    public function getProducto($id)
    {
        $producto = Producto::find($id);
        return response()->json($producto);
    }
    // Muestra el formulario para editar un producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('Productos.editar_productos', compact('producto'));
    }

    // Actualiza un producto en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|max:255|unique:productos,codigo,' . $id,
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('ver_productos')->with('success', 'Producto actualizado correctamente.');
    }

    // Elimina uno o más productos
    public function delete($ids)
    {
        $idsArray = explode(',', $ids);
        Producto::destroy($idsArray);
    
        return redirect()->route('ver_productos')->with('success', 'Productos eliminados exitosamente.');
    }

    public function create()
    {
        return view('Productos/crear_productos');
    }

    // Guarda un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:255|unique:productos',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        Producto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'precio' => $request->precio,
        ]);

        return redirect()->route('ver_productos')->with('success', 'Producto creado exitosamente.');
    }
}
