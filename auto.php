<?php
    include "conectar.php";
?>   
<?php
    $Consulta = mysqli_query($Conexion, "SELECT Nombre, Referencia FROM `almacen`");
    while ($row=mysqli_fetch_array($Consulta))
    {
        $Nombre[] = $row['Nombre'];
        $Referen[] = $row['Referencia'];
    }
    if(isset($_GET['a']) && $_GET['a'] == 1)
    {
        $Dato = implode("?", $Nombre);
        echo str_replace("   ", "", $Dato);
    }
    else if(isset($_GET['a']) && $_GET['a'] == 2)
    {
        $Dato = implode("?", $Referen);
        echo str_replace("   ", "", $Dato);
    }
?>