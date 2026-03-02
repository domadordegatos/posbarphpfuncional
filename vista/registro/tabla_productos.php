<?php
session_start();
?>
<table class="table table-bordered table-sm" style="font-size: 0.9rem !important;">
    <tr class="table-primary text-dark">
        <td>ID</td>
        <td>Nombre Producto</td>
        <td>Categoría</td>
        <td>Precio Unitario</td>
        <td>Existencia</td>
        <td>Estado</td>
        <td>Mínimo Stock</td>
        <td>Acción</td>
    </tr>

    <?php
    // Verifica si existen productos en la sesión
    if (isset($_SESSION['consulta_productos_temp'])):
        foreach ($_SESSION['consulta_productos_temp'] as $key) {
            // Separa los datos por el delimitador "||"
            $dat = explode("||", $key);
            
            // Lógica para comprobar si la existencia es menor o igual al mínimo stock
            $existencia_color = ($dat[4] <= $dat[6]) ? 'style="background-color: #FFCCCC;"' : '';  // Si la cantidad existente es menor o igual al mínimo stock, poner el fondo rojo
            
            // Lógica para cambiar el color de la fila si el estado es "Inactivo"
            $row_class = ($dat[3] == 0) ? 'class="table-secondary"' : '';  // Si el estado es inactivo, poner el fondo gris claro
    ?>
        <tr <?php echo $row_class; ?>>
            <!-- Mostrar datos de los productos -->
            <td><?php echo $dat[0]; ?></td>  <!-- id_producto -->
            <td class="text-uppercase"><?php echo $dat[1] . ' - ' . $dat[7]; ?></td>  <!-- nombre_producto -->
            <td><?php echo $dat[2]; ?></td>  <!-- categoria -->
            <td><?php echo number_format($dat[5]); ?></td>  <!-- precio_unitario -->
            <td class="text-center" <?php echo $existencia_color; ?>>
                <?php echo $dat[4]; ?>
            </td>  <!-- cantidad_existente -->
            <td>
                <?php echo ($dat[3] == 1 ? 'Activo' : 'Inactivo'); ?>
            </td>  <!-- estado -->
            <td class="text-center">
                <?php echo $dat[6]; ?>
            </td>  <!-- minimo_stock -->
            <td class="d-flex justify-content-center">
                <button class="btn btn-warning" onclick="cargar_datos_producto_actualizar('<?php echo $dat[0]; ?>')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                </button>
            </td>
        </tr>
    <?php 
        }  
    endif;
    ?>
</table>
