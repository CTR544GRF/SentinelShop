@extends ('plantilla')

<!-- Estilos CSS -->
@section('estilos')
{{ asset('css/usuarios.css') }}
@stop

<!-- Título del Panel -->
@section('tittle')
{{ 'Crear Producto' }}
@stop

@section('descripcion')
{{ 'Aquí puedes ingresar los detalles del nuevo producto' }}
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
<form class="registrar_producto" action="{{ route('guardar_producto') }}" method="POST">
    @csrf
    <div class="formulario">
        <h2 class="titulo">Datos del Producto</h2>
        <div class="first_dates">
            <div class="form_group_1">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" class="from_input" placeholder="Ingrese el código del producto" name="codigo" required>
            </div>
            <div class="form_group_1">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" class="from_input" placeholder="Ingrese el nombre del producto" name="nombre" required>
            </div>
            <div class="form_group_1">
                <label for="precio">Precio</label>
                <input type="number" id="precio" class="from_input" placeholder="Ingrese el precio del producto" name="precio" step="0.01" required>
            </div>
        </div>
        <button class="botones2" type="submit">Crear Producto</button>
    </div>
</form>
@endsection