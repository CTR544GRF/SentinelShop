@extends('plantilla')

<!-- Estilos CSS Importados -->
@section('estilos')
{{ asset('css/tablas.css') }}
@stop

<!-- Título del Panel -->
@section('tittle')
{{ 'Facturas' }}
@stop

@section('descripcion')
{{ 'Aquí puedes ver todas las facturas' }}
@stop

@section('button_one')
{{ 'Facturas de Cobro' }}
@stop

@section('link_1')
{{ route('generar_factura_cobro') }}
@stop

@section('seccion')
<div class="tabla">
    <table>
        <thead>
            <tr>
                <th>Num. Factura</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $factura)
            <tr>
                <td>{{ $factura->id }}</td>
                <td>{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                <td>{{ $factura->user->nombre }}</td>
                <td>{{ $factura->user->numero_telefono }}</td>
                <td>{{ $factura->user->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection