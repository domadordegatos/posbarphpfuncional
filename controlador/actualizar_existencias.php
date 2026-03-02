<?php
session_start();
require_once "../modelo/conexion.php";
require_once "../modelo/productos.php"; // Asegúrate de que el modelo esté correctamente configurado
date_default_timezone_set('America/Bogota');
$conexion = conexion();  // Establecer conexión a la base de datos

// Obtener los datos enviados por AJAX
$id_producto = $_POST['id_producto'];  // ID del producto seleccionado
$cantidad_nueva = $_POST['cantidad_nueva'];  // Cantidad nueva a agregar

// Validar si los datos son correctos
if (is_numeric($id_producto) && is_numeric($cantidad_nueva) && $cantidad_nueva > 0) {

    // Consulta para obtener la cantidad existente del producto
    $sql = "SELECT cantidad_existente FROM productos WHERE id_producto = $id_producto";
    $result = mysqli_query($conexion, $sql);

    // Verificar si el producto existe
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cantidad_actual = $row['cantidad_existente'];

        // Sumar la nueva cantidad a la existente
        $nueva_cantidad = $cantidad_actual + $cantidad_nueva;

        // Actualizar la cantidad existente del producto
        $update_sql = "UPDATE productos SET cantidad_existente = $nueva_cantidad WHERE id_producto = $id_producto";
        if (mysqli_query($conexion, $update_sql)) {
            echo 1;  // Actualización exitosa
        } else {
            echo 0;  // Error en la actualización
        }
    } else {
        echo 0;  // Producto no encontrado
    }
} else {
    echo 0;  // Datos inválidos
}

mysqli_close($conexion);  // Cerrar la conexión
?>
