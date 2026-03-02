<?php
require_once "../modelo/conexion.php";
$conexion = conexion();  // Establecer la conexión

// Obtener la fecha actual
date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d');  // Ejemplo: 2025-08-21
// Consulta SQL para obtener las ventas del día actual y la suma de los productos vendidos
$query = "
    SELECT
        m.id_factura,
        m.fecha,
        m.hora,
        SUM(total) AS total_venta
    FROM
        movimiento m
    WHERE
        m.tipo_transaccion = 1 and m.fecha = '$fecha_actual'
    GROUP BY
        m.id_factura, m.fecha, m.hora
    ORDER BY
        m.hora DESC  -- Ordenar por hora si lo deseas
";

// Ejecutar la consulta y obtener los resultados
$result = mysqli_query($conexion, $query);

// Comprobar si hay resultados
if ($result && mysqli_num_rows($result) > 0) {
    // Crear un array para almacenar los resultados
    $facturas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $facturas[] = $row;  // Agregar cada fila a la lista de facturas
    }

    // Retornar los datos en formato JSON para usar en la vista
    echo json_encode($facturas);
} else {
    // No hay ventas para el día actual
    echo json_encode([]);
}
?>
