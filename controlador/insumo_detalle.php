<?php
// Conexión a la base de datos
require_once "../modelo/conexion.php";

// Obtener el ID del insumo desde la URL
if (isset($_GET['id_insumo'])) {
    $id_insumo = $_GET['id_insumo'];

    // Consulta SQL para obtener los detalles del insumo
    $query = "
        SELECT 
            m.id_movimiento, 
            m.fecha, 
            m.descripcion, 
            m.total, 
            tt.descripcion AS tipo_transaccion,
            m.id_factura
        FROM movimiento m
        JOIN tipo_transaccion tt ON m.tipo_transaccion = tt.id_transaccion
        WHERE m.id_movimiento = '$id_insumo'
    ";

    // Ejecutar la consulta
    $conexion = conexion();
    $result = mysqli_query($conexion, $query);

    // Verificar si hay resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener los detalles del insumo
        $insumo = mysqli_fetch_assoc($result);

        // Retornar los datos en formato JSON
        echo json_encode($insumo);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
