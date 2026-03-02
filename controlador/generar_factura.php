<?php
session_start();
require_once "../modelo/conexion.php";
date_default_timezone_set('America/Bogota');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexion = conexion();

    // Consulta para obtener el último número de factura
    $query = "SELECT MAX(id_factura) AS last_invoice FROM movimiento";
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    
    // Si no hay registros, comenzamos desde 1
    $id_factura = $row['last_invoice'] ? $row['last_invoice'] + 1 : 1;

    echo $id_factura;  // Retornamos el número de factura
}
?>
