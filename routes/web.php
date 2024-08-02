<?php

use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FianzaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Ruta para la vista de login
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    // Ruta para ver finanzas
    Route::view('/Finanzas/Ver', 'Finanzas.ver_finanzas')->name('ver_finanzas');
    Route::get('/dashboard', [FianzaController::class, 'index'])->name('ver_finanzas');
    Route::get('/usuario-info', [UserController::class, 'getUserInfoByCedula'])->name('usuario_info');
    
    // Otras rutas autenticadas
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //rutas de fianzas
    Route::get('/Finanzas/Crear', [FianzaController::class, 'create'])->name('crear_finanzas');
    Route::get('/Pagos/Crear', [FianzaController::class, 'index_two'])->name('crear_pago');
    Route::post('/procesar-pagos', [FianzaController::class, 'procesarPagos'])->name('procesar_pagos');
    
    // Rutas Usuarios - solo accesible por administradores

    Route::get('/Usuarios/Ver', [UserController::class, 'index'])->name('ver_usuarios');
    Route::view('/Usuarios/Crear', 'Usuarios.crear_usuarios')->name('crear_usuarios');
    Route::post('/Usuarios', [UserController::class, 'store'])->name('store_usuario');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'editar'])->name('editar_usuario');
    Route::put('/Usuarios/{id}', [UserController::class, 'update'])->name('update_usuario');
    Route::get('/usuarios/delete', [UserController::class, 'eliminarUsuarios'])->name('eliminar_usuarios');
    
    // Ruta para manejar la solicitud POST del formulario de creación
    Route::post('/finanzas/crear', [FianzaController::class, 'store'])->name('store_finanzas');
    
    // Ruta para autocompletado de cédulas
Route::get('/usuarios/autocomplete', [UserController::class, 'buscarUsuarios'])->name('usuarios.autocomplete');

// Ruta para obtener un usuario por cédula (si lo necesitas para otro propósito)
Route::get('/usuarios/{cedula}', [UserController::class, 'getUsuarioByCedula'])->name('usuario.info');


// Rutas Productos - solo accesible por administradores

    Route::view('/Productos/Crear', 'Productos.crear_productos')->name('crear_productos');
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('crear_productos');
    Route::post('/productos', [ProductoController::class, 'store'])->name('guardar_producto');
    Route::get('/Productos/Ver', [ProductoController::class, 'index'])->name('ver_productos');
    Route::get('/productos/{id}', [ProductoController::class, 'getProducto']);
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('editar_producto');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('update_producto');
    Route::get('/productos/delete/{ids}', [ProductoController::class, 'delete'])->name('delete_productos');


// Función para autenticación Código
Route::post('/send-security-code', [FianzaController::class, 'sendSecurityCode']);

// Factura
Route::view('/pdf', 'Facturas.pdf_pago')->name('factura_pdfd');

Route::get('/sidebar', [UserController::class, 'getUserInfo']);

// Rutas de Facturas
Route::get('/Facturas', [FacturaController::class, 'index'])->name('ver_facturas');
Route::post('/facturas/generar', [FacturaController::class, 'generarFacturasCobro'])->name('generar_factura_cobro');
Route::get('/facturas/generar', [FacturaController::class, 'showGenerarFactura'])->name('generar_factura_cobro');

});

// Incluir rutas de autenticación
require __DIR__.'/auth.php';