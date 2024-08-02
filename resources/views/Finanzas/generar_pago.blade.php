@extends('plantilla')

@section('estilos')
{{ asset('css/tablas.css') }}
@stop

@section('tittle')
{{ 'Pagos' }}
@stop
@section('descripcion')
{{ 'Aquí puedes Crear los Pagos de tus clientes' }}
@stop

@section('button_one')
{{ 'Crear Fianza' }}
@stop
@section('button_two')
{{ 'Generar Pago' }}
@stop
@section('button_three')
{{ 'Ver' }}
@stop

@section('link_1')
{{ route('crear_finanzas') }}
@stop
@section('link_2')
{{ route('crear_pago') }}
@stop
@section('link_3')
{{ route('ver_finanzas') }}
@stop

@section('seccion')

    <!-- Mostrar mensajes de éxito o error -->
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

    <input class="form" id="myInput" type="text" placeholder="Buscar ...">

    <div class="tabla">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Nu. Finanza</th>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Precio</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="">
                @foreach($fianzas as $index => $fianza)
                    <tr>
                        <td>
                            <div class="checkbox-wrapper-23">
                                <input type="checkbox" id="check-{{ $index }}" value="{{ $fianza->nu_fianza }}" />
                                <label for="check-{{ $index }}" style="--size: 20px">
                                    <svg viewBox="0,0,50,50">
                                        <path d="M5 30 L 20 45 L 45 5"></path>
                                    </svg>
                                </label>
                            </div>
                        </td>
                        <td>{{ $fianza->nu_fianza }}</td>
                        <td>{{ $fianza->fecha }}</td>
                        <td>{{ $fianza->nombre }} {{ $fianza->apellido }}</td>
                        <td>{{ $fianza->telefono }}</td>
                        <td>{{ $fianza->precio }}</td>
                        <td>{{ $fianza->estado ? 'Pagado' : 'Por Pagar' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón para procesar pagos -->
        <form action="{{ route('procesar_pagos') }}" method="POST">
            @csrf
            <input type="hidden" id="fianzas" name="fianzas">
            <button class="botones2" type="submit">Procesar Pagos</button>
        </form>
    </div>

    <!-- Script para busqueda en las tablas -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Manejo de selección de checkboxes
            $('input[type="checkbox"]').on('change', function() {
                var selectedFianzas = [];
                $('input[type="checkbox"]:checked').each(function() {
                    selectedFianzas.push($(this).val());
                });
                $('#fianzas').val(selectedFianzas.join(',')); // Unir los valores con una coma
                console.log('Seleccionadas:', selectedFianzas); // Verifica los valores seleccionados
                console.log('Valor del campo oculto:', $('#fianzas').val()); // Verifica el valor del campo oculto
            });
        });
    </script>
@stop