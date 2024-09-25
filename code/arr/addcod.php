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
        		$('#nit_cc_cod').on('blur', function()
        		{
            		$('#result-nit_cc_cod').html('<img src="../../img/loader.gif" />').fadeOut(1000);
             		var nit_cc_cod = $(this).val();   
            		var dataString = 'nit_cc_cod='+nit_cc_cod;

            		$.ajax(
            		{
		                type: "POST",
		                url: "chkcod.php",
		                data: dataString,
		                success: function(data)
		                {
		                	$('#result-nit_cc_cod').fadeIn(1000).html(data);
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
			<h1><b><i class="fa-solid fa-user-plus"></i> REGISTRO DE CODEUDORES</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addcod1.php' enctype="multipart/form-data" method="POST">
				<div class="row">
					<div class="col">
						<div id="result-nit_cc_cod"></div>
					</div>  
				</div>
				<div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-3">
                        	<label for="nit_cc_cod">* CC:</label>
                        	<input type='number' name='nit_cc_cod' class='form-control' id="nit_cc_cod" required />
                   		</div>
                   		<div class="col-12 col-sm-6">
	                        <label for="nom_ape_cod">* NOMBRES APELLIDOS y/o RAZÓN SOCIAL:</label>
	                        <input type='text' name='nom_ape_cod' id="nom_ape_cod" class='form-control' required style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-3">
	                        <label for="dir_cod">* DIRECCIÓN:</label>
	                        <input type='text' name='dir_cod' id="dir_cod" class='form-control' style="text-transform:uppercase;" required/>
	                    </div>
               		</div>
                </div>

                <div class="form-group">
	                <div class="row">
	                	<div class="col-12 col-sm-3">
	                        <label for="mun_cod">* MUNICIPIO:</label>
	                        <select class="form-control" name="mun_cod" required/>
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
	                    <div class="col-12 col-sm-2">
	                        <label for="tel1_cod">* CEL:</label>
	                        <input type='text' name='tel1_cod' class='form-control' style="text-transform:uppercase;" required/>
	                    </div>
	                    <div class="col-12 col-sm-2">
	                        <label for="tel2_cod">TEL:</label>
	                        <input type='text' name='tel2_cod' class='form-control' style="text-transform:uppercase;" />
	                    </div>
	                    <div class="col-12 col-sm-5">
	                        <label for="email_cod">EMAIL:</label>
	                        <input type='email' name='email_cod' class='form-control' style="text-transform:lowercase;" />
	                    </div>
	                </div>
            	</div>

            	<div class="form-group">
	                <div class="row">
	                    <div class="col-12 col-sm-7">
	                        <label for="nit_cc_arr">* ARRENDATARIO:</label>
	                        <select name='nit_cc_arr' class='form-control' required id="nit_cc_arr"/>
	          					<option value=''></option>
	        						<?php
	          							header('Content-Type: text/html;charset=utf-8');
	          							$consulta='SELECT * FROM arrendatarios';
	          							$res = mysqli_query($mysqli,$consulta);
	          							$num_reg = mysqli_num_rows($res);
	          							while($row = $res->fetch_array())
	          							{
	        							?>
	      						<option value='<?php echo $row['nit_cc_arr']; ?>'>
	        							<?php echo utf8_encode($row['nom_ape_arr']. ' - '.$row['nit_cc_arr']); ?>
	      						</option>
	        							<?php
	          							}
	        							?>    
	        				</select>
	                    </div>
	                </div>
            	</div>
           		
            	<hr style="border: 4px solid #24E924; border-radius: 5px;">

            	<div class="form-group">
                	<div class="row">
	                    <div class="col-12 col-sm-12">
	                        <label for="obs_cod">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
	                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_cod" style="text-transform:uppercase;" /></textarea>
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