@extends ('plantilla')
<!-- Estilos CSS -->
@section('estilos')
{{asset('css/usuarios.css')}}
@stop

<!-- Titulo del Panel -->
@section('tittle')
{{'Pagos'}}
@stop
@section('descripcion')
{{'Aqui puedes Crear los Pagos de tus clientes'}}
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

<form class="registrar_finanaza" action="{{ route('store_finanzas') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="formulario">
        <h2 class="titulo">Datos Personales</h2>

        <div class="first_dates">
            <div class="form_group">
                <label for="cedula">Nu. Cedula</label>
                <input type="text" id="cedula" class="from_input" placeholder="Ingrese su número de cédula" name="cedula" required>
            </div>
            <div class="form_group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" class="from_input" placeholder="Ingrese su nombre" name="nombre" required readonly>
            </div>
            <div class="form_group">
                <label for="correo">Correo Electronico</label>
                <input type="email" id="correo" class="from_input" placeholder="Ingrese su correo electrónico" name="correo" required readonly>
            </div>
            <div class="form_group">
                <label for="telefono">Telefono</label>
                <input type="text" id="telefono" class="from_input" name="telefono" readonly>
            </div>
        </div>

        <div id="productosContainer">
            <div class="productos">
                <div class="form_group">
                    <label for="producto">Producto</label>
                    <select name="producto[]" class="producto-select">
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form_group">
                    <label for="precio">Precio</label>
                    <input type="text" class="from_input precio" name="precio[]" readonly>
                </div>
                <div class="form_group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad[]" class="from_input" placeholder="Ingrese la cantidad" required>
                </div>
                <div class="form_group">
                    <button type="button" class="removeProductoBtn botones2">Quitar</button>
                </div>
            </div>
        </div>
        <button type="button" id="addProductoBtn" class="botones2">Agregar otro producto</button>
            
        <div class="form_group_1">
            <label for="descripcion">Descripcion</label>
            <input type="text" id="descripcion" class="from_input" placeholder="Ingrese una descripcion" name="descripcion" required>
        </div>
        <div class="first_dates">
            <div class="form_group">
                <label for="precio_total">Precio Total de la Fianza</label>
                <input type="text" id="precio_total" class="from_input" placeholder="Precio Total" name="precio_total" readonly>
            </div>
            <div class="form_group">
                <label for="security_code">Inserte el Codigo de Seguridad</label>
                <input type="number" id="security_code" class="from_input" placeholder="Ingrese el código de seguridad" name="security_code" required>
            </div>
        </div>
            
        <div class="form_group botones3">
            <button type="button" id="sendCodeBtn" class="botones2">Enviar Código de Seguridad</button>
            <button type="submit" class="botones2">Crear Finanza</button>
        </div>
    </div>
</form>

<script> var usuarioInfoUrl = "{{ route('usuario_info') }}";</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/formulario.js') }}"></script>
<script>
    $(function() {
        $("#cedula").autocomplete({
            source: "{{ route('usuarios.autocomplete') }}",
            select: function(event, ui) {
                $('#cedula').val(ui.item.value);
                $('#nombre').val(ui.item.nombre);
                $('#correo').val(ui.item.correo);
                $('#telefono').val(ui.item.telefono);
                return false;
            },
            minLength: 1, // Número mínimo de caracteres antes de iniciar la búsqueda
        });
    });
</script>


<!-- Mostrar Mensaje de Éxito -->
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<!-- Mostrar Mensajes de Error -->
@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection