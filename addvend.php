<?php
    if(isset($_GET["b"]) && $_GET["b"] == 0)
    {
        foreach ($_COOKIE as $key => $valor)
        {
            unset($_COOKIE[$key]);
            setcookie($key, '0', time() - 1000);
        }
        setcookie("PrecioTotalVenta", 0, 0);
    }
    else if(isset($_GET["b"]) && $_GET["b"] == 1)
    {
        include "conectar.php";
        $Consulta = mysqli_query($Conexion, "SELECT * FROM `almacen` WHERE Referencia = '".str_replace('   ', '', $_POST['Ref_Ve'])."' OR Nombre = '".$_POST['Nam_Ve']."' LIMIT 1");
        $row=mysqli_fetch_array($Consulta);
        if($_POST['Precio_VE'] == "") $PrecioUnidad = $row['Precio'];
        else $PrecioUnidad = $_POST['Precio_VE'];
        $PrecioTotal = $_POST['Cantidad_VE']*$PrecioUnidad;
        $DescuentoU = 100-(($PrecioUnidad*100)/$row['Precio']);
        $DescuentoT = 100-(($PrecioTotal*100)/($_POST['Cantidad_VE']*$row['Precio']));

        setcookie("PrecioTotalVenta", $_COOKIE["PrecioTotalVenta"]+$PrecioTotal, 0);
        /*setcookie("PrecioTotal_".$_GET['a'], $PrecioTotal, 0);
        setcookie("Ref_".$_GET['a'], $row['Referencia'], 0);*/


        $LosDatos = "<tr id='".$_GET['a']."' refe='".$row['Referencia']."' name='".$row['Nombre']."' cost='".$PrecioTotal."' cuanto='".$_POST['Cantidad_VE']."' dt='".$DescuentoT."' du='".$DescuentoU."'><td>".$row['Referencia']." - ".$row['Nombre']."</td><td id='prec_".$_GET['a']."'>".number_format($PrecioTotal, 0, ",", ".")." $</td><td>".number_format($PrecioUnidad, 0, ",", ".")." $</td><td>".number_format($DescuentoT, 2, ",", ".")."%</td><td>".number_format($DescuentoU, 2, ",", ".")."%</td><td><button onclick='Eliminar(".$_GET['a'].")' type='button' class='close' aria-label='Close'><span aria-hidden='true' >&times;</span></button></td></tr>";
        echo $LosDatos;
    }
    else if(isset($_GET["b"]) && $_GET["b"] == 2)
    {
        echo number_format($_COOKIE['PrecioTotalVenta'], 0, ",", ".")." $";
    }
    else if(isset($_GET["b"]) && $_GET["b"] == 3)
    {
        setcookie("PrecioTotalVenta", $_COOKIE["PrecioTotalVenta"]-$_COOKIE["PrecioTotal_".$_GET['a']], 0);
        echo number_format($_COOKIE["PrecioTotalVenta"]-$_COOKIE["PrecioTotal_".$_GET['a']], 0, ",", ".")." $";
    }
    else if(isset($_GET["b"]) && $_GET["b"] == 4)
    {
        $Cambio = $_GET['a']-$_COOKIE['PrecioTotalVenta'];
        echo "Efectivo: ".number_format($_COOKIE['PrecioTotalVenta'], 0, ",", ".")."$\n\nVlr. Recibido: ".number_format($_GET['a'], 0, ",", ".")."$\nVlr. Cambio: ".number_format($Cambio, 0, ",", ".")."$";
    }
    else if(isset($_GET["b"]) && $_GET["b"] == 5)
    {
        include "conectar.php";
        $sql = "INSERT INTO `registros`(`Referencia`, `Nombre`, `Fecha`, `Tipo`, `PrecioTotal`, `Salida`, `DescT`, `DescU`, `Recibido`, `PrecioTotalVenta`) VALUES ('".$_GET['r']."', '".$_GET['n']."', '".$_GET['t']."', '1', '".$_GET['p']."', '".$_GET['c']."', '".$_GET['dt']."', '".$_GET['du']."', '".$_GET['i']."', '".$_COOKIE['PrecioTotalVenta']."')";
        mysqli_query($Conexion, $sql);
        $sql = "UPDATE `almacen` SET `Cantidad`=Cantidad-".$_GET['c']." WHERE `Referencia` = '".$_GET['r']."'";
        mysqli_query($Conexion, $sql);
        echo $sql;
    }
?>