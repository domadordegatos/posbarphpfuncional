<?php require_once "../home/navbar.php"; 
      require_once "../../modelo/conexion.php";
      require_once "../../modelo/libraries/lib.php";

$conexion = conexion(); 

// Consulta para obtener las categorías activas
$sql = "SELECT id_categoria, descripcion FROM categorias WHERE estado = 1";
$result = mysqli_query($conexion, $sql);?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear producto</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Formulario de creación de productos (50% de la pantalla) -->
            <div class="col-md-6 px-5">
                <h4 class="my-4 text-center">Crear Producto</h4>
                <form>
                    <div class="row mb-3">
                        <input type="hidden" id="id_producto" name="id_producto" value="">
                        <!-- Nombre del Producto -->
                        <div class="col-8">
                            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"
                                placeholder="Ej. Cerveza Águila" required>
                        </div>
                    

<!-- Campo Código de Barras -->
<div class="col-4">
    <label for="codigo_producto" class="form-label">Código de Barras (10 dígitos)</label>
    <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" placeholder="Ej. 1234567890" maxlength="10" required>
</div>

</div>
                    <div class="row mb-3">
                        <!-- Categoría y Precio Unitario -->
                        <div class="col-6">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select form-control" id="categoria" name="categoria" required>
                                <?php
    // Llenar el select con los resultados de la consulta
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['id_categoria'] . "'>" . $row['descripcion'] . "</option>";
    }
    ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="precio_unitario" class="form-label">Precio Unitario (COP)</label>
                            <input type="number" class="form-control" id="precio_unitario" name="precio_unitario"
                                placeholder="Ej. 3000" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Cantidad Existente y Mínimo Stock -->
                        <div class="col-6">
                            <label for="cantidad_existente" class="form-label">Cantidad Existente</label>
                            <input type="number" class="form-control" id="cantidad_existente" name="cantidad_existente"
                                placeholder="Ej. 100" required>
                        </div>
                        <div class="col-6">
                            <label for="minimo_stock" class="form-label">Mínimo Stock</label>
                            <input type="number" class="form-control" id="minimo_stock" name="minimo_stock"
                                placeholder="Ej. 10" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select form-control" id="estado" name="estado" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <!-- Botones para Guardar o Actualizar Producto -->
                    <!-- Botones para Guardar o Actualizar Producto -->
                    <div class="d-grid gap-2">
                        <button type="button" onclick="crearProducto()" class="my-1 p-2 btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
  <path d="M11 2H9v3h2z"/>
  <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
</svg>    
                        Guardar
                            Producto</button>
                        <button type="button" class="my-1 p-2 btn btn-secondary w-100"
                            onclick="guardar_actualizacion_de_datos()">Actualizar Producto</button>
                    </div>


                </form>
<div class="col-md-12">
    <h4 class="my-4 text-center">Actualizar Existencias de Producto</h4>
    <form>
        <div class="row mb-3">
            <!-- Buscador de productos -->
            <div class="col-9">
                <label for="producto_buscar" class="form-label">Buscar Producto</label>
                <input type="text" class="form-control" id="producto_buscar" name="producto_buscar" placeholder="Buscar por nombre"
                    oninput="buscarProducto()">
                <!-- Contenedor para los resultados de búsqueda -->
                <!-- Contenedor para los resultados de búsqueda -->
                <ul id="productos_resultados" class="list-group mt-2" style="max-height: 200px; overflow-y: auto;"></ul>
                </div>

            <!-- Cantidad de Nuevos Productos -->
            <div class="col-3">
                <label for="cantidad_nueva" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad_nueva" name="cantidad_nueva" placeholder="Ej. 50"
                    required>
            </div>
        </div>

        <!-- Producto seleccionado (oculto para enviar con el formulario) -->
        <input type="hidden" id="id_producto_actualizar" name="id_producto_actualizar">

        <div class="d-grid gap-2">
            <button type="button" class="p-2 btn btn-primary w-100" onclick="actualizarExistencias()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-node-plus" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8M6.025 7.5a5 5 0 1 1 0 1H4A1.5 1.5 0 0 1 2.5 10h-1A1.5 1.5 0 0 1 0 8.5v-1A1.5 1.5 0 0 1 1.5 6h1A1.5 1.5 0 0 1 4 7.5zM11 5a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 11 5M1.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
</svg>    
            Sumar Existencias</button>
        </div>
    </form>
</div>



            </div>


            <!-- Espacio vacío a la derecha (50% de la pantalla) -->
            <!-- Columna derecha para la tabla de productos -->
            <div class="col-md-6">
                <h4 class="my-2 text-center">Lista de Productos</h4>

                <!-- Contenedor para la tabla de productos -->
                <div id="tablaProductos">
                    <!-- La tabla de productos se cargará aquí mediante AJAX -->
                </div>

            </div>

        </div>
    </div>
</body>

</html>

<script>

    function actualizarExistencias() {
    var idProducto = $('#id_producto_actualizar').val();  // Obtener el ID del producto seleccionado
    var cantidadNueva = $('#cantidad_nueva').val();  // Obtener la cantidad nueva a sumar

    // Validar que los campos no estén vacíos
    if (idProducto == "" || cantidadNueva == "") {
        alertify.error("Por favor, selecciona un producto y especifica la cantidad.");
        return false;
    }

    // Enviar los datos al controlador para actualizar las existencias
    $.ajax({
        type: "POST",
        url: "../../controlador/actualizar_existencias.php",  // Controlador para actualizar existencias
        data: {
            id_producto: idProducto,
            cantidad_nueva: cantidadNueva
        },
        success: function(response) {
            if (response == 1) {
                cargarTablaProductos(); 
                alertify.success("Existencias actualizadas correctamente.");
                // Limpiar campos después de la actualización
                $('#producto_buscar').val("");
                $('#cantidad_nueva').val("");
                $('#id_producto_actualizar').val("");
                $('#productos_resultados').empty();
            } else {
                alertify.error("Error al actualizar las existencias.");
            }
        },
        error: function() {
            alertify.error("Error en el proceso de actualización.");
        }
    });
}


    $(document).ready(function() {
    // Detecta cuando el usuario empieza a escribir en el campo de búsqueda
    $('#producto_buscar').on('input', function() {
        buscarProducto();  // Llama la función de búsqueda
    });
});

// Función para buscar productos por nombre o código de barras
function buscarProducto() {
    var productoBuscar = $('#producto_buscar').val();  // Obtiene el valor del campo de texto

    // Verifica si el texto tiene al menos 1 caracter
    if (productoBuscar.length >= 1) {
        $.ajax({
            type: "POST",
            url: "../../controlador/buscar_producto.php",  // Ruta al controlador que realiza la búsqueda
            data: { producto_buscar: productoBuscar },
            success: function(response) {
                // Limpiar resultados anteriores
                $('#productos_resultados').empty();

                // Se espera que la respuesta sea un JSON con los productos encontrados
                var productos = jQuery.parseJSON(response);

                // Si hay productos, mostrarlos debajo del campo de búsqueda
                if (productos.length > 0) {
                    // Si la búsqueda es por código de barras, automáticamente seleccionar el primer resultado
                    if (!isNaN(productoBuscar)) { // Verificamos si el valor de búsqueda es un número (código de barras)
                        // Llenamos automáticamente los datos
                        var producto = productos[0]; // Tomamos el primer producto
                        $('#producto_buscar').val(producto.nombre_producto + ' - ' + producto.codigo + ' - ' + producto.precio_unitario);
                        $('#id_producto_actualizar').val(producto.id_producto);  // Asignar el ID del producto
                        $('#productos_resultados').empty(); // Limpiar resultados
                    } else {
                        // Si la búsqueda es por nombre, mostramos los resultados y permitimos selección manual
                        productos.forEach(function(producto) {
                            $('#productos_resultados').append(
                                '<li class="list-group-item" style="cursor:pointer;" onclick="seleccionarProducto(' + producto.id_producto + ', \'' + producto.nombre_producto + '\', \'' + producto.codigo + '\', \'' + producto.precio_unitario + '\')">' +
                                producto.nombre_producto + ' - ' + producto.codigo + ' - ' + producto.precio_unitario + ' COP</li>'
                            );
                        });
                    }
                } else {
                    $('#productos_resultados').append('<li class="list-group-item">No se encontraron productos.</li>');
                }
            },
            error: function() {
                alertify.error("Error al buscar productos.");
            }
        });
    } else {
        // Limpiar los resultados si el campo está vacío o tiene menos de 1 caracter
        $('#productos_resultados').empty();
    }
}

// Función para seleccionar un producto de los resultados de búsqueda
function seleccionarProducto(id, nombre, codigo, precio) {
    // Llenar el campo de texto con el nombre del producto seleccionado
    $('#producto_buscar').val(nombre + ' - ' + codigo + ' - ' + precio);  

    // Guardar el ID del producto seleccionado en el campo oculto
    $('#id_producto_actualizar').val(id);  

    // Limpiar los resultados de búsqueda
    $('#productos_resultados').empty(); 
}


function crearProducto() {
     // Verificar si los campos requeridos están completos
     if ($('#nombre_producto').val() == "") {
         alertify.error("Debes ingresar el nombre del producto");
         return false;
     }
     if ($('#precio_unitario').val() == "") {
         alertify.error("Debes ingresar el precio unitario");
         return false;
     }
     if ($('#cantidad_existente').val() == "") {
         alertify.error("Debes ingresar la cantidad existente");
         return false;
     }
     if ($('#minimo_stock').val() == "") {
         alertify.error("Debes ingresar el mínimo de stock");
         return false;
     }
     if ($('#codigo_producto').val() == "") {  // Asegurarse de que el código no esté vacío
         alertify.error("Debes ingresar el código de barras");
         return false;
     }

     // Crear la cadena de datos para enviar al servidor, incluyendo el código de barras
     var cadena = "nombre_producto=" + $('#nombre_producto').val() +
         "&codigo_producto=" + $('#codigo_producto').val() +  // Agregado el código de barras
         "&categoria=" + $('#categoria').val() +
         "&precio_unitario=" + $('#precio_unitario').val() +
         "&cantidad_existente=" + $('#cantidad_existente').val() +
         "&minimo_stock=" + $('#minimo_stock').val() +
         "&estado=" + $('#estado').val();

     // Enviar la solicitud AJAX al controlador
     $.ajax({
         type: "POST",
         data: cadena,
         url: "../../controlador/crear_producto.php", // Ruta del controlador para insertar el producto
         success: function (r) {
             if (r == 1) {
                 alertify.success("Producto creado con éxito!");
                 // Limpiar los campos del formulario
                 $('#nombre_producto').val('');
                 $('#precio_unitario').val('');
                 $('#cantidad_existente').val('');
                 $('#minimo_stock').val('');
                 $('#codigo_producto').val('');  // Limpiar el campo de código de barras
                 // Recargar la lista de productos (si es necesario)
                 cargarTablaProductos(); // Llama a la función que recarga la tabla de productos
             } else if (r == 0) {
                 alertify.error("Error al crear el producto");
             } else {
                 alertify.error("Error en el proceso al insertar el producto");
             }
         }
     });
 }

    $(document).ready(function () {
        // Al cargar la página, se realiza la solicitud para cargar todos los productos
        cargarTablaProductos();
    });

    function cargarTablaProductos() {
        $.ajax({
            type: "POST",
            url: "../../controlador/cargar_tabla_productos.php", // Ruta del controlador para cargar productos
            success: function (r) {
                if (r == 1) {
                    alertify.success("Registros encontrados");
                    // Se carga la tabla de productos, que se genera en el controlador (cargar_tabla_productos.php)
                    $('#tablaProductos').load("tabla_productos.php");
                } else if (r == 2) {
                    alertify.error("No existen registros");
                    // Si no se encuentran registros, vaciar la tabla
                    $('#tablaProductos').html("");  // Limpiar la tabla
                    return false;
                } else {
                    alertify.error("Error en el proceso");
                }
            }
        });
    }

function cargar_datos_producto_actualizar(id) {
    var id_producto = id;  // El id_producto ahora es el valor que se pasa como parámetro

    // Hacer la solicitud al controlador para obtener la información del producto
    $.ajax({
        type: "POST",
        url: "../../controlador/editar_producto.php",  // Ruta del controlador para editar producto
        data: { id_producto: id_producto },  // Pasamos el id_producto al controlador
        success: function (response) {
            // Asumimos que el controlador devuelve los datos en formato JSON
            var dato = jQuery.parseJSON(response);

            // Llenar los campos del formulario con los datos obtenidos
            $('#nombre_producto').val(dato['nombre_producto']);
            $('#categoria').val(dato['categoria']);
            $('#precio_unitario').val(dato['precio_unitario']);
            $('#cantidad_existente').val(dato['cantidad_existente']);
            $('#minimo_stock').val(dato['minimo_stock']);
            $('#estado').val(dato['estado']);
            $('#codigo_producto').val(dato['codigo']);  // Cargar el código de barras aquí

            // Actualizar el valor del campo oculto con el id del producto
            $('#id_producto').val(id_producto);

            // Foco en el primer campo
            $('#nombre_producto').focus();
        },
        error: function () {
            alertify.error("Error al cargar los datos del producto.");
        }
    });
}


function guardar_actualizacion_de_datos() {
    // Obtener los valores de los campos del formulario
    var id_producto = $('#id_producto').val();  // ID del producto
    var nombre_producto = $('#nombre_producto').val();
    var categoria = $('#categoria').val();
    var precio_unitario = $('#precio_unitario').val();
    var cantidad_existente = $('#cantidad_existente').val();
    var minimo_stock = $('#minimo_stock').val();
    var estado = $('#estado').val();
    var codigo_producto = $('#codigo_producto').val();  // Obtener el código de barras

    // Validar que todos los campos estén completos
    if (nombre_producto == "" || precio_unitario == "" || cantidad_existente == "" || minimo_stock == "" || codigo_producto == "") {
        alertify.error("Todos los campos son obligatorios.");
        return false;
    }

    // Crear la cadena de datos para enviar al controlador, incluyendo el código de barras
    var cadena = "id_producto=" + id_producto +
        "&nombre_producto=" + nombre_producto +
        "&categoria=" + categoria +
        "&precio_unitario=" + precio_unitario +
        "&cantidad_existente=" + cantidad_existente +
        "&minimo_stock=" + minimo_stock +
        "&estado=" + estado +
        "&codigo_producto=" + codigo_producto;  // Incluir el código de barras

    // Enviar los datos al controlador para actualizar el producto
    $.ajax({
        type: "POST",
        url: "../../controlador/guardar_actualizacion.php",  // Ruta del controlador que actualiza el producto
        data: cadena,
        success: function (response) {
            if (response == 1) {
                alertify.success("Producto actualizado con éxito.");
                cargarTablaProductos();  // Recargar la tabla de productos

                // Limpiar los campos del formulario
                $('#nombre_producto').val('');
                $('#precio_unitario').val('');
                $('#cantidad_existente').val('');
                $('#minimo_stock').val('');
                $('#estado').val('1');  // Establecer 'Activo' como valor predeterminado
                $('#codigo_producto').val('');  // Limpiar el campo de código de barras

                $('#nombre_producto').focus();  // Foco en el campo de nombre del producto
            } else {
                alertify.error("Error al actualizar el producto.");
            }
        },
        error: function () {
            alertify.error("Error en la solicitud AJAX.");
        }
    });
}

</script>