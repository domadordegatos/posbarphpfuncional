<?php require_once "../home/navbar.php";
require_once "../../modelo/conexion.php";
require_once "../../modelo/libraries/lib.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
</head>

<body>
    <div class="container mt-2">
        <!-- Título y Filtro por fecha en la misma fila -->
        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-center">
                <h2>Vista de Movimientos</h2>
            </div>

            <!-- Input de fecha inicial -->
            <div class="col-md-2">
                <input type="date" id="fecha_inicio" class="form-control">
            </div>

            <!-- Input de fecha final -->
            <div class="col-md-2">
                <input type="date" id="fecha_fin" class="form-control">
            </div>

            <!-- Botón de búsqueda -->
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100" onclick="filtrarPorFecha()">Buscar</button>
            </div>
        </div>

        <!-- Contenedor dividido en dos secciones -->
        <div class="row">
            <!-- Ingresos (Facturas) -->
            <div class="col-md-6">
                <div class="container">
                    <h4 class="text-center">Ventas por fecha</h4>

                    <!-- Tabla para mostrar las ventas del día -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="tabla_facturas">
                            <thead>
                                <tr class="text-center">
                                    <th>ID Factura</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Total Venta</th>
                                    <th>Consultar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenarán las filas dinámicamente con los resultados -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Insumos (Otros) -->
<div class="col-md-6">
    <div class="table-responsive table-sm">
        <h4>Insumos (Otros)</h4>
        <table class="table table-bordered" id="tabla_insumos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Total</th>
                    <th>Tipo Transacción</th> <!-- Nueva columna para Tipo de Transacción -->
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se llenarán los insumos dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

        </div>
    </div>

</body>

</html>
<script>
$(document).ready(function () {
    // Obtener la fecha actual en formato YYYY-MM-DD
    var fechaActual = new Date();
    var fechaFormateada = fechaActual.toLocaleDateString('es-CO', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).split('/').reverse().join('-');

    // Establecer la fecha actual en ambos inputs
    $('#fecha_inicio').val(fechaFormateada);
    $('#fecha_fin').val(fechaFormateada);

    // Cargar las ventas e insumos del día actual
    cargarVentasDiaActual();
    cargarInsumosDiaActual();
});
    

// Función para abrir los detalles del insumo
function abrirInsumo(id_insumo) {
    // Crear la URL para abrir el detalle del insumo, pasando el id_insumo como parámetro
    var url = "../../controlador/insumo_detalle.php?id_insumo=" + id_insumo; // Aquí debes indicar la URL de la página que abrirá el detalle del insumo

    // Hacer una solicitud AJAX para obtener los detalles del insumo
    $.ajax({
        type: "GET",
        url: url,
        success: function (response) {
            var insumo = JSON.parse(response);

            if (insumo) {
                // Mostrar la información del insumo en una nueva ventana emergente
                var ventana = window.open("", "Insumo Detalle", "width=800,height=600");

                // Agregar el diseño mejorado de la ventana emergente
                ventana.document.write(`
                    <html lang="es">
                    <head>
                        <title>Detalles del Insumo</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                                background-color: #f4f4f4;
                                color: #333;
                            }
                            h3 {
                                text-align: center;
                                color: #007BFF;
                                margin-bottom: 20px;
                            }
                            .container {
                                background-color: #fff;
                                border-radius: 8px;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                padding: 20px;
                                margin: 20px;
                            }
                            .details {
                                margin-bottom: 15px;
                            }
                            .details label {
                                font-weight: bold;
                                display: block;
                                margin-bottom: 5px;
                            }
                            .details p {
                                font-size: 16px;
                                margin: 0;
                            }
                            .footer {
                                text-align: center;
                                margin-top: 20px;
                            }
                            .footer a {
                                padding: 10px 15px;
                                background-color: #007BFF;
                                color: #fff;
                                text-decoration: none;
                                border-radius: 5px;
                                margin-top: 10px;
                                display: inline-block;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h3>Detalles del Insumo #${insumo.id_movimiento}</h3>
                            <div class="details">
                                <label for="fecha">Fecha:</label>
                                <p id="fecha">${insumo.fecha}</p>
                            </div>
                            <div class="details">
                                <label for="descripcion">Descripción:</label>
                                <p id="descripcion">${insumo.descripcion}</p>
                            </div>
                            <div class="details">
                                <label for="total">Total:</label>
                                <p id="total">${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(insumo.total)}</p>
                            </div>
                            <div class="details">
                                <label for="tipo_transaccion">Tipo de Transacción:</label>
                                <p id="tipo_transaccion">${insumo.tipo_transaccion}</p>
                            </div>
                            <div class="footer">
                                <a href="javascript:window.close()">Cerrar</a>
                            </div>
                        </div>
                    </body>
                    </html>
                `);
            } else {
                alert("No se encontraron detalles para este insumo.");
            }
        },
        error: function () {
            alert("Error al cargar los detalles del insumo.");
        }
    });
}



    // Función para abrir la factura
    function abrirFactura(id_factura) {
        // Crear la URL para abrir la factura, pasando el id_factura como parámetro
        var url = "../../controlador/factura_detalle.php?id_factura=" + id_factura; // Aquí debes indicar la URL de la página que abrirá la factura
        window.open(url, "Factura", "width=800,height=600"); // Abre una ventana emergente con la URL
    }

$(document).ready(function () {
    // Cargar las ventas del día actual al cargar la página
    cargarVentasDiaActual();

    // Función para cargar las ventas del día actual
    function cargarVentasDiaActual() {
        $.ajax({
            type: "GET",
            url: "../../controlador/ventas_dia_actual.php",  // Ruta al controlador que obtiene las ventas
            success: function (response) {
                var facturas = JSON.parse(response);

                // Limpiar la tabla antes de agregar los nuevos resultados
                $('#tabla_facturas tbody').empty();

                if (facturas.length > 0) {
                    // Calcular la suma total de las ventas
                    var totalVenta = 0;
                    facturas.forEach(function (factura) {
                        totalVenta += parseFloat(factura.total_venta);
                    });

                    // Agregar la fila de suma antes de los datos
                    var filaSuma = `<tr>
                        <td colspan="3" class="text-right"><strong>Total Ventas</strong></td>
                        <td class="table-info"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalVenta)}</strong></td>
                        <td></td>
                    </tr>`;
                    $('#tabla_facturas tbody').append(filaSuma);

                    // Iterar sobre las facturas y agregar una fila por cada una
                    facturas.forEach(function (factura) {
                        var fila = `<tr>
                            <td class="text-center">${factura.id_factura}</td>
                            <td>${factura.fecha}</td>
                            <td>${factura.hora}</td>
                            <td>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(factura.total_venta)}</td>
                            <td class="text-center"><button class="btn btn-info" onclick="abrirFactura(${factura.id_factura})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sticky" viewBox="0 0 16 16">
                                    <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293z"/>
                                </svg>
                            </button></td>
                        </tr>`;
                        $('#tabla_facturas tbody').append(fila);
                    });
                } else {
                    // Si no hay ventas, mostrar un mensaje
                    $('#tabla_facturas tbody').append('<tr><td colspan="5">No hay ventas para hoy.</td></tr>');
                }
            },
            error: function () {
                alert("Error al cargar las ventas del día.");
            }
        });
    }
});


// Función de búsqueda por fecha
function filtrarPorFecha() {
    filtrarPorFechaInsumo();
    var fechaInicio = document.getElementById("fecha_inicio").value;
    var fechaFin = document.getElementById("fecha_fin").value;

    console.log("Filtrar entre fechas:", fechaInicio, "y", fechaFin);

    // Validar que ambas fechas estén seleccionadas
    if (!fechaInicio || !fechaFin) {
        alert("Por favor, seleccione ambas fechas.");
        return;
    }

    // Hacer la solicitud AJAX al servidor para obtener las facturas filtradas por fecha
    $.ajax({
        type: "GET",
        url: "../../controlador/ventas_por_fecha.php",  // El archivo PHP que realizará la consulta
        data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
        success: function (response) {
            var facturas = JSON.parse(response);

            // Limpiar la tabla antes de agregar los nuevos resultados
            $('#tabla_facturas tbody').empty();

            if (facturas.length > 0) {
                // Calcular la suma total de las ventas
                var totalVenta = 0;
                facturas.forEach(function (factura) {
                    totalVenta += parseFloat(factura.total_venta);
                });

                // Agregar la fila de suma antes de los datos
                var filaSuma = `<tr>
                    <td colspan="3" class="text-right"><strong>Total Ventas</strong></td>
                    <td class="table-info"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalVenta)}</strong></td>
                    <td></td>
                </tr>`;
                $('#tabla_facturas tbody').append(filaSuma);

                // Iterar sobre las facturas y agregar una fila por cada una
                facturas.forEach(function (factura) {
                    var fila = `<tr>
                        <td class="text-center">${factura.id_factura}</td>
                        <td>${factura.fecha}</td>
                        <td>${factura.hora}</td>
                        <td>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(factura.total_venta)}</td>
                        <td class="text-center"><button class="btn btn-info" onclick="abrirFactura(${factura.id_factura})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sticky" viewBox="0 0 16 16">
                                <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293z"/>
                            </svg>
                        </button></td>
                    </tr>`;
                    $('#tabla_facturas tbody').append(fila);
                });
            } else {
                // Si no hay resultados, mostrar un mensaje
                $('#tabla_facturas tbody').append('<tr><td colspan="5">No se encontraron ventas en este rango de fechas.</td></tr>');
            }
        },
        error: function () {
            alert("Error al cargar las ventas.");
        }
    });
}


$(document).ready(function () {
    // Cargar los insumos del día actual al cargar la página
    cargarInsumosDiaActual();

    // Función para cargar los insumos del día actual
    function cargarInsumosDiaActual() {
        $.ajax({
            type: "GET",
            url: "../../controlador/insumos_dia_actual.php",  // Ruta al controlador que obtiene los insumos
            success: function (response) {
                var insumos = JSON.parse(response);

                // Limpiar la tabla antes de agregar los nuevos resultados
                $('#tabla_insumos tbody').empty();

                // Inicializar las sumas para cada tipo de transacción
                var totalInsumos = 0;
                var totalEgresos = 0;
                var totalPerdidas = 0;

                if (insumos.length > 0) {
                    // Iterar sobre los insumos y agregar una fila por cada uno
                    insumos.forEach(function (insumo) {
                        // Limitar la descripción a 20 caracteres
                        var descripcionLimitada = insumo.descripcion.length > 20 ? insumo.descripcion.substring(0, 20) + '...' : insumo.descripcion;

                        // Asignar la clase de color según el tipo de transacción
                        var tipoTransaccionClase = '';
                        if (insumo.tipo_transaccion === 'insumo') {
                            tipoTransaccionClase = 'table-info';  // Color azul para insumos
                            totalInsumos += parseFloat(insumo.total);  // Sumar a la total de insumos
                        } else if (insumo.tipo_transaccion === 'perdida') {
                            tipoTransaccionClase = 'table-danger';  // Color rojo para perdidas
                            totalPerdidas += parseFloat(insumo.total);  // Sumar a la total de perdidas
                        } else if (insumo.tipo_transaccion === 'egreso') {
                            tipoTransaccionClase = 'table-warning';  // Color amarillo para egresos
                            totalEgresos += parseFloat(insumo.total);  // Sumar a la total de egresos
                        }

                        // Fila con los datos del insumo, aplicando el color solo a la celda correspondiente
                        var fila = `<tr>
                            <td class="text-center">${insumo.id_factura}</td>
                            <td>${insumo.fecha}</td>
                            <td>${descripcionLimitada}</td>
                            <td>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(insumo.total)}</td>
                            <td class="${tipoTransaccionClase}">${insumo.tipo_transaccion}</td> <!-- Color solo en la celda de tipo de transacción -->
                            <td class="text-center"><button class="btn btn-info" onclick="abrirInsumo(${insumo.id_movimiento})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sticky" viewBox="0 0 16 16">
                                    <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293z"/>
                                </svg>
                            </button></td>
                        </tr>`;
                        $('#tabla_insumos tbody').append(fila);
                    });

                    // Agregar la fila de totales en la parte superior de la tabla
                    var filaTotal = `<tr class="table-dark">
                        <td colspan="3" class="text-right"><strong>Total Insumos</strong></td>
                        <td class="table-info"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalInsumos)}</strong></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr class="table-dark">
                        <td colspan="3" class="text-right"><strong>Total Egresos</strong></td>
                        <td class="table-warning"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalEgresos)}</strong></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr class="table-dark">
                        <td colspan="3" class="text-right"><strong>Total Perdidas</strong></td>
                        <td class="table-danger"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalPerdidas)}</strong></td>
                        <td colspan="2"></td>
                    </tr>`;

                    // Insertar la fila de totales al principio de la tabla
                    $('#tabla_insumos tbody').prepend(filaTotal);

                } else {
                    // Si no hay insumos, mostrar un mensaje
                    $('#tabla_insumos tbody').append('<tr><td colspan="6">No hay insumos para hoy.</td></tr>');
                }
            },
            error: function () {
                alert("Error al cargar los insumos del día.");
            }
        });
    }
});


// Función de búsqueda por fecha para filtrar insumos
function filtrarPorFechaInsumo() {
    var fechaInicio = document.getElementById("fecha_inicio").value;
    var fechaFin = document.getElementById("fecha_fin").value;

    console.log("Filtrar entre fechas:", fechaInicio, "y", fechaFin);

    // Validar que ambas fechas estén seleccionadas
    if (!fechaInicio || !fechaFin) {
        alert("Por favor, seleccione ambas fechas.");
        return;
    }

    // Hacer la solicitud AJAX al servidor para obtener los insumos filtrados por fecha
    $.ajax({
        type: "GET",
        url: "../../controlador/insumos_por_fecha.php",  // El archivo PHP que realizará la consulta para los insumos filtrados
        data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
        success: function (response) {
            var insumos = JSON.parse(response);

            // Limpiar la tabla antes de agregar los nuevos resultados
            $('#tabla_insumos tbody').empty();

            // Inicializar las sumas para cada tipo de transacción
            var totalInsumos = 0;
            var totalEgresos = 0;
            var totalPerdidas = 0;

            if (insumos.length > 0) {
                // Iterar sobre los insumos y agregar una fila por cada uno
                insumos.forEach(function (insumo) {
                    // Limitar la descripción a 20 caracteres
                    var descripcionLimitada = insumo.descripcion.length > 20 ? insumo.descripcion.substring(0, 20) + '...' : insumo.descripcion;

                    // Asignar la clase de color según el tipo de transacción
                    var tipoTransaccionClase = '';
                    if (insumo.tipo_transaccion === 'insumo') {
                        tipoTransaccionClase = 'table-info';  // Color azul para insumos
                        totalInsumos += parseFloat(insumo.total);  // Sumar a la total de insumos
                    } else if (insumo.tipo_transaccion === 'perdida') {
                        tipoTransaccionClase = 'table-danger';  // Color rojo para perdidas
                        totalPerdidas += parseFloat(insumo.total);  // Sumar a la total de perdidas
                    } else if (insumo.tipo_transaccion === 'egreso') {
                        tipoTransaccionClase = 'table-warning';  // Color amarillo para egresos
                        totalEgresos += parseFloat(insumo.total);  // Sumar a la total de egresos
                    }

                    var fila = `<tr> <!-- Aplicamos el color a toda la fila -->
                        <td class="text-center">${insumo.id_factura}</td>
                        <td>${insumo.fecha}</td>
                        <td>${descripcionLimitada}</td>
                        <td>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(insumo.total)}</td>
                        <td class="${tipoTransaccionClase}">${insumo.tipo_transaccion}</td> <!-- Mostrar el tipo de transacción -->
                        <td class="text-center"><button class="btn btn-info" onclick="abrirInsumo(${insumo.id_movimiento})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sticky" viewBox="0 0 16 16">
                                <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5v11A1.5 1.5 0 0 0 2.5 15h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 15 8.586V2.5A1.5 1.5 0 0 0 13.5 1zM2 2.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V8H9.5A1.5 1.5 0 0 0 8 9.5V14H2.5a.5.5 0 0 1-.5-.5zm7 11.293V9.5a.5.5 0 0 1 .5-.5h4.293z"/>
                            </svg>
                        </button></td>
                    </tr>`;
                    $('#tabla_insumos tbody').append(fila);
                });

                // Agregar la fila de totales en la parte superior de la tabla
                var filaTotal = `<tr class="table-dark">
                    <td colspan="3" class="text-right"><strong>Total Insumos</strong></td>
                    <td class="table-info"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalInsumos)}</strong></td>
                    <td colspan="2"></td>
                </tr>
                <tr class="table-dark">
                    <td colspan="3" class="text-right"><strong>Total Egresos</strong></td>
                    <td class="table-warning"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalEgresos)}</strong></td>
                    <td colspan="2"></td>
                </tr>
                <tr class="table-dark">
                    <td colspan="3" class="text-right"><strong>Total Perdidas</strong></td>
                    <td class="table-danger"><strong>${new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(totalPerdidas)}</strong></td>
                    <td colspan="2"></td>
                </tr>`;

                // Insertar la fila de totales al principio de la tabla
                $('#tabla_insumos tbody').prepend(filaTotal);

            } else {
                // Si no hay insumos, mostrar un mensaje
                $('#tabla_insumos tbody').append('<tr><td colspan="6">No se encontraron insumos para este rango de fechas.</td></tr>');
            }
        },
        error: function () {
            alert("Error al cargar los insumos filtrados por fechas.");
        }
    });
}



</script>