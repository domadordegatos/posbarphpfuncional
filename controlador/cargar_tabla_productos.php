<?php
session_start();
require_once "../modelo/conexion.php";  // Asegúrate de que la conexión esté configurada correctamente
require_once "../modelo/productos.php";  // Incluye el archivo del modelo de productos

$conexion = conexion();  // Establecer la conexión

// Crear un objeto del modelo productos
$obj = new productos();

// Obtener todos los productos llamando al método del modelo
$result = $obj->obtenerTodosLosProductos();

// Devolver el resultado (la tabla de productos generada)
echo $result;
?>
