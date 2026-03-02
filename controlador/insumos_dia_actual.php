<?php
// Conexión a la base de datos
require_once "../modelo/conexion.php";
date_default_timezone_set('America/Bogota');
// Obtener la fecha actual (hoy)
$fecha_hoy = date('Y-m-d');

// Consulta SQL para obtener los insumos del día actual
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
    WHERE m.tipo_transaccion IN (2, 3, 4) 
    AND m.fecha = '$fecha_hoy'
    ORDER BY m.fecha DESC, m.id_movimiento DESC
";

// Ejecutar la consulta
$conexion = conexion();
$result = mysqli_query($conexion, $query);

// Verificar si hay resultados
if ($result && mysqli_num_rows($result) > 0) {
    // Crear un array para almacenar los insumos
    $insumos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $insumos[] = $row;
    }

    // Retornar los datos en formato JSON
    echo json_encode($insumos);
} else {
    echo json_encode([]);
}
?>
