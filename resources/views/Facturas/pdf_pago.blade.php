<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1, h2, h3, h4 {
            text-align: center;
            color: #333;
        }

        .header, .footer {
            text-align: center;
        }

        .table-container {
            width: 100%;
            margin-top: 20px;
        }

        .table-container table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .table-container th, .table-container td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-container th {
            background-color: #f2f2f2;
        }

        .sublogo {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            margin-bottom: 20px;
        }

        .sublogo .logo {
            text-align: center;
        }

        .sublogo img {
            width: 100px;
            height: auto;
        }

        .factura-info {
            margin-bottom: 20px;
            text-align: center;
        }

        .factura-info h3 {
            margin: 0;
            font-size: 16px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 4px 0;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .product-table th, .product-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .invoice-section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>FUERZAS MILITARES DE COLOMBIA</h2>
        <h2>EJÉRCITO DE COLOMBIA</h2>
    </div>

    <div class="sublogo">
        <img src="{{ public_path('img/logo_pago.png') }}" alt="Logo" style="width: 100%; height: auto;" />
    </div>
    
    <div class="factura-info">
        <h3><strong>Número de Factura:</strong> {{ $factura->id }}</h3>
        <h3><strong>Fecha:</strong> {{ $factura->fecha->format('d/m/Y') }}</h3>
    </div>
    
    <h2>Información del Cliente</h2>
    <div class="details">
        <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
        <p><strong>Dirección:</strong> {{ $usuario->direccion_residencia }}</p>
        <p><strong>Teléfono:</strong> {{ $usuario->numero_telefono }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $usuario->correo_electronico }}</p>
    </div>

    <h2>Fianzas Pagadas</h2>
    <div class="table-container">
        @foreach ($fianzasConProductos as $item)
            @php
                $fianza = $item['fianza'];
                $productos = $item['productos'];
            @endphp

            <div class="invoice-section">
                <h3>Fianza #{{ $fianza->nu_fianza }}</h3>
                <p><strong>Descripción:</strong> {{ $fianza->descripcion }}</p>
                <p><strong>Precio:</strong> {{ number_format($fianza->precio, 2, ',', '.') }} COP</p>
                
                <h4>Productos</h4>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pivot->cantidad }}</td>
                                <td>{{ number_format($producto->precio, 2, ',', '.') }} COP</td>
                                <td>{{ number_format($producto->pivot->cantidad * $producto->precio, 2, ',', '.') }} COP</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Gracias por su preferencia.</p>
    </div>
</body>
</html>