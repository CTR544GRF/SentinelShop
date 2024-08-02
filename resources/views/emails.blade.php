<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1, h2, h3 {
            color: #2c3e50;
        }
        p {
            margin: 8px 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .details, .fianzas {
            margin-top: 20px;
        }
        .fianzas h3 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factura de Pago</h1>
        <p>Hola {{ $usuario->nombre }},</p>
        <p>Adjunto encontrarás la factura correspondiente a las fianzas pagadas.</p>

        <div class="details">
            <h2>Detalles de la Factura</h2>
            <p><strong>Número de Factura:</strong> {{ $factura->id }}</p>
            <p><strong>Fecha:</strong> {{ $factura->fecha->format('d/m/Y') }}</p>
        </div>

        <div class="details">
            <h2>Información del Cliente</h2>
            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
            <p><strong>Dirección:</strong> {{ $usuario->direccion_residencia }}</p>
            <p><strong>Teléfono:</strong> {{ $usuario->numero_telefono }}</p>
            <p><strong>Correo Electrónico:</strong> {{ $usuario->correo_electronico }}</p>
        </div>

        <div class="fianzas">
            <h2>Fianzas Pagadas</h2>
            @foreach ($factura->fianzas as $fianza)
                <h3>Fianza {{ $fianza->nu_fianza }}</h3>
                <p><strong>Descripción:</strong> {{ $fianza->descripcion }}</p>
                <p><strong>Precio:</strong> {{ number_format($fianza->precio, 2, ',', '.') }} </p>
                <h4>Productos asociados</h4>
                <ul>
                    @foreach ($fianza->productos as $producto)
                        <li>{{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }} - Precio: {{ number_format($producto->precio, 2, ',', '.') }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>

        <p>Gracias por tu preferencia.</p>
    </div>
</body>
</html>