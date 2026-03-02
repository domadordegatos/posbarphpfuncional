<?php
session_start();
require_once "../modelo/conexion.php";
require_once "../modelo/productos.php";

// Establecer la conexión con la base de datos
$conexion = conexion();

// Crear el objeto del modelo productos
$obj = new productos();

// Obtener el ID del producto desde la solicitud POST
$id_producto = $_POST['id_producto'];

// Llamar al método del modelo que obtiene los datos del producto por su ID
$result = $obj->obtenerProductoPorId($id_producto);

// Verificar si el producto fue encontrado
if ($result) {
    // Devolver los datos del producto en formato JSON, incluyendo el código de barras
    echo json_encode($result);
} else {
    // Si no se encuentra el producto, devolver un array vacío
    echo json_encode([]);
}
?>