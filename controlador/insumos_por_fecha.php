<?php
require_once "../modelo/conexion.php";  // Incluir el archivo de conexión a la base de datos

// Establecer la zona horaria
date_default_timezone_set('America/Bogota');

// Obtener las fechas desde la solicitud GET
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];

// Establecer la conexión
$conexion = conexion();

// Consulta para obtener los insumos dentro del rango de fechas y con tipo de transacción 2, 3 y 4
$query = "
    SELECT 
        i.id_movimiento, 
        i.fecha, 
        i.descripcion, 
        i.total, 
        tt.descripcion AS tipo_transaccion,
        i.id_factura
    FROM 
        movimiento i
    JOIN 
        tipo_transaccion tt ON i.tipo_transaccion = tt.id_transaccion
    WHERE 
        i.tipo_transaccion IN (2, 3, 4) 
        AND i.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
    ORDER BY 
        i.fecha DESC
";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si la consulta devuelve resultados
if ($result && mysqli_num_rows($result) > 0) {
    $insumos = [];

    // Recoger los resultados en un array
    while ($row = mysqli_fetch_assoc($result)) {
        $insumos[] = $row;
    }

    // Devolver los datos en formato JSON
    echo json_encode($insumos);
} else {
    // Si no se encontraron insumos, devolver un array vacío
    echo json_encode([]);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
