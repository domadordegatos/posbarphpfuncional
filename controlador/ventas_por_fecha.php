<?php
require_once "../modelo/conexion.php";

// Obtener las fechas desde los parámetros GET
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

if ($fecha_inicio && $fecha_fin) {
    // Convertir las fechas a formato adecuado (YYYY-MM-DD)
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    // Consulta SQL para obtener las ventas en el rango de fechas
$query = "
    SELECT 
        m.id_factura, 
        m.fecha, 
        m.hora, 
        SUM(total) AS total_venta
    FROM movimiento m
    WHERE m.tipo_transaccion = 1 
    AND m.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
    GROUP BY m.id_factura, m.fecha, m.hora
    ORDER BY m.id_factura DESC, m.hora DESC
";


    // Ejecutar la consulta
    $conexion = conexion();
    $result = mysqli_query($conexion, $query);

    // Verificar si hay resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Crear un array para almacenar las facturas
        $facturas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $facturas[] = $row;
        }

        // Retornar los datos en formato JSON
        echo json_encode($facturas);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
