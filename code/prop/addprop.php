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
        		$('#nit_cc_pro').on('blur', function()
        		{
            		$('#result-nit_cc_pro').html('<img src="../../img/loader.gif" />').fadeOut(1000);
             		var nit_cc_pro = $(this).val();   
            		var dataString = 'nit_cc_pro='+nit_cc_pro;

            		$.ajax(
            		{
		                type: "POST",
		                url: "chkpro.php",
		                data: dataString,
		                success: function(data)
		                {
		                	$('#result-nit_cc_pro').fadeIn(1000).html(data);
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
			<h1><b><i class="fa-solid fa-building-user"></i> REGISTRO DE PROPIEDADES Y PROPIETARIOS</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form action='addprop1.php' method="POST">
				<div class="form-group">
                	<div class="row">
                    	<div class="col-12 col-sm-6">
	                        <label for="mat_inm">* MATRICULA INMOBILIARIA:</label>
	                        <select name='mat_inm' class='form-control' required id="mat_inm"/>
	          					<option value=''></option>
	        						<?php
	          							header('Content-Type: text/html;charset=utf-8');
	          							$consulta='SELECT * FROM inmuebles';
	          							$res = mysqli_query($mysqli,$consulta);
	          							$num_reg = mysqli_num_rows($res);
	          							while($row = $res->fetch_array())
	          							{
	        							?>
	      						<option value='<?php echo $row['mat_inm']; ?>'>
	        							<?php echo utf8_encode($row['nom_inm'].' - '.$row['mat_inm']); ?>
	      						</option>
	        							<?php
	          							}
	        							?>    
	        				</select>
	                    </div>
	                    <div class="col-12 col-sm-6">
	                        <label for="nit_cc_pro">* CC | NIT PROPIETARIO:</label>
	                        <select name='nit_cc_pro' class='form-control' required id="nit_cc_pro"/>
	          					<option value=''></option>
	        						<?php
	          							header('Content-Type: text/html;charset=utf-8');
	          							$consulta='SELECT * FROM propietarios';
	          							$res = mysqli_query($mysqli,$consulta);
	          							$num_reg = mysqli_num_rows($res);
	          							while($row = $res->fetch_array())
	          							{
	        							?>
	      						<option value='<?php echo $row['nit_cc_pro']; ?>'>
	        							<?php echo utf8_encode($row['nom_ape_pro'].' - '.$row['nit_cc_pro']); ?>
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
	                        <label for="obs_prop">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
	                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_prop" style="text-transform:uppercase;" /></textarea>
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