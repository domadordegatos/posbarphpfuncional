<?php
session_start();
require_once "../modelo/conexion.php"; // Asegúrate de que la conexión esté configurada correctamente
date_default_timezone_set('America/Bogota');

// Conectar a la base de datos
$conexion = conexion();

// Obtener el valor de búsqueda (nombre o código de barras)
$producto_buscar = $_POST['producto_buscar'];

// Consulta SQL para buscar por nombre de producto o código de barras
$sql = "SELECT id_producto, nombre_producto, codigo, precio_unitario
        FROM productos 
        WHERE (nombre_producto LIKE '%$producto_buscar%' OR codigo LIKE '%$producto_buscar%')
        AND estado = 1 
        LIMIT 10"; // Limitar a 10 resultados

$result = mysqli_query($conexion, $sql);

// Crear un array para almacenar los productos encontrados
$productos = [];

// Si la consulta tiene resultados, agregarlos al array
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;  // Añadir cada producto al array
}

// Devolver los productos encontrados como JSON
echo json_encode($productos);

// Cerrar la conexión
mysqli_close($conexion);
?>