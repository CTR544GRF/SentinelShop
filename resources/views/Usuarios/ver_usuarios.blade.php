@extends('plantilla')

<!-- Estilos CSS Importados -->
@section('estilos')
{{ asset('css/tablas.css') }}
@stop

<!-- Título del Panel -->
@section('tittle')
{{ 'Usuarios' }}
@stop

@section('descripcion')
{{ 'Aquí puedes ver todos los usuarios creados' }}
@stop

<!-- Nombres Botones Importados -->
@section('button_one')
{{ 'Crear Usuario' }}
@stop

<!-- Links de Botones Importados -->
@section('link_1')
{{ route('crear_usuarios') }}
@stop

@section('seccion')
<div class="tabla">
    <input class="form" id="myInput" type="text" placeholder="Buscar ...">
    <div class="edit_delete">
        <button id="editSelectedUser" class="botones3" type="button">Editar Usuario</button>
        <button id="deleteSelectedUser" class="botones3" type="button">Eliminar Usuario</button>
    </div>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Nu. Documento</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Número Teléfono</th>
                <th>Número Secundario</th>
                <th>Número Terciario</th>
                <th>Tipo de Usuario</th> <!-- Nueva columna para el tipo de usuario -->
            </tr>
        </thead>
        <tbody id="myTable">
            @foreach ($usuarios as $index => $usuario)
            <tr>
                <td>
                    <div class="checkbox-wrapper-23">
                        <input type="checkbox" id="check-{{ $index }}" name="selected_users[]" value="{{ $usuario->id }}" />
                        <label for="check-{{ $index }}" style="--size: 20px">
                            <svg viewBox="0,0,50,50">
                                <path d="M5 30 L 20 45 L 45 5"></path>
                            </svg>
                        </label>
                    </div>
                </td>
                <td data-label="Nu. Documento">{{ $usuario->numero_documento }}</td>
                <td data-label="Nombre">{{ $usuario->nombre }}</td>
                <td data-label="Correo Electrónico">{{ $usuario->email }}</td>
                <td data-label="Número Teléfono">{{ $usuario->numero_telefono }}</td>
                <td data-label="Número Secundario">{{ $usuario->numero_secundario }}</td>
                <td data-label="Número Terciario">{{ $usuario->numero_terciario }}</td>
                <td data-label="Tipo de Usuario">{{ $usuario->tipo_usuario }}</td> <!-- Nueva celda para el tipo de usuario -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

<script>
    document.getElementById('editSelectedUser').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_users[]"]:checked');
        if (checkedBoxes.length === 1) {
            const userId = checkedBoxes[0].value;
            window.location.href = `/usuarios/${userId}/edit`;
        } else {
            alert('Por favor, selecciona un solo usuario para editar.');
        }
    });

    document.getElementById('deleteSelectedUser').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_users[]"]:checked');
        if (checkedBoxes.length > 0) {
            const userIds = Array.from(checkedBoxes).map(box => box.value);
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Se eliminarán ${userIds.length} usuario(s).`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige a la ruta de eliminación con los IDs seleccionados
                    window.location.href = `/usuarios/delete?ids=${userIds.join(',')}`;
                }
            });
        } else {
            alert('Por favor, selecciona al menos un usuario para eliminar.');
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