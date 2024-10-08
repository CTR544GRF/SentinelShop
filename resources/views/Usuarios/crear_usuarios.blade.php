@extends('plantilla')

@section('estilos')
{{ asset('css/usuarios.css') }}
@stop

@section('tittle')
{{ 'Usuarios' }}
@stop

@section('descripcion')
{{ 'Aquí puedes crear tus Usuarios' }}
@stop

@section('button_one')
{{ 'Ver Usuarios' }}
@stop
@section('link_1')
{{ route('ver_usuarios') }}
@stop
@section('seccion')
<div class="formulario">
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('store_usuario') }}" method="POST">
    @csrf
    <h2 class="titulo">Datos Personales</h2>
    
    <div class="first_dates">
        <!-- Campos de datos personales -->
        <div class="form_group">
            <label for="numero_documento">Número de Cédula</label>
            <input type="text" id="numero_documento" class="from_input" placeholder="Ingrese su número de cédula" name="numero_documento" required>
        </div>
        <div class="form_group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" class="from_input" placeholder="Ingrese su correo electrónico" name="email" required>
        </div>
        <div class="form_group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" class="from_input" placeholder="Ingrese su nombre completo" name="nombre" required>
        </div>
        <div class="form_group">
            <label for="direccion_residencia">Dirección de Residencia</label>
            <input type="text" id="direccion_residencia" class="from_input" placeholder="Ingrese su dirección de residencia" name="direccion_residencia" required>
        </div>
        <div class="form_group">
            <label for="numero_telefono">Número de Teléfono</label>
            <input type="text" id="numero_telefono" class="from_input" placeholder="Ingrese su número de teléfono" name="numero_telefono" required>
        </div>
        <div class="form_group">
            <label for="tipo_usuario">Tipo de Usuario</label>
            <select id="tipo_usuario" name="tipo_usuario" required onchange="togglePasswordField(this)">
                <option value="cliente">Cliente</option>
                <option value="admin">Admin</option>
            </select>
        </div>

            <!-- Campo de contraseña -->
        <div class="form_group" id="password_field" style="display: none;">
            <label for="contraseña">Contraseña</label>
            <input type="password" id="contraseña" class="from_input" placeholder="Ingrese una contraseña" name="contraseña">
        </div>
    </div>

    
    
    <h2 class="titulo">Datos de Autorización</h2>
    <div class="datos_autorisar">
        <!-- Campos adicionales -->
        <div class="form_group">
            <label for="numero_secundario">Número Secundario</label>
            <input type="text" id="numero_secundario" class="from_input" placeholder="Ingrese su número secundario" name="numero_secundario">
        </div>
        <div class="form_group">
            <label for="numero_terciario">Número Terciario</label>
            <input type="text" id="numero_terciario" class="from_input" placeholder="Ingrese su número terciario" name="numero_terciario">
        </div>
        

    </div>
    
    <button class="botones2" type="submit">Crear Usuario</button>
</form>

<script>
function togglePasswordField(selectElement) {
    var passwordField = document.getElementById('password_field');
    if (selectElement.value === 'admin') {
        passwordField.style.display = 'block';
    } else {
        passwordField.style.display = 'none';
    }
}
</script>

</div>
@endsection