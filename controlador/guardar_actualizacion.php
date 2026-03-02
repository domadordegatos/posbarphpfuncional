<?php
session_start();
require_once "../modelo/conexion.php";
require_once "../modelo/productos.php";
date_default_timezone_set('America/Bogota');
$conexion = conexion();  // Establecer la conexión

$obj = new productos();  // Crear el objeto del modelo productos

// Obtener los datos enviados por POST
$id_producto = $_POST['id_producto'];
$nombre_producto = $_POST['nombre_producto'];
$codigo_producto = $_POST['codigo_producto'];  // Agregar el campo código de barras
$categoria = $_POST['categoria'];
$precio_unitario = $_POST['precio_unitario'];
$cantidad_existente = $_POST['cantidad_existente'];
$minimo_stock = $_POST['minimo_stock'];
$estado = $_POST['estado'];

// Llamar al método para actualizar el producto, incluyendo el código de barras
$result = $obj->editarProducto($id_producto, $nombre_producto, $codigo_producto, $categoria, $precio_unitario, $cantidad_existente, $minimo_stock, $estado);

// Devolver el resultado (1 o 0) al cliente
echo $result;
?>