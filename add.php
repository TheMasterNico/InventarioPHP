<?php
    include "conectar.php";
?>   
    <?php
        if(isset($_GET['add']) && $_GET['add'] == 1)   
        {
            $NuevoProducto = mysqli_query($Conexion, "INSERT INTO `almacen`(`Referencia`, `Nombre`, `Descripcion`, `Cantidad`, `Precio`) VALUES ('".$_POST['Referencia_Add']."','".$_POST['Nombre_Add']."','".$_POST['Descripcion_Add']."','0','".$_POST['Precio_Add']."')");
            //echo "INSERT INTO `almacen`(`Referencia`, `Nombre`, `Descripcion`, `Cantidad`, `Precio`) VALUES ('".$_POST['Referencia_Add']."','".$_POST['Nombre_Add']."','".$_POST['Descripcion_Add']."','0','".$_POST['Precio_Add']."')";
            if($NuevoProducto === TRUE)
            {
                mysqli_query($Conexion, "INSERT INTO `registros`(`Referencia`, `Nombre`, `Fecha`, `Tipo`, `PrecioUnidad`) VALUES ('".$_POST['Referencia_Add']."', '".$_POST['Nombre_Add']."', '".time()."', '2', '".$_POST['Precio_Add']."')");
                echo "Se agrego con exito el producto.\n\n\n\nNombre: ".$_POST['Nombre_Add']."\nReferencia: ".$_POST['Referencia_Add']."\nPrecio: ".$_POST['Precio_Add'];
            }
            else    {
                echo "No se pudo agregar el producto\n".mysqli_error($Conexion);                
            }
        }
    ?>