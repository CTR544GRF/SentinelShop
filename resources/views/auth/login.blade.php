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

            @if ($errors->any())
                <div class="error">
                    <strong>¡Ups! Algo salió mal.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form_group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="email" class="from_input" placeholder="Ingrese su correo electrónico" name="email" value="{{ old('correo') }}" required>
                @error('correo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form_group">
                <label class="from_label" for="contrasena">Contraseña</label>
                <input type="password" id="password" class="from_input" placeholder="Ingrese su contraseña" name="password" required>
                @error('contrasena')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Iniciar Sesión</button>

            <div class="form_group">
                <a id="form_rc" href="{{ route('password.request') }}">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </div>
</body>
@if ($errors->any())
    <div class="error">
        <strong>¡Ups! Algo salió mal.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</html>