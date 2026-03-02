<?php require_once "../home/navbar.php";
require_once "../../modelo/conexion.php";
require_once "../../modelo/libraries/lib.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 px-5">
                <h2 class="my-4 text-center">
                    Facturacion de productos</h2>
                <form>
                    <div class="row mb-3">
                        <!-- Cantidad de Nuevos Productos -->
                        <div class="col-3">
                            <label for="cantidad_nueva" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad_nueva" name="cantidad_nueva"
                                placeholder="Ej. 50" required value="1">
                        </div>
                        <!-- Buscador de productos -->
                        <!-- Buscador de productos -->
<div class="col-9">
    <label for="producto_buscar" class="form-label">Buscar Producto</label>
    <input type="text" class="form-control" id="producto_buscar" name="producto_buscar"
           placeholder="Buscar por nombre o código de barras">
</div>
                    </div>

                    <!-- Producto seleccionado (oculto para enviar con el formulario) -->
                    <input type="hidden" id="id_producto_actualizar" name="id_producto_actualizar">

                    <!-- Lista de productos encontrados (se genera dinámicamente) -->
                    <ul id="productos_resultados" class="list-group mt-3" style="max-height: 150px; overflow-y: auto;">
                    </ul>

                    <div class="d-grid gap-2">
                        <button type="button" class="p-2 btn btn-primary w-100" onclick="realizarVenta()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-cart-plus" viewBox="0 0 16 16">
                                <path
                                    d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                                <path
                                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                            Realizar Venta</button>
                    </div>
                </form>

<div class="col-md-12 mt-5">
    <h4 class="my-1 text-center">Carga de Insumos</h4>
    <form id="form_carga_insumo">
        <div class="row mb-3">
            <!-- Descripción del insumo -->
            <div class="col-12">
                <label for="descripcion_insumo" class="form-label">Descripción del Insumo</label>
                <input type="text" class="form-control" id="descripcion_insumo" name="descripcion_insumo" placeholder="Ej. Pago de pedido de cerveza">
            </div>
        </div>
        
        <!-- Fila para el valor, fecha y tipo -->
        <div class="row mb-3">
            <!-- Valor del insumo -->
            <div class="col-4">
                <label for="valor_insumo" class="form-label">Valor del Insumo</label>
                <input type="number" class="form-control" id="valor_insumo" name="valor_insumo" placeholder="Ej. 50000">
            </div>
            <!-- Fecha del insumo -->
            <div class="col-4">
                <label for="fecha_insumo" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha_insumo" name="fecha_insumo">
            </div>
            <!-- Tipo de insumo (Egreso o Compra) -->
            <div class="col-4">
                <label for="tipo_insumo" class="form-label">Tipo de Insumo</label>
    <select class="form-control" id="tipo_insumo" name="tipo_insumo">
        <!-- Opciones serán cargadas dinámicamente aquí -->
    </select>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="button" class="p-2 btn btn-primary w-100" onclick="cargarInsumo()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
  <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
  <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5"/>
</svg>
                Registrar Insumo
            </button>
        </div>
    </form>
</div>



            </div>


            <div class="col-md-6">
                <h4 class="my-4 text-center">Carrito de Compras</h4>
                <ul id="carrito_compras_lista" class="list-group">
                    <!-- Los productos seleccionados aparecerán aquí -->
                </ul>

                <!-- Textarea de descripción, inicialmente oculto -->
                <div id="descripcion_venta" style="display: none; margin-top: 1rem;">
                    <label for="descripcion">Descripción de la venta</label>
                    <textarea id="descripcion" class="form-control" rows="1"
                        placeholder="Escribe la descripción aquí..."></textarea>
                </div>
            </div>


        </div>
    </div>


</body>

</html>

<style>
    .rojo {
        background-color: #ffcccc !important;
        /* Fondo rojo claro */
        color: #ff0000 !important;
        /* Texto en rojo */
    }
</style>
<script>
$(document).ready(function() {
    // Obtener la fecha actual en formato local (Colombia - UTC-5)
    var fechaActual = new Date();
    
    // Ajustar la fecha a la zona horaria de Colombia (UTC-5)
    fechaActual.setHours(fechaActual.getHours() - 5);

    // Formatear la fecha en formato YYYY-MM-DD
    var fechaFormateada = fechaActual.toISOString().split('T')[0]; 

    // Establecer la fecha actual en el input de fecha de insumo
    $('#fecha_insumo').val(fechaFormateada);
});

    function cargarInsumo() {
    // Obtener los valores de los inputs
    var descripcionInsumo = $('#descripcion_insumo').val();
    var valorInsumo = $('#valor_insumo').val();
    var fechaInsumo = $('#fecha_insumo').val();
    var tipoTransaccion = $('#tipo_insumo').val();

    // Verificar que los campos no estén vacíos
    if (descripcionInsumo === "" || valorInsumo === "" || fechaInsumo === "") {
        alertify.error("Todos los campos son obligatorios.");
        return;
    }

    // Obtener el id de la factura (puedes obtenerlo de manera similar a la venta)
    $.ajax({
        type: "POST",
        url: "../../controlador/generar_factura.php", // Controlador que obtendrá el número de la factura
        success: function(response) {
            var idFactura = response;  // El número de la factura será retornado por el controlador

            // Obtener la hora actual
            var hora = new Date().toTimeString().split(' ')[0];  // Solo la hora (HH:MM:SS)

            // Enviar los datos al controlador para registrar el insumo
            $.ajax({
                type: "POST",
                url: "../../controlador/cargar_insumo.php",  // Controlador que manejará la inserción del insumo
                data: {
                    id_factura: idFactura,
                    fecha: fechaInsumo,
                    hora: hora,
                    tipo_transaccion: tipoTransaccion,  // Tipo de transacción para insumos (puede ser definido según tu necesidad)
                    descripcion: descripcionInsumo,
                    valor: valorInsumo
                },
                success: function(response) {
                    if (response == 1) {
                        alertify.success("Insumo cargado con éxito.");
                        $('#descripcion_insumo').val('');  // Limpiar el campo de descripción
                        $('#valor_insumo').val('');  // Limpiar el campo de valor
                        var fechaFormateada = new Date().toISOString().split('T')[0]; 
                        var fechaObjeto = new Date(fechaFormateada);
                        fechaObjeto.setDate(fechaObjeto.getDate() - 1);
                        var fecha = fechaObjeto.toISOString().split('T')[0];
                        $('#fecha_insumo').val(fecha);  // Limpiar el campo de fecha
                    } else {
                        alertify.error("Error al cargar el insumo.");
                    }
                },
                error: function() {
                    alertify.error("Error al procesar el insumo.");
                }
            });
        }
    });
}


    $(document).ready(function() {
    // Llamada AJAX para obtener los tipos de transacción desde la BD
    $.ajax({
        type: "GET",
        url: "../../controlador/obtener_tipos_transaccion.php",  // Ruta al controlador que obtiene los datos
        success: function(response) {
            var tiposTransaccion = JSON.parse(response);  // Parseamos el JSON recibido

            // Verificamos si no hay error
            if (tiposTransaccion.error) {
                alertify.error(tiposTransaccion.error);
                return;
            }

            // Limpiar el select antes de agregar las nuevas opciones
            $('#tipo_insumo').empty();

            // Crear las opciones del select
            tiposTransaccion.forEach(function(tipo) {
                var option = `<option value="${tipo.id_transaccion}">${tipo.descripcion}</option>`;
                $('#tipo_insumo').append(option);  // Agregar la opción al select
            });
        },
        error: function() {
            alertify.error("Error al cargar los tipos de transacción.");
        }
    });
});

$(document).ready(function() {
    // Configurar el evento para la búsqueda de productos
    $('#producto_buscar').on('input', function () {
        buscarProducto();  // Inicia la búsqueda cuando el usuario escribe
    });
});

// Función para buscar productos por nombre o código de barras
function buscarProducto() {
    var productoBuscar = $('#producto_buscar').val(); // Obtiene el valor del campo de texto

    // Si el campo de búsqueda tiene 10 dígitos (Código de barras)
    if (productoBuscar.length == 10) {
        // Si es un código de barras (de 10 dígitos), buscar directamente el producto
        $.ajax({
            type: "POST",
            url: "../../controlador/buscar_producto.php", // Ruta al controlador que realiza la búsqueda
            data: {
                producto_buscar: productoBuscar // Enviar el código de barras
            },
            success: function (response) {
                var productos = jQuery.parseJSON(response);
                $('#productos_resultados').empty(); // Limpiamos los resultados anteriores

                if (productos.length > 0) {
                    // Si se encuentra el producto, agregarlo automáticamente al carrito
                    var producto = productos[0]; // Tomar el primer resultado (ya que se supone que es único)
                    agregarAlCarrito(producto.id_producto, producto.nombre_producto, producto.precio_unitario);
                } else {
                    $('#productos_resultados').append('<li class="list-group-item">No se encontró el producto con ese código.</li>');
                }
            },
            error: function () {
                alertify.error("Error al buscar producto.");
            }
        });
    } else if (productoBuscar.length >= 1) {
        // Si es texto, buscar productos por nombre
        $.ajax({
            type: "POST",
            url: "../../controlador/buscar_producto.php", // Ruta al controlador que realiza la búsqueda
            data: {
                producto_buscar: productoBuscar // Enviar el nombre del producto
            },
            success: function (response) {
                var productos = jQuery.parseJSON(response);
                $('#productos_resultados').empty(); // Limpiamos los resultados anteriores

                if (productos.length > 0) {
                    productos.forEach(function (producto) {
                        $('#productos_resultados').append(
                            '<li class="list-group-item" style="cursor:pointer;" onclick="seleccionarProducto(' + producto.id_producto + ', \'' + producto.nombre_producto + '\', ' + producto.precio_unitario + ')">' +
                            producto.nombre_producto + ' - $' + producto.precio_unitario + '</li>'
                        );
                    });
                } else {
                    $('#productos_resultados').append('<li class="list-group-item">No se encontraron productos.</li>');
                }
            },
            error: function () {
                alertify.error("Error al buscar productos.");
            }
        });
    }
}

// Función para agregar el producto directamente al carrito
function agregarAlCarrito(id, nombre, precio) {
    // Obtener la cantidad ingresada (por defecto será 1)
    var cantidad = $('#cantidad_nueva').val();  
    if (cantidad === "" || cantidad <= 0) {
        cantidad = 1; // Si no se ingresa una cantidad válida, asignar 1 por defecto
    }

    // Calcular el precio total (precio unitario * cantidad)
    var precioTotal = precio * cantidad;

    // Verificar la existencia en inventario
    $.ajax({
        type: "POST",
        url: "../../controlador/verificar_existencia.php",  // Ruta al controlador para verificar existencia
        data: {
            id_producto: id,
            cantidad_solicitada: cantidad
        },
        success: function (response) {
            var resultado = JSON.parse(response);  // Obtener la respuesta del servidor
            var cantidadExistente = resultado.existencia;

            // Verificar si la cantidad solicitada excede la cantidad existente
            var itemClass = cantidad > cantidadExistente ? "rojo" : "";  // Si excede la cantidad disponible, agregar clase "rojo"

            // Limpiar el campo de búsqueda
            $('#producto_buscar').val('');
            $('#productos_resultados').empty();  // Limpiar la lista de resultados

            // Agregar el producto al carrito de compras como un <li> en el UL
            var item = `<li class="list-group-item d-flex justify-content-between ${itemClass}" id="producto_${id}">
                    <button class="mr-3 btn btn-danger btn-sm d-inline-block ml-2" onclick="eliminarProducto(${id})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </button>
                    <span>${nombre} - $${precio}</span>
                    <input type="number" value="${cantidad}" min="1" id="cantidad_${id}" class="form-control form-control-sm d-inline-block w-25 ml-3" onchange="actualizarCantidad(${id}, ${precio})">
                    <input type="number" value="${precioTotal}" id="precio_${id}" class="form-control form-control-sm d-inline-block w-25 ml-3" onchange="actualizarPrecio(${id})">
                </li>`;
            $('#carrito_compras_lista').append(item);  // Agregar el nuevo producto al carrito

            // Mostrar el textarea solo si hay productos en el carrito
            if ($('#carrito_compras_lista li').length > 0) {
                $('#descripcion_venta').show();
            }

            // Actualizamos el carrito en sessionStorage
            var producto = {
                id_producto: id,
                nombre_producto: nombre,
                cantidad: cantidad,
                precio_unitario: precio,
                precio_total: precioTotal,  // Aseguramos que esté presente
                descripcion: nombre // Usamos el nombre del producto como descripción si no hay otra
            };

            if (!sessionStorage.getItem('carrito')) {
                sessionStorage.setItem('carrito', JSON.stringify([producto]));
            } else {
                var carrito = JSON.parse(sessionStorage.getItem('carrito'));
                carrito.push(producto);
                sessionStorage.setItem('carrito', JSON.stringify(carrito));
            }
        },
        error: function () {
            alertify.error("Error al verificar la existencia del producto.");
        }
    });
}

    function seleccionarProducto(id, nombre, precio) {
        // Obtener la cantidad ingresada
        var cantidad = $('#cantidad_nueva').val();  // Obtener el valor de cantidad del campo
        if (cantidad === "" || cantidad <= 0) {
            cantidad = 1; // Si no se ingresa una cantidad válida, se asigna 1 por defecto
        }

        // Calcular el precio total (precio unitario * cantidad)
        var precioTotal = precio * cantidad;

        // Verificar la existencia en inventario
        $.ajax({
            type: "POST",
            url: "../../controlador/verificar_existencia.php",  // Ruta al controlador para verificar existencia
            data: {
                id_producto: id,
                cantidad_solicitada: cantidad
            },
            success: function (response) {
                var resultado = JSON.parse(response);  // Obtener la respuesta del servidor
                var cantidadExistente = resultado.existencia;

                // Verificar si la cantidad solicitada excede la cantidad existente
                var itemClass = cantidad > cantidadExistente ? "rojo" : "";  // Si excede la cantidad disponible, agregar clase "rojo"

                // Limpiar el campo de búsqueda
                $('#producto_buscar').val('');
                $('#productos_resultados').empty();  // Limpiar la lista de resultados

                // Agregar el producto al carrito de compras como un <li> en el UL
                var item = `<li class="list-group-item d-flex justify-content-between ${itemClass}" id="producto_${id}">
                        <button class="mr-3 btn btn-danger btn-sm d-inline-block ml-2" onclick="eliminarProducto(${id})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                        </button>
                        <span>${nombre} - $${precio}</span>
                        <input type="number" value="${cantidad}" min="1" id="cantidad_${id}" class="form-control form-control-sm d-inline-block w-25 ml-3" onchange="actualizarCantidad(${id}, ${precio})">
                        <input type="number" value="${precioTotal}" id="precio_${id}" class="form-control form-control-sm d-inline-block w-25 ml-3" onchange="actualizarPrecio(${id})">
                    </li>`;
                $('#carrito_compras_lista').append(item);  // Agregar el nuevo producto al carrito

                // Mostrar el textarea solo si hay productos en el carrito
                if ($('#carrito_compras_lista li').length > 0) {
                    $('#descripcion_venta').show();
                }

                // Actualizamos el carrito en sessionStorage
                var producto = {
                    id_producto: id,
                    nombre_producto: nombre,
                    cantidad: cantidad,
                    precio_unitario: precio,
                    precio_total: precioTotal,  // Aseguramos que esté presente
                    descripcion: nombre // Usamos el nombre del producto como descripción si no hay otra
                };

                if (!sessionStorage.getItem('carrito')) {
                    sessionStorage.setItem('carrito', JSON.stringify([producto]));
                } else {
                    var carrito = JSON.parse(sessionStorage.getItem('carrito'));
                    carrito.push(producto);
                    sessionStorage.setItem('carrito', JSON.stringify(carrito));
                }

                // Verificar en consola si la cantidad solicitada excede el inventario
                /*  if (cantidad > cantidadExistente) { */
                console.log(`Cantidad solicitada: ${cantidad}, Cantidad disponible en inventario: ${cantidadExistente}`);
                /*  } */
            },
            error: function () {
                alertify.error("Error al verificar la existencia del producto.");
            }
        });
    }





    // Función para actualizar el precio del producto en el carrito
    function actualizarPrecio(id) {
        var nuevoPrecio = $(`#precio_${id}`).val();  // Obtener el nuevo precio desde el input
        var cantidad = $(`#cantidad_${id}`).val();  // Obtener la cantidad
        var precioTotal = nuevoPrecio;  // Calcular el nuevo precio total

        // Actualizar el precio total en el input correspondiente
        $(`#precio_${id}`).val(precioTotal);

        // Actualizar el carrito en sessionStorage
        var carrito = JSON.parse(sessionStorage.getItem('carrito'));
        carrito.forEach(producto => {
            if (producto.id_producto == id) {
                producto.precio_total = precioTotal;  // Actualizar el precio total
            }
        });
        sessionStorage.setItem('carrito', JSON.stringify(carrito));
    }

    // Función para actualizar la cantidad en el carrito
    function actualizarCantidad(id, precioUnitario) {
        // Obtener la nueva cantidad
        var cantidad = $(`#cantidad_${id}`).val();  // Obtener el valor de la cantidad
        if (cantidad <= 0) cantidad = 1;  // Si la cantidad es 0 o menor, asignar 1

        // Verificar la existencia en inventario
        $.ajax({
            type: "POST",
            url: "../../controlador/verificar_existencia.php",  // Ruta al controlador para verificar existencia
            data: {
                id_producto: id,
                cantidad_solicitada: cantidad
            },
            success: function (response) {
                var resultado = JSON.parse(response);
                var cantidadExistente = resultado.existencia;

                // Si la cantidad solicitada excede la cantidad disponible, marcar la fila en rojo
                var itemClass = cantidad > cantidadExistente ? "rojo" : "";

                // Actualizar la clase del producto en el carrito
                $(`#producto_${id}`).removeClass("rojo").addClass(itemClass);  // Actualizar clase

                // Mantener el precio total sin cambiar
                var precioTotal = $(`#precio_${id}`).val();  // No cambiar el valor total

                // Actualizar el carrito en sessionStorage
                var carrito = JSON.parse(sessionStorage.getItem('carrito'));
                carrito.forEach(producto => {
                    if (producto.id_producto == id) {
                        producto.cantidad = cantidad;  // Actualizar la cantidad
                        // No actualizamos precio_total porque no debe cambiar
                    }
                });
                sessionStorage.setItem('carrito', JSON.stringify(carrito));
            },
            error: function () {
                alertify.error("Error al verificar la existencia del producto.");
            }
        });
    }

    // Función para eliminar un producto del carrito
    function eliminarProducto(id) {
        // Eliminar de la lista UL
        $(`#producto_${id}`).remove();

        // Eliminar del carrito en sessionStorage
        var carrito = JSON.parse(sessionStorage.getItem('carrito'));
        carrito = carrito.filter(producto => producto.id_producto !== id);
        sessionStorage.setItem('carrito', JSON.stringify(carrito));
    }

    // Función para realizar la venta
    function realizarVenta() {
        var carrito = JSON.parse(sessionStorage.getItem('carrito'));  // Obtener el carrito desde sessionStorage

        if (!carrito || carrito.length === 0) {
            alertify.error("El carrito está vacío. Agrega productos antes de realizar la venta.");
            return false;
        }


var fechaFormateada = new Date().toISOString().split('T')[0]; 
var fechaObjeto = new Date(fechaFormateada);
fechaObjeto.setDate(fechaObjeto.getDate() - 1);
var fecha = fechaObjeto.toISOString().split('T')[0];

        var hora = new Date().toTimeString().split(' ')[0];  // Solo la hora (HH:MM:SS)

        // Recopilamos la descripción de la venta
        var descripcionVenta = $('#descripcion').val();  // Obtener la descripción desde el campo de texto

        // Obtener el número de factura desde el servidor
        $.ajax({
            type: "POST",
            url: "../../controlador/generar_factura.php",  // Controlador que obtendrá el número de la factura
            success: function (response) {
                var idFactura = response;  // El número de la factura será retornado por el controlador

                // Enviar al controlador para registrar la venta
                $.ajax({
                    type: "POST",
                    url: "../../controlador/realizar_venta.php",  // Controlador que manejará la venta
                    data: {
                        id_factura: idFactura,
                        fecha: fecha,
                        hora: hora,
                        tipo_transaccion: 1,  // 1 para ventas
                        descripcion: descripcionVenta, // Pasar la descripción aquí
                        productos: carrito
                    },
                    success: function (response) {
                        if (response == 1) {

                            alertify.success("Venta realizada con éxito.");
                            $('#descripcion').val('');  // Vaciar el contenido del campo de descripción
                            vaciarCarrito();  // Limpiar el carrito después de la venta
                        } else {
                            alertify.error("Error al realizar la venta.");
                        }
                    },
                    error: function () {
                        alertify.error("Error al procesar la venta.");
                    }
                });
            }
        });
    }

    function vaciarCarrito() {
        sessionStorage.removeItem('carrito');
        $('#carrito_compras_lista').empty();
        $('#descripcion_venta').hide();  // Ocultar el textarea de descripción
    }



</script>