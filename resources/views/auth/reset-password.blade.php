<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="contenedor">
        <form class="inicio_sesion" method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <h3>SentinelShop</h3>
            <hr class="form_line"> 

            <!-- Email Address -->
            <div class="form_group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" class="from_input" placeholder="Ingrese su correo electrónico" name="email" value="{{ old('email', $request->email) }}" required autofocus>
            </div>

            <!-- Password -->
            <div class="form_group">
                <label for="password">Nueva Contraseña</label>
                <input type="password" id="password" class="from_input" placeholder="Ingrese su nueva contraseña" name="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="form_group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" class="from_input" placeholder="Confirme su nueva contraseña" name="password_confirmation" required>
            </div>

            <button type="submit">Restablecer Contraseña</button>
        </form>
    </div>
</body>
</html>