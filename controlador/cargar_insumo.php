<?php
session_start();
require_once "../modelo/conexion.php";
date_default_timezone_set('America/Bogota');
// Asegúrate de que los datos del insumo estén siendo recibidos correctamente
if (isset($_POST['id_factura']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['tipo_transaccion']) && isset($_POST['descripcion']) && isset($_POST['valor'])) {

    // Obtener los datos enviados
    $id_factura = $_POST['id_factura'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $tipo_transaccion = $_POST['tipo_transaccion'];
    $descripcion = $_POST['descripcion'];
    $valor = $_POST['valor'];

    // Conexión a la base de datos
    $conexion = conexion();

    // Inserción del insumo en la tabla movimientos
    $query = "INSERT INTO movimiento (id_factura, tipo_transaccion, fecha, hora, producto_id, cantidad, precio_unitario, total, descripcion) 
              VALUES ('$id_factura', '$tipo_transaccion', '$fecha', '$hora', 1, 0, 0, '$valor', '$descripcion')";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo 1;  // Indicar que la inserción fue exitosa
    } else {
        echo 0;  // Indicar que hubo un error en la inserción
    }
} else {
    echo 0;  // Indicar que faltan datos necesarios
}
?>
