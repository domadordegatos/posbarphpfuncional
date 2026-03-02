<?php
require_once "../modelo/conexion.php";
$conexion = conexion();  // Establecer la conexión
date_default_timezone_set('America/Bogota');
// Obtener el ID de la factura desde la URL
if (isset($_GET['id_factura'])) {
    $id_factura = $_GET['id_factura'];

    // Consulta para obtener los detalles de la factura desde la tabla "movimiento"
    $query = "
        SELECT 
            m.id_factura, 
            m.fecha, 
            m.hora, 
            p.nombre_producto, 
            m.cantidad, 
            m.precio_unitario, 
            m.total,
            m.descripcion
        FROM movimiento m
        JOIN productos p ON m.producto_id = p.id_producto
        WHERE m.id_factura = '$id_factura'
    ";

    // Ejecutar la consulta
    $result = mysqli_query($conexion, $query);

    // Verificar si hay resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Obtener la fecha y hora de la venta (una vez)
        $factura = mysqli_fetch_assoc($result);  
        $fecha = $factura['fecha'];
        $hora = $factura['hora'];

        // Inicializar el total de la venta y los productos
        $total_venta = 0;
        $productos = [];

        // Volver al inicio de los resultados para recorrer todos los productos
        mysqli_data_seek($result, 0);  // Restablecer el puntero de la consulta

        // Recorrer los resultados de la consulta y agregar los productos
        while ($row = mysqli_fetch_assoc($result)) {
            $productos[] = $row;
            $total_venta += $row['total'];  // Sumar el total de cada producto
        }

        // Obtener la descripción (si hay más de un producto)
        $descripcion = $productos[0]['descripcion'];  // Usar la primera descripción de los productos
    } else {
        echo "Factura no encontrada.";
        exit;
    }
} else {
    echo "ID de factura no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Factura #<?php echo $id_factura; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Detalles de la Factura #<?php echo $id_factura; ?></h2>
        <p><strong>Fecha:</strong> <?php echo $fecha; ?> | <strong>Hora:</strong> <?php echo $hora; ?></p>

        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['nombre_producto']; ?></td>
                        <td class="text-center"><?php echo $producto['cantidad']; ?></td>
                        <td>$<?php echo number_format($producto['precio_unitario']); ?></td>
                        <td>$<?php echo number_format($producto['total']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total de la Venta:</strong></td>
                    <td><strong>$<?php echo number_format($total_venta); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Mostrar la descripción solo si hay más de un producto -->
        <p><strong>Descripción de la venta:</strong> <?php echo $descripcion; ?></p>

        <div class="d-flex flex-row-reverse" >
            <a href="javascript:window.close()" class="btn btn-secondary">Cerrar</a>
        </div>
    </div>
</body>
</html>
