<?php
    include "conectar.php";
?>   
<?php
    $Consulta = mysqli_query($Conexion, "SELECT * FROM `almacen` ORDER BY `Nombre`");
    $LosDatos = null;
    while ($row=mysqli_fetch_array($Consulta))
    {
        $LosDatos .= "<option value='".$row['Referencia']."'>".$row['Referencia']." - ".$row['Nombre']."</option>";
    }
    echo $LosDatos;
?>