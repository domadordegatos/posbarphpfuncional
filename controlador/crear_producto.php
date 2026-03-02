<?php
session_start();
require_once "../modelo/conexion.php";
require_once "../modelo/productos.php";

$conexion = conexion();  // Establecer la conexión

// Crear un objeto del modelo productos
$obj = new productos();

// Obtener los datos enviados por POST
$nombre_producto = $_POST['nombre_producto'];
$codigo_producto = $_POST['codigo_producto'];  // Obtener el código de barras
$categoria = $_POST['categoria'];
$precio_unitario = $_POST['precio_unitario'];
$cantidad_existente = $_POST['cantidad_existente'];
$minimo_stock = $_POST['minimo_stock'];
$estado = $_POST['estado'];

// Llamar al método para crear el producto, pasando los datos, incluido el código de barras
$result = $obj->crearProducto(
    $nombre_producto,
    $codigo_producto,  // Pasar el código de barras a la función
    $categoria,
    $precio_unitario,
    $cantidad_existente,
    $minimo_stock,
    $estado
);

// Devolver el resultado (1 o 0) al cliente
echo $result;
?>