<?php
date_default_timezone_set('America/Bogota');
// Asegúrate de que se reciben los parámetros
if (isset($_POST['id_producto']) && isset($_POST['cantidad_solicitada'])) {
    $id_producto = $_POST['id_producto'];  // ID del producto
    $cantidad_solicitada = $_POST['cantidad_solicitada'];  // Cantidad solicitada

    // Realiza la consulta para obtener la cantidad disponible en inventario
    require_once "../modelo/conexion.php";
    $conexion = conexion();

    // Consulta SQL para obtener la cantidad existente
    $query = "SELECT cantidad_existente FROM productos WHERE id_producto = '$id_producto'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $producto = mysqli_fetch_assoc($result);
        if ($producto) {
            // Verificar si el producto existe en la base de datos
            $cantidad_existente = $producto['cantidad_existente'];  // Usamos el campo cantidad_existente
            echo json_encode(['existencia' => $cantidad_existente]);  // Devolver cantidad existente
        } else {
            echo json_encode(['existencia' => 0]);  // Producto no encontrado, 0 existencia
        }
    } else {
        echo json_encode(['existencia' => 0]);  // Error en la consulta
    }
} else {
    echo json_encode(['existencia' => 0]);  // Parámetros no enviados correctamente
}
?>
