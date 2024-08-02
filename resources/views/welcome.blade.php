<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="contenedor">
        <form class="inicio_sesion" action="{{ url('login') }}" method="POST">
            @csrf
            <h3>SentinelShop</h3>
            <hr class="form_line">

            <div class="form_group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" class="from_input" placeholder="Ingrese su correo electrónico" name="correo" required>
            </div>

            <div class="form_group">
                <label class="from_label" for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" class="from_input" placeholder="Ingrese su contraseña" name="contrasena" required>
            </div>

            <button type="submit">Iniciar Sesión</button>

            <div class="form_group">
                <a id="form_rc" href="{{ route('password_recovery') }}">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </div>
</body>
</html>