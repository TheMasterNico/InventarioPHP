<?php
    include "conectar.php";
?>   
    <?php
        if(isset($_GET['Alm']) && $_GET['Alm'] == 1)   
        {
            $NuevoProducto = mysqli_query($Conexion, "UPDATE `almacen` SET Cantidad = Cantidad+".$_POST['Cantidad_New']." WHERE `Referencia` = '".$_POST['Nombre_New']."'");
            //echo "UPDATE `almacen` SET Cantidad = Cantidad+".$_POST['Cantidad_New']." WHERE `Referencia` = ".$_POST['Nombre_New'];
            if($NuevoProducto === TRUE)
            {
                mysqli_query($Conexion, "INSERT INTO `registros`(`Referencia`, `Entrada`, `Fecha`, `Proveedor`, `PrecioTotal`, `PrecioUnidad`) VALUES ('".$_POST['Nombre_New']."', '".$_POST['Cantidad_New']."', '".time()."', '".$_POST['Proveedor_New']."', '".$_POST['Precio_New']."', '".$_POST['Precio_New']/$_POST['Cantidad_New']."')");
                echo "El producto con la referencia '".$_POST['Nombre_New']."' fue almacenado con exito\n\n";
            }
            else    {
                echo "No se pudo agregar el producto\n".mysqli_error($Conexion);                
            }
        }
    ?>