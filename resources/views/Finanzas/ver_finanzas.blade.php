@extends ('plantilla')

<!-- Estilos CSS Importados -->
@section('estilos')
{{asset('css/tablas.css')}}
@stop

<!-- Titulo del Panel -->
@section('tittle')
{{'Panel'}}
@stop
@section('descripcion')
{{'Aqui puedes ver las fianzas de tus clientes'}}
@stop

<!-- Nombres Botones Importados -->
@section('button_one')
{{'Crear Fianza'}}
@stop
@section('button_two')
{{'Generar Pago'}}
@stop
@section('button_three') {{'Ver'}} @stop

<!-- Links de Botones Importados -->
@section('link_1') {{ route('crear_finanzas')}} @stop
@section('link_2') {{ route('crear_pago')}} @stop
@section('link_3') {{ route('ver_finanzas')}} @stop

@section('seccion')
    <input class="form" id="myInput" type="text" placeholder="Buscar ...">
    <div class="tabla">
        <table id="">
                <thead>
                    <tr>
                        <th>Nu. Finanza</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Precio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    @foreach($fianzas as $fianza)
                        <tr>
                            <td>{{ $fianza->nu_fianza }}</td>
                            <td>{{ $fianza->fecha }}</td>
                            <td>{{ $fianza->nombre }}</td>
                            <td>{{ $fianza->telefono }}</td>
                            <td>{{ $fianza->precio }}</td>
                            <td>{{ $fianza->estado ? 'Pagado' : 'Por Pagar' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Script para busqueda en las tablas -->
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#myInput").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#myTable tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>
    </div>
        
@stop