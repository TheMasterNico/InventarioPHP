<?php
    include "conectar.php";
?>   
<?php
    $Consulta = mysqli_query($Conexion, "SELECT * FROM `almacen` ORDER BY `Cantidad` DESC");
    $LosDatos = '<table class="table table-striped table-bordered">
                <tr>
                    <th>Referencia</th>
                    <th>Nombre</th>
                    <th>Cantidad Actual</th>
                    <th>Precio (Unidad)</th>
                </tr>';
    while ($row=mysqli_fetch_array($Consulta))
    {
        if(isset($_GET['ref']) && $_GET['ref'] == $row['Referencia']) $flagclass = "class='success'";
        else if(isset($_GET['nam']) && $_GET['nam'] == $row['Nombre']) $flagclass = "class='success'";
        else $flagclass = null;
        if($row['Cantidad'] == 0) $flagtd = 'class="danger"'; else $flagtd = null;
        $LosDatos .= "<tr ".$flagclass." id='".$row['Referencia']."' name='".$row['Nombre']."'><td>".$row['Referencia']."</td><td>".$row['Nombre']."</td><td ".$flagtd.">".$row['Cantidad']."</td><td>".number_format($row['Precio'], 0, ",", ".")."</td></tr>";
    }
    echo $LosDatos.'</table>'
?>