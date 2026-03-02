<?php
class productos {

    // Función para obtener todos los productos
public function obtenerTodosLosProductos() {
    require_once "conexion.php";  // Asegúrate de que la conexión esté configurada correctamente
    $conexion = conexion();  // Establecer la conexión
    unset($_SESSION['consulta_productos_temp']);

    // Consulta para obtener todos los productos, incluyendo el código de barras
$sql = " 
    SELECT 
        p.id_producto, 
        p.nombre_producto, 
        c.descripcion AS categoria, 
        p.estado, 
        p.cantidad_existente, 
        p.precio_unitario, 
        p.minimo_stock, 
        p.codigo  -- Agregado al final
    FROM 
        productos p 
    JOIN 
        categorias c ON p.categoria = c.id_categoria 
    ORDER BY 
        p.nombre_producto ASC 
";
    
    $result = mysqli_query($conexion, $sql);

    // Verificar si hay productos
    if (mysqli_num_rows($result) <= 0) {
        echo 2; // No existen productos
    } else {
        while ($ver1 = mysqli_fetch_row($result)) {
            // Formato de datos que se van a enviar a la sesión
            // Ahora incluimos el código de barras en la cadena
            $tabla = $ver1[0] . "||" .   // id_producto
                    $ver1[1] . "||" .   // nombre_producto
                    $ver1[2] . "||" .   // codigo (nuevo campo)
                    $ver1[3] . "||" .   // categoria
                    $ver1[4] . "||" .   // estado (activo o inactivo)
                    $ver1[5] . "||" .   // cantidad_existente
                    $ver1[6] . "||" .   // precio_unitario
                    $ver1[7] . "||";    // minimo_stock

            // Guardar los datos en la sesión para usarlos más tarde
            $_SESSION['consulta_productos_temp'][] = $tabla;
        }
        echo 1; // Productos encontrados
    }
}

public function crearProducto($nombre_producto, $codigo_producto, $categoria, $precio_unitario, $cantidad_existente, $minimo_stock, $estado) {
    require_once "conexion.php";
    $conexion = conexion();

    // Consulta SQL para insertar el producto, incluyendo el código de barras
    $sql = "INSERT INTO productos (nombre_producto, codigo, categoria, precio_unitario, cantidad_existente, minimo_stock, estado) 
            VALUES ('$nombre_producto', '$codigo_producto', '$categoria', '$precio_unitario', '$cantidad_existente', '$minimo_stock', '$estado')";

    if (mysqli_query($conexion, $sql)) {
        return 1;  // Si la inserción fue exitosa, retorna 1
    } else {
        return 0;  // Si hubo un error, retorna 0
    }
}

public function obtenerProductoPorId($id_producto) {
    // Establecer la conexión a la base de datos
    require_once "conexion.php";
    $conexion = conexion();  // Establecer la conexión

    // Consulta para obtener los datos del producto por su ID, incluyendo el código de barras
    $sql = "SELECT id_producto, nombre_producto, categoria, precio_unitario, cantidad_existente, minimo_stock, estado, codigo
            FROM productos
            WHERE id_producto = '$id_producto'";  // Consulta SQL

    // Ejecutar la consulta
    $result = mysqli_query($conexion, $sql);

    // Verificar si se encontró el producto
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);  // Si se encuentra, devolver los datos como array asociativo
    } else {
        return false;  // Si no se encuentra el producto, devolver false
    }
}

public function editarProducto($id_producto, $nombre_producto, $codigo_producto, $categoria, $precio_unitario, $cantidad_existente, $minimo_stock, $estado) {
    require_once "conexion.php";
    $conexion = conexion();

    // Actualización de los datos del producto incluyendo el código de barras
    $sql = "UPDATE productos 
            SET nombre_producto = '$nombre_producto', 
                codigo = '$codigo_producto', 
                categoria = '$categoria', 
                precio_unitario = '$precio_unitario', 
                cantidad_existente = '$cantidad_existente', 
                minimo_stock = '$minimo_stock', 
                estado = '$estado' 
            WHERE id_producto = '$id_producto'";

    if (mysqli_query($conexion, $sql)) {
        return 1;  // Si la actualización fue exitosa
    } else {
        return 0;  // Si hubo un error
    }
}
}
?>
