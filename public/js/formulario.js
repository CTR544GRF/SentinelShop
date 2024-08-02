// formulario.js

$(document).ready(function() {
    function fetchProducto(id, element) {
        $.ajax({
            url: '/productos/' + id,
            method: 'GET',
            success: function(data) {
                element.find('.precio').val(data.precio);
            }
        });
    }

    $('#productosContainer').on('change', '.producto-select', function() {
        var productoId = $(this).val();
        var productoElement = $(this).closest('.productos');

        if (productoId) {
            fetchProducto(productoId, productoElement);
        } else {
            productoElement.find('.precio').val('');
        }
    });

    $('#addProductoBtn').click(function() {
        var newProducto = $('.productos').first().clone();
        newProducto.find('select').val('');
        newProducto.find('.precio').val('');
        newProducto.find('input[name="cantidad[]"]').val('');
        $('#productosContainer').append(newProducto);
    });

    $('#productosContainer').on('click', '.removeProductoBtn', function() {
        $(this).closest('.productos').remove();
    });

    
});

// Función para calcular el total
function calculateTotal() {
    var total = 0;
    $('#productosContainer .productos').each(function() {
        var precio = parseFloat($(this).find('.precio').val()) || 0;
        var cantidad = parseFloat($(this).find('input[name="cantidad[]"]').val()) || 0;
        total += precio * cantidad;
    });
    $('#precio_total').val(total.toFixed(2));
}

// Modificación para recalcular el total cuando cambian productos o cantidades
$('#productosContainer').on('change', '.producto-select, input[name="cantidad[]"]', function() {
    calculateTotal();
});

// Modificación para recalcular el total cuando se elimina un producto
$('#productosContainer').on('click', '.removeProductoBtn', function() {
    $(this).closest('.productos').remove();
    calculateTotal();
});

// seccion telefono

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#sendCodeBtn').click(function() {
        var telefono = $('#telefono').val();
        var productos = [];

        $('#productosContainer .productos').each(function() {
            var productoId = $(this).find('.producto-select').val();
            if (productoId) {
                productos.push(productoId);
            }
        });

        if (telefono && productos.length > 0) {
            $.ajax({
                url: '/send-security-code',
                method: 'POST',
                data: {
                    telefono: telefono,
                    productos: productos
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error al enviar el código de seguridad.');
                }
            });
        } else {
            alert('Seleccione un número de teléfono y al menos un producto.');
        }
    });
});
