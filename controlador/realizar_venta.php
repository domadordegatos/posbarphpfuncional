<?php
session_start();
require_once "../modelo/conexion.php";
date_default_timezone_set('America/Bogota');
// Asegúrate de que los datos de la venta estén siendo recibidos correctamente
if (isset($_POST['productos']) && isset($_POST['id_factura']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['tipo_transaccion']) && isset($_POST['descripcion'])) {

    // Depurar el contenido de $_POST
    error_log("Datos de la venta recibidos: " . print_r($_POST, true));  // Mostrar datos completos recibidos

    // Verificar si los productos vienen como JSON
    if (is_string($_POST['productos'])) {
        error_log("Productos recibidos como JSON: " . $_POST['productos']);  // Muestra el JSON recibido
        $productos = json_decode($_POST['productos'], true);  // Decodifica la cadena JSON a array
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Error al decodificar JSON: " . json_last_error_msg());  // Muestra el error si no se pudo decodificar
            echo "Error al decodificar JSON";  // Enviar un mensaje si hay un error
            exit;
        }
    } else {
        // Si no es un string, entonces ya es un array
        $productos = $_POST['productos'];
        error_log("Productos ya son un array: " . print_r($productos, true));  // Muestra los productos si ya son un array
    }

    // Verifica si los productos son válidos
    if (empty($productos)) {
        echo "No se recibieron productos válidos.";
        exit;
    }

    // Tomamos la descripción general de la venta
    $descripcion_venta = $_POST['descripcion'];

    // Comienza a realizar la inserción en la base de datos
    $conexion = conexion();
    $id_factura = $_POST['id_factura'];
    $fecha = date('Y-m-d');
    $hora = $_POST['hora'];
    $tipo_transaccion = $_POST['tipo_transaccion'];

    // Iniciar la transacción
    mysqli_begin_transaction($conexion);

    try {
        // Inserción principal en la tabla movimientos (para cada producto)
        foreach ($productos as $producto) {
            $id_producto = $producto['id_producto'];
            $cantidad = $producto['cantidad'];
            $precio_unitario = $producto['precio_unitario'];
            $total = $producto['precio_total'];  // Ya viene calculado

            // Usamos la misma descripción para todos los productos
            $descripcion = $descripcion_venta;

            // Preparar la consulta de inserción en la tabla movimiento
            $query = "INSERT INTO movimiento (id_factura, tipo_transaccion, fecha, hora, producto_id, cantidad, precio_unitario, total, descripcion) 
                      VALUES ('$id_factura', '$tipo_transaccion', '$fecha', '$hora', '$id_producto', '$cantidad', '$precio_unitario', '$total', '$descripcion')";
            // Depurar la consulta para ver si hay algún error
            error_log("Consulta de inserción de venta: " . $query);

            // Ejecutar la consulta
            $result = mysqli_query($conexion, $query);

            if (!$result) {
                // Si hay un error en la inserción, realizar un rollback
                mysqli_roll_back($conexion);
                error_log("Error al insertar en movimientos: " . mysqli_error($conexion));
                echo "Error al insertar la venta";
                exit;
            }

            // Descontar del inventario
            $queryInventario = "UPDATE productos SET cantidad_existente = cantidad_existente - $cantidad WHERE id_producto = $id_producto";
            $resultInventario = mysqli_query($conexion, $queryInventario);

            if (!$resultInventario) {
                // Si hay un error al actualizar el inventario, realizar un rollback
                mysqli_roll_back($conexion);
                error_log("Error al actualizar el inventario: " . mysqli_error($conexion));
                echo "Error al actualizar el inventario";
                exit;
            }
        }

        // Confirmar la transacción
        mysqli_commit($conexion);
        echo 1;

    } catch (Exception $e) {
        // En caso de error, hacer rollback y mostrar el error
        mysqli_roll_back($conexion);
        error_log("Error en la transacción: " . $e->getMessage());
        echo "Error en la transacción: " . $e->getMessage();
    }

} else {
    echo "Faltan datos necesarios para procesar la venta";
    exit;
}

?>
