@extends('plantilla')

<!-- Estilos CSS Importados -->
@section('estilos')
{{ asset('css/tablas.css') }}
@stop

<!-- Título del Panel -->
@section('tittle')
{{ 'Productos' }}
@stop

@section('descripcion')
{{ 'Aquí puedes ver todos los productos registrados' }}
@stop

<!-- Nombres Botones Importados -->
@section('button_one')
{{ 'Crear Producto' }}
@stop

<!-- Links de Botones Importados -->
@section('link_1')
{{ route('crear_productos') }}
@stop

@section('seccion')
<div class="tabla">
    <input class="form" id="myInput" type="text" placeholder="Buscar ...">
    <div class="edit_delete">
        <button id="editSelectedProduct" class="botones3" type="button">Editar Producto</button>
        <button id="deleteSelectedProduct" class="botones3" type="button">Eliminar Producto</button>
    </div>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody id="myTable">
            @foreach($productos as $producto)
                <tr>
                    <td>
                        <div class="checkbox-wrapper-23">
                            <input type="checkbox" id="check-{{ $producto->id }}" name="selected_products[]" value="{{ $producto->id }}" />
                            <label for="check-{{ $producto->id }}" style="--size: 20px">
                                <svg viewBox="0,0,50,50">
                                    <path d="M5 30 L 20 45 L 45 5"></path>
                                </svg>
                            </label>
                        </div>
                    </td>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script>
    document.getElementById('editSelectedProduct').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
        if (checkedBoxes.length === 1) {
            const productId = checkedBoxes[0].value;
            // Redirige a la URL de edición del producto seleccionado
            window.location.href = `/productos/${productId}/edit`;
        } else {
            alert('Por favor, selecciona un solo producto para editar.');
        }
    });

    document.getElementById('deleteSelectedProduct').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_products[]"]:checked');
        if (checkedBoxes.length > 0) {
            const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value).join(',');
            // Redirige a la URL de eliminación de productos seleccionados
            window.location.href = `/productos/delete/${ids}`;
        } else {
            alert('Por favor, selecciona al menos un producto para eliminar.');
        }
    });

    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection