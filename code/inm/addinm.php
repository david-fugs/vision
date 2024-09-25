<?php
    
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];
    header("Content-Type: text/html;charset=utf-8");
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>VISION | SOFT</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script type="text/javascript" src="../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/popper.min.js"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <link href="../../fontawesome/css/all.css" rel="stylesheet">
		<script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
    	</style>
    	<!--SCRIPT PARA VALIDAR SI EL REGISTRO YA ESTÁ EN LA BD-->
    	<script type="text/javascript">
    		$(document).ready(function()
    		{  
        		$('#mat_inm').on('blur', function()
        		{
            		$('#result-mat_inm').html('<img src="../../img/loader.gif" />').fadeOut(1000);
             		var mat_inm = $(this).val();   
            		var dataString = 'mat_inm='+mat_inm;

            		$.ajax(
            		{
		                type: "POST",
		                url: "chkinm.php",
		                data: dataString,
		                success: function(data)
		                {
		                	$('#result-mat_inm').fadeIn(1000).html(data);
            			}
            		});
        		});
        	});    
  		</script>
    <head>
    <body>
  
		<center>
	    	<img src='../../img/logo.png' width="300" height="212" class="responsive">
		</center>
		<br />
<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

?>

		<div class="container">
			<h1><b><i class="fa-solid fa-city"></i> REGISTRO DE INMUEBLES</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addinm1.php' enctype="multipart/form-data" method="POST">
				<div class="row">
					<div class="col">
						<div id="result-mat_inm"></div>
					</div>  
				</div>
				<div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-3">
                        	<label for="mat_inm">* No. MATRÍCULA:</label>
                        	<input type='text' name='mat_inm' class='form-control' id="mat_inm" required />
                   		</div>
                   		<div class="col-12 col-sm-6">
	                        <label for="nom_inm">* INMUEBLE:</label>
	                        <input type='text' name='nom_inm' id="nom_inm" class='form-control' required style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-3">
	                        <label for="mun_inm">* MUNICIPIO:</label>
	                        <select class="form-control" name="mun_inm" required/>
	                            <option value=""></option>   
	                            <option value="PEREIRA">PEREIRA</option>
	                            <option value="DOSQUEBRADAS">DOSQUEBRADAS</option>
	                            <option value="SANTA ROSA DE CABAL">SANTA ROSA DE CABAL</option>
	                            <option value="APIA">APIA</option>
	                            <option value="BALBOA">BALBOA</option>
	                            <option value="BELEN DE UMBRIA">BELEN DE UMBRIA</option>
	                            <option value="GUATICA">GUATICA</option>
	                            <option value="LA CELIA">LA CELIA</option>
	                            <option value="LA VIRGINIA">LA VIRGINIA</option>
	                            <option value="MARSELLA">MARSELLA</option>
	                            <option value="MISTRATO">MISTRATO</option>
	                            <option value="PUEBLO RICO">PUEBLO RICO</option>
	                            <option value="QUINCHIA">QUINCHIA</option>
	                            <option value="SANTUARIO">SANTUARIO</option>
	                        </select>
	                    </div>
               		</div>
                </div>

                <div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-6">
	                        <label for="dir_inm">* DIRECCIÓN:</label>
	                        <input type='text' name='dir_inm' id="dir_inm" class='form-control' required style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-2">
	                        <label for="tel_inm">TEL:</label>
	                        <input type='text' name='tel_inm' class='form-control' style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-2">
	                        <label for="est_inm">ESTRATO:</label>
	                        <select class="form-control" name="est_inm"/>
	                            <option value=""></option>   
	                            <option value=1 selected>1</option>
	                            <option value=2 >2</option>
	                            <option value=3 >3</option>
	                            <option value=4 >4</option>
	                            <option value=5 >5</option>
	                            <option value=6 >6</option>
	                            <option value=7 >7</option>
	                            <option value=8 >8</option>
	                            <option value=9 >0</option>
	                            <option value=10 >10</option>
	                        </select>
	                    </div>
	                    <div class="col-12 col-sm-2">
	                        <label for="zona_inm">ZONA:</label>
	                        <select class="form-control" name="zona_inm" required/>
	                            <option value=""></option>   
	                            <option value="URBANA">URBANA</option>
	                            <option value="RURAL">RURAL</option>
	                        </select>
	                    </div>
	                </div>
            	</div>
           		
            	<hr style="border: 4px solid #24E924; border-radius: 5px;">

            	<div class="form-group">
                	<div class="row">
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_inm">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
	                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_inm" style="text-transform:uppercase;" /></textarea>
	                    </div>
                	</div>
            	</div>

            	<div class="form-group">
                	<div class="row">
	                    <div class="col-12">
	                        <label for="archivo"><strong><i class="fas fa-file-pdf"></i> ADJUNTAR DOCUMENTOS DEL INMUEBLE</strong></label>
	                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf">
	                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
	                    </div>
                	</div>
            	</div>

	            <hr style="border: 4px solid #24E924; border-radius: 5px;">
	      
				<button type="submit" class="btn btn-outline-warning">
					<span class="spinner-border spinner-border-sm"></span>
					INGRESAR REGISTRO
				</button>
				<button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
				</button>
			</form>
		</div>
	</body>
	<script src = "../../js/jquery-3.1.1.js"></script>
</html>