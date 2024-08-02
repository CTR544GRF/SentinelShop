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
        <form class="inicio_sesion" method="POST" action="{{ route('password.email') }}">
            @csrf
            <h3>SentinelShop</h3>
            <hr class="form_line"> 

            <div class="form_group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" class="from_input" placeholder="Ingrese su correo electrónico" name="email" required autofocus>
            </div>

            <button type="submit">Recuperar Contraseña</button>
        </form>
    </div>
</body>
</html>