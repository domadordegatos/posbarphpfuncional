<?php
require_once "../modelo/conexion.php";
date_default_timezone_set('America/Bogota');
$conexion = conexion();

// Realizamos la consulta para obtener las descripciones de los tipos de transacción
$query = "SELECT id_transaccion, descripcion FROM tipo_transaccion order by id_transaccion desc";
$result = mysqli_query($conexion, $query);

if ($result) {
    $tipos_transaccion = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tipos_transaccion[] = $row;  // Almacenamos los datos en un array
    }
    
    echo json_encode($tipos_transaccion);  // Convertimos el array a JSON y lo devolvemos
} else {
    echo json_encode(["error" => "No se pudieron obtener los tipos de transacción."]);
}
?>
