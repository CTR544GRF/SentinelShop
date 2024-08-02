<!DOCTYPE html>
<html>
<head>
    <title>Factura de Pago</title>
</head>
<body>
    <h1>Factura de Cobro</h1>
    <p>Hola {{ $usuario->nombre }},</p>
    <p>Adjunto encontrarás la factura correspondiente a las fianzas sin pagar .</p>

    <h2>Detalles de la Factura</h2>
    <p><strong>Número de Factura:</strong> {{ $factura->id }}</p>
    <p><strong>Fecha:</strong> {{ $factura->fecha->format('d/m/Y') }}</p>

    <h2>Información del Cliente</h2>
    <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
    <p><strong>Dirección:</strong> {{ $usuario->direccion_residencia }}</p>
    <p><strong>Teléfono:</strong> {{ $usuario->numero_telefono }}</p>
    <p><strong>Correo Electrónico:</strong> {{ $usuario->correo_electronico }}</p>

    <h2>Fianzas Sin Pagar</h2>
    @foreach ($fianzaNuFianzas as $nuFianza)
        @php
            $fianza = App\Models\Fianza::where('nu_fianza', $nuFianza)->first();
        @endphp
        <h3>Fianza {{ $fianza->nu_fianza }}</h3>
        <p><strong>Descripción:</strong> {{ $fianza->descripcion }}</p>
        <p><strong>Precio:</strong> {{ $fianza->precio }}</p>
    @endforeach

    <p>Gracias por tu preferencia.</p>
</body>
</html>