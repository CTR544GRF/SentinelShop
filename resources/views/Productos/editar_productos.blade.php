@extends('plantilla')

<!-- Estilos CSS -->
@section('estilos')
{{ asset('css/usuarios.css') }}
@stop

<!-- Título del Panel -->
@section('tittle')
{{ 'Editar Producto' }}
@stop

@section('descripcion')
{{ 'Aquí puedes editar los detalles del producto' }}
@stop

<!-- Nombres Botones Importados -->
@section('button_one')
{{ 'Ver Productos' }}
@stop

<!-- Links de Botones Importados -->
@section('link_1')
{{ route('ver_productos') }}
@stop

@section('seccion')
<form class="registrar_finanaza" action="{{ route('update_producto', $producto->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="formulario">
        <h2 class="titulo">Editar Producto</h2>
        <div class="first_dates">
            <div class="form_group_1">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" class="from_input" placeholder="Ingrese el código" name="codigo" value="{{ old('codigo', $producto->codigo) }}" required>
            </div>
            <div class="form_group_1">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" class="from_input" placeholder="Ingrese el nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>
            <div class="form_group_1">
                <label for="precio">Precio</label>
                <input type="text" id="precio" class="from_input" placeholder="Ingrese el precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
            </div>
        </div>
        
        <button class="botones2" type="submit">Actualizar Producto</button>
    </div>
</form>
@endsection