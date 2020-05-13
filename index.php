<?php
    include "conectar.php";
?>

<!DOCTYPE html>
<html style="padding-top:5px;">
	<head>		
		<title>Manejo de inventario</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="author" content="Nicolás Castillo">	

		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> 
		 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<script src="js/bootstrap.min.js"></script> 
		<script src="js/scroll.js"></script>   
		<meta name="viewport" content="width=device-width, initial-scale=1">    
        <script>            
            
        var net = new Object();

        net.READY_STATE_UNINITIALIZED=0; 
        net.READY_STATE_LOADING=1; 
        net.READY_STATE_LOADED=2; 
        net.READY_STATE_INTERACTIVE=3; 
        net.READY_STATE_COMPLETE=4; 

        // Constructor
        net.CargadorContenidos = function(url, funcion, funcionError, metodo, parametros, contentType) {
          this.url = url;
          this.req = null;
          this.onload = funcion;
          this.onerror = (funcionError) ? funcionError : this.defaultError;
          this.cargaContenidoXML(url, metodo, parametros, contentType);
        }

        net.CargadorContenidos.prototype = {
          cargaContenidoXML: function(url, metodo, parametros, contentType) {
            if(window.XMLHttpRequest) {
              this.req = new XMLHttpRequest();
            }
            else if(window.ActiveXObject) {
              this.req = new ActiveXObject("Microsoft.XMLHTTP");
            }

            if(this.req) {
              try {
                var loader = this;
                this.req.onreadystatechange = function() {
                  loader.onReadyState.call(loader);
                }
                this.req.open(metodo, url, true);
                if(contentType) {
                  this.req.setRequestHeader("Content-Type", contentType);
                }
                this.req.send(parametros);
                } catch(err) {
                  this.onerror.call(this);
                }
            }
          },

          onReadyState: function() {
            var req = this.req; 
            var ready = req.readyState; 
            if(ready == net.READY_STATE_COMPLETE) { 
              var httpStatus = req.status; 
              if(httpStatus == 200 || httpStatus == 0) { 
                this.onload.call(this);
              }
              else {
                this.onerror.call(this);
              }
            }
          },

          defaultError: function() {
            alert("Se ha producido un error al obtener los datos"
              + "\n\nreadyState:" + this.req.readyState
              + "\nstatus: " + this.req.status
              + "\nheaders: " + this.req.getAllResponseHeaders());
          }
        }


        </script>        
	</head>
    <body>
        <div class="container" id="header">
            <ul class="nav nav-tabs nav-justified" id="Lista">
                <li id="li_1" role="presentation" class="active"><a id="enlace_1" href="#">VENDER</a></li>
                <li id="li_2" role="presentation"><a id="enlace_2" href="#">AGREGAR</a></li>
                <li id="li_3" role="presentation"><a id="enlace_3" href="#">ALMACENAR</a></li>
                <li id="li_4" role="presentation"><a id="enlace_4" href="#">BUSCAR</a></li>
                <li id="li_5" role="presentation"><a id="enlace_5" href="#">REGISTROS</a></li>
            </ul>   
        </div> 
        
        <script>
            var CantidadVenta = -1;
            $(document).ready(function(){
                
                new net.CargadorContenidos("http://localhost/Inventario/auto.php?a=1&nocache="+Math.random(), AutComple1, null, "GET", null, "application/x-www-form-urlencoded");
                new net.CargadorContenidos("http://localhost/Inventario/auto.php?a=2&nocache="+Math.random(), AutComple2, null, "GET", null, "application/x-www-form-urlencoded");
                new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=0&nocache="+Math.random(), NH, null, "GET", null, "application/x-www-form-urlencoded");
                $( "#NamVE" ).keypress(function(event) {
                    if (event.keyCode != 9) $('#RefVE').val('');
                });  
                $( "#RefVE" ).keypress(function(event) {
                    if (event.keyCode != 9) $('#NamVE').val('');
                });       
                $('#Lista').click(OcultarCabecera); 
                $('#submit_li_1').click(Vend);
                $('#form_li_1').keypress(function(event) {
                    if (event.which == 13) Vend();
                });
                $('#submit_li_2').click(Add);
                $('#form_li_2').keypress(function(event) {
                    if (event.which == 13) Add();
                });
                $('#submit_li_3').click(Alm);
                $('#form_li_3').keypress(function(event) {
                    if (event.which == 13) Alm();
                });
                $('#submit_li_41').click(GoSearchRef);
                $('#div_li_4').keypress(function(event) {
                    if($("#ReFID").is(":focus") == true && event.which == 13) GoSearchRef();
                });
                $('#submit_li_42').click(GoSearchName);
                $('#div_li_4').keypress(function(event) {
                    if($("#NamID").is(":focus") == true && event.which == 13) GoSearchName();
                });
            });
            
            function NH(){}
            
            function AutComple1()
            {
                var res = this.req.responseText.split("?"); 
                $('#NamVE').autocomplete({
                    source: res
                });
                $('#NamID').autocomplete({
                    source: res
                });
            }
            function AutComple2()
            {
                var res = this.req.responseText.split("?"); 
                $('#RefVE').autocomplete({
                    source: res
                });
                $('#ReFID').autocomplete({
                    source: res
                });
            }
            function GoSearchRef()
            {
                new net.CargadorContenidos("http://localhost/Inventario/sear.php?&nocache="+Math.random()+"&ref="+$('#ReFID').val(), ShowSearch, null, "GET", null, "application/x-www-form-urlencoded");
                $.scrollTo($('#'+$('#ReFID').val()));
            }
            
            
            function GoSearchName()
            {
                new net.CargadorContenidos("http://localhost/Inventario/sear.php?&nocache="+Math.random()+"&nam="+$('#NamID').val(), ShowSearch, null, "GET", null, "application/x-www-form-urlencoded");
                $.scrollTo('tr[name="'+$('#NamID').val()+'"]');
            }
            
            function Add()
            {
                if($('input[name=Referencia_Add]').val() === "")    return alert("Debes especificar una referencia");                
                if($('input[name=Nombre_Add]').val() === "")        return alert("Debes especificar un nombre");           
                if($('input[name=Precio_Add]').val() === "")        return alert("Debes especificar un precio correcto");                
                //if(isNaN($('input[name=Precio_Add]').val())) return alert("El precio debe ser numerico");
                return new net.CargadorContenidos("http://localhost/Inventario/add.php?add=1&nocache="+Math.random(), Comprobar, null, "POST", $('#form_li_2').serialize(), "application/x-www-form-urlencoded");
            }
            
            function Alm()
            {
                if($('input[name=Cantidad_New]').val() === "")  return alert("Debes especificar una cantidad correcta");
                if($('input[name=Precio_New]').val() === "")    return alert("Debes especificar un precio correcto");
                if($('input[name=Proveedor_New]').val() === "")    return alert("Debes especificar un proveedor correcto");
                
                return new net.CargadorContenidos("http://localhost/Inventario/Alm.php?Alm=1&nocache="+Math.random(), Comprobar, null, "POST", $('#form_li_3').serialize(), "application/x-www-form-urlencoded");
            }
            
            function Comprobar()
            {
                alert(this.req.responseText);
            }
            
            function OcultarCabecera(e)
            {
                var laid;
                $.each([1, 2, 3, 4, 5],function(i, n) {
                    $('#li_'+n).removeClass( "active" );
                    $('#div_li_'+n).css( "display", "none" );
                    laid = e.target.parentNode;  
                });
                $('#'+laid.id).addClass("active");  
                $('#div_'+laid.id).css( "display", "block" );
                if(laid.id == "li_3")  // Almacenar
                {
                    new net.CargadorContenidos("http://localhost/Inventario/reload.php?&nocache="+Math.random(), ShowAlmacenar, null, "GET", null, "application/x-www-form-urlencoded");
                }
                else if(laid.id == "li_4")  // Buscar
                {
                    new net.CargadorContenidos("http://localhost/Inventario/sear.php?&nocache="+Math.random(), ShowSearch, null, "GET", null, "application/x-www-form-urlencoded");
                }
                else if(laid.id == "li_5")  // Registros
                {
                    new net.CargadorContenidos("http://localhost/Inventario/reg.php?&nocache="+Math.random(), ShowReg, null, "GET", null, "application/x-www-form-urlencoded");
                }
                if(laid.id == "li_1" || laid.id == "li_4")
                {
                    new net.CargadorContenidos("http://localhost/Inventario/auto.php?a=1&nocache="+Math.random(), AutComple1, null, "GET", null, "application/x-www-form-urlencoded");
                    new net.CargadorContenidos("http://localhost/Inventario/auto.php?a=2&nocache="+Math.random(), AutComple2, null, "GET", null, "application/x-www-form-urlencoded");
                }
            }
            
            function ShowAlmacenar()
            {
                $('#NameAlm').empty();
                $('#NameAlm').append(this.req.responseText);
            }
            
            function ShowSearch()
            {
                $('#DatosSearch').empty();
                $('#DatosSearch').append(this.req.responseText);
            }
            
            function ShowReg()
            {
                $('#div_li_5').empty();
                $('#div_li_5').append(this.req.responseText);
                $(function () {
                    $("[data-toggle='tooltip']").tooltip()
                });
            }
            
            function Vend()
            {
                    
                CantidadVenta++;
                if($('input[name=Ref_Ve]').val() === "" && $('input[name=Nam_Ve]').val() === "")    return alert("Debes especificar una referencia o un nombre");      
                //if($('input[name=Precio_VE]').val() === "") return alert("Debes especificar un precio correcto");                    
                if($('input[name=Cantidad_VE]').val() === "") return alert("Debes especificar una cantidad correcta");      
                new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=1&a="+CantidadVenta+"&nocache="+Math.random(), AddVenta, null, "POST", $('#form_li_1').serialize(), "application/x-www-form-urlencoded");      
            }
            function AddVenta()
            {
                $('#TablaVenta').append(this.req.responseText);
                $("#submit_li_11").css("display", "block");
                new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=2&nocache="+Math.random(), AddTotal, null, "GET", null, "application/x-www-form-urlencoded"); 
            }
            function AddTotal()
            {
                //alert(this.req.responseText);
                $("#PrecioTotalDEVenta").empty();
                $('#PrecioTotalDEVenta').append(this.req.responseText);
            }
            function Eliminar(id)
            {
                new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=3&a="+id+"&nocache="+Math.random(), AddTotal, null, "GET", null, "application/x-www-form-urlencoded"); 
                $("#"+id).remove();
            }
            var dineroqueingresa;
            var tiempodeventa;
            function VenderObjetos()
            {
                dineroqueingresa = prompt("¿Cuanto dinero recibiste?");
                if(dineroqueingresa != null && $.isNumeric(dineroqueingresa) == true)
                {
                    new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=4&a="+dineroqueingresa+"&nocache="+Math.random(), VenderObjetos2, null, "GET", null, "application/x-www-form-urlencoded");
                }
            }
             function VenderObjetos2()
            {
                alert(this.req.responseText);
                VenderObjetos3();
            }
            function VenderObjetos3()
            {
                tiempodeventa = Math.round(new Date().getTime()/1000.0);
                $("#LaTablaVenta tbody tr").each(function () {
                    var campo1, campo2, campo3;
                    /*$(this).children("td").each(function (index2) {
                        switch (index2) {
                            case 0:
                                campo1 = $(this).text();
                                break;
                            case 1:
                                campo2 = $(this).text();
                                break;
                            case 2:
                                campo3 = $(this).text();
                                break;
                        } 
                        $(this).css("background-color", "#ECF8E0");
                    }) */
                    //alert($(this).attr("cost"));
                    new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=5&i="+dineroqueingresa+"&t="+tiempodeventa+"&r="+$(this).attr("refe")+"&n="+$(this).attr("name")+"&p="+$(this).attr("cost")+"&c="+$(this).attr("cuanto")+"&dt="+$(this).attr("dt")+"&du="+$(this).attr("du")+"&nocache="+Math.random(), VenderObjetos4, null, "GET", null, "application/x-www-form-urlencoded");
                });
            }
            function VenderObjetos4()
            {
                alert(this.req.responseText);
                Limpiar();
            }
            
            function Limpiar()
            {
                $('#TablaVenta').empty();
                $("#submit_li_11").css("display", "none");
                $("#PrecioTotalDEVenta").empty();
                CantidadVenta = -1;   
                new net.CargadorContenidos("http://localhost/Inventario/addvend.php?b=0&nocache="+Math.random(), NH, null, "GET", null, "application/x-www-form-urlencoded");           
            }
        </script>

        <div class="container" id="div_li_1" style="display:block; padding-top:70px;">
            <form class="form-inline" id="form_li_1">  
                <div class="input-group">
                    <input type="text" class="form-control" name="Ref_Ve" id="RefVE" placeholder="Código de referencia">
                    &nbsp;
                    <input type="text" class="form-control" name="Nam_Ve" id="NamVE" placeholder="Nombre del producto">
                </div>
                &nbsp;&nbsp;
                <div class="form-group"><input type="number" class="form-control" name="Precio_VE" id="PreVE" placeholder="Precio por unidad"></div>&nbsp;&nbsp;
                <div class="form-group"><input type="number" class="form-control" name="Cantidad_VE" id="CanVE" placeholder="Cantidad Vendida"></div>&nbsp;&nbsp;
                <div class="form-group">
                    <input id="submit_li_1" class="btn btn-primary" value="Agregar"></input>
                    &nbsp;&nbsp;
                    <input id="reset_li_1" class="btn btn-warning" value="Limpiar Campos" type="reset"></input>
                </div>
            </form>
            <br><br>
            <div id="LaVenta">
                <table class="table table-striped table-bordered" id="LaTablaVenta">
                    <thead>
                        <tr>
                            <th>Referencia - Nombre</th>
                            <th>Precio Total</th>
                            <th>Precio Unidad</th>
                            <th>Descuento Total</th>
                            <th>Descuento Unitario</th>
                            <th><button onclick='Limpiar()' type='button' class='close' aria-label='Close'><span aria-hidden='true' >&times;</span></button></th>
                        </tr>    
                    </thead>
                    <tbody id="TablaVenta">
                    </tbody>
                    <tfoot><tr><th>Precio total de venta:</th><td id="PrecioTotalDEVenta"></td><!--<th>Descuento total de venta:</th><td id="DescTotal"></td>--></tr></tfoot>
                </table>
                <input id="submit_li_11" class="btn btn-primary" style="display:none;" value="Vender" onclick="VenderObjetos()"></input>
            </div>
        </div>
        <div class="container" id="div_li_5" style="display:none; padding-top:70px;"></div>
    
    <?php 
        include "almacenar.html";
        include "agregar.html";
        include "search.html";
    ?>
    </body>
</html>