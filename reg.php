<?php
    include "conectar.php";
?>   
<?php
    date_default_timezone_set("America/Bogota");
    $Consulta = mysqli_query($Conexion, "SELECT * FROM `registros` ORDER BY `Fecha` DESC");
    $LosDatos = '<table class="table table-striped table-bordered">
                <tr>
                    <th>Fecha</th>
                    <th>Referencia - Nombre</th>
                    <th>Tramite</th>
                    <th>Precio</th>
                    <th>Precio (Unidad)</th>
                    <th>Descuento Total</th>
                    <th>Descuento Unitario</th>
                </tr>';
    while ($row=mysqli_fetch_array($Consulta))
    {
        if($row["Tipo"] == 1)$Tooltip = "data-toggle='tooltip' data-placement='right' title='Por esta compra se recibieron ".number_format($row['Recibido'], 0, ",", ".")." $ y se dio un cambio de ".number_format($row['Recibido']-$row['PrecioTotalVenta'], 0, ",", ".")." $'";
        $LosDatos .= "<tr ".$Tooltip.">";
        $LosDatos .= "<td>".date("d/m/y - h:i a", $row["Fecha"])."</td>";
        $LosDatos .= "<td>".$row["Referencia"]." - ".$row["Nombre"]."</td>";
        if($row["Tipo"] == 0) $LosDatos .= "<td>Entran: ".$row["Entrada"]."</td>";
        else if($row["Tipo"] == 1) $LosDatos .= "<td>Salen: ".$row["Salida"]."</td>";
        else if($row["Tipo"] == 2) $LosDatos .= "<td>Se agrega el producto</td>";
        if($row["Tipo"] != 2) $LosDatos .= "<td>".number_format($row["PrecioTotal"], 0, ",", ".")." $</td>"; else $LosDatos .= "<td></td>";
        if($row["Tipo"] != 1) $LosDatos .= "<td>".number_format($row["PrecioUnidad"], 0, ",", ".")." $</td>"; else  $LosDatos .= "<td>".number_format($row["PrecioTotal"]/$row["Salida"], 0, ",", ".")." $</td>";
        if($row["Tipo"] == 1)
        {
            $LosDatos .= "<td>".number_format($row["DescT"], 2, ",", ".")."%</td>";
            $LosDatos .= "<td>".number_format($row["DescU"], 2, ",", ".")."%</td>";
        }
        else $LosDatos .= "<td></td><td></td>";
        $LosDatos .= "</tr>";
    }
    echo $LosDatos.'</table>';