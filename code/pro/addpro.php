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
			fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
			}

			legend {
				font-weight: bold;
				font-size: 0.9em;
				color: #4a4a4a;
				padding: 0 10px;
			}

			.form-group {
				margin-bottom: 1rem;
			}

			/* Efecto de enfoque para el fieldset */
			fieldset:focus-within {
				background-color: #e6f7ff; /* Azul muy claro */
				box-shadow: 0 0 10px rgba(0, 123, 255, 0.3); /* Sombreado azul claro */
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
		<script>
			$(document).ready(function() {
				// Inicialmente deshabilitar los campos correspondientes
				$('select[name="entidad_ban_pro"], select[name="tipo_cta_pro"], input[name="num_cta_pro"]').prop('disabled', true);
				
				// Escuchar cambios en el campo forma_pago_pro
				$('select[name="forma_pago_pro"]').change(function() {
					var pagoPropietario = $(this).val();

					if (pagoPropietario === 'Transferencia') {
						$('select[name="entidad_ban_pro"], select[name="tipo_cta_pro"], input[name="num_cta_pro"]').prop('disabled', false);
					} else {
						$('select[name="entidad_ban_pro"], select[name="tipo_cta_pro"]').prop('disabled', true).val('');
						$('input[name="num_cta_pro"]').prop('disabled', true).val('');
					}
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
			<h1><b><i class="fa-solid fa-address-card"></i> REGISTRO DE PROPIETARIOS</b></h1>
			<p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

			<form id="registroForm" action='addpro1.php' enctype="multipart/form-data" method="POST">
				<div class="row">
					<div class="col">
						<div id="result-nit_cc_pro"></div>
					</div>  
				</div>

				<div class="form-group">
                	<fieldset>
                    	<legend>DATOS PERSONALES</legend>
						<div class="row">
							<div class="col-12 col-sm-3">
								<label for="nit_cc_pro">* NIT | CC:</label>
								<input type='number' name='nit_cc_pro' class='form-control' id="nit_cc_pro" required />
							</div>
							<div class="col-12 col-sm-6">
								<label for="nom_ape_pro">* NOMBRES APELLIDOS y/o RAZÓN SOCIAL:</label>
								<input type='text' name='nom_ape_pro' id="nom_ape_pro" class='form-control' required style="text-transform:uppercase;" />
							</div>
							<div class="col-12 col-sm-3">
								<label for="dir_pro">* DIRECCIÓN:</label>
								<input type='text' name='dir_pro' id="dir_pro" class='form-control' style="text-transform:uppercase;" />
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-sm-3">
								<label for="mun_pro">* MUNICIPIO:</label>
								<select class="form-control" name="mun_pro" required/>
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
									<option value="OTRO">OTRO</option>
								</select>
							</div>
							<div class="col-12 col-sm-2">
								<label for="tel1_pro">CEL:</label>
								<input type='text' name='tel1_pro' class='form-control' style="text-transform:uppercase;" />
							</div>
							<div class="col-12 col-sm-2">
								<label for="tel2_pro">TEL:</label>
								<input type='text' name='tel2_pro' class='form-control' style="text-transform:uppercase;" />
							</div>
							<div class="col-12 col-sm-5">
								<label for="email_pro">EMAIL:</label>
								<input type='email' name='email_pro' class='form-control' style="text-transform:lowercase;" />
							</div>
						</div>
					</fieldset>
				</div>

				<div class="form-group">
                	<fieldset>
                    	<legend>INFORMACIÓN CUENTA BANCARIA</legend>
						<div class="row">
							<div class="col-12 col-sm-3">
								<label for="forma_pago_pro">* FORMA DE PAGO:</label>
								<select class="form-control" name="forma_pago_pro" required>
									<option value=""></option>
									<option value="Transferencia">Transferencia</option>
									<option value="Efectivo">Efectivo</option>
								</select>
							</div>
							<div class="col-12 col-sm-3">
								<label for="entidad_ban_pro">ENTIDAD BANCARIA:</label>
								<select class="form-control" name="entidad_ban_pro" >
									<option value=""></option>
									<option value="Banco Agrario de Colombia">Banco Agrario de Colombia</option>
									<option value="Banco AV Villas">Banco AV Villas</option>
									<option value="Banco BBVA">Banco BBVA</option>
									<option value="Banco BCSC">Banco BCSC</option>
									<option value="Banco Citibank">Banco Citibank</option>
									<option value="Banco Coopcentral">Banco Coopcentral</option>
									<option value="Banco Davivienda">Banco Davivienda</option>
									<option value="Banco de Bogotá">Banco de Bogotá</option>
									<option value="Banco de Occidente">Banco de Occidente</option>
									<option value="Banco Falabella">Banco Falabella</option>
									<option value="Banco Finandina">Banco Finandina</option>
									<option value="Banco GNB Sudameris">Banco GNB Sudameris</option>
									<option value="Banco Itaú Corpbanca Colombia S.A.">Banco Itaú Corpbanca Colombia S.A.</option>
									<option value="Banco Pichincha">Banco Pichincha</option>
									<option value="Banco Popular">Banco Popular</option>
									<option value="Bancolombia">Bancolombia</option>
									<option value="Bancoomeva">Bancoomeva</option>
									<option value="Nequi">Nequi</option>
									<option value="Daviplata">Daviplata</option>
									<option value="Transfiya">Transfiya</option>
									<option value="N/A">N/A</option>
								</select>
							</div>
							<div class="col-12 col-sm-3">
								<label for="tipo_cta_pro">TIPO DE CUENTA:</label>
								<select class="form-control" name="tipo_cta_pro">
									<option value=""></option>
									<option value="Ahorros">Ahorros</option>
									<option value="Corriente">Corriente</option>
									<option value="Otro">Otro</option>
								</select>
							</div>
							<div class="col-12 col-sm-3">
								<label for="num_cta_pro">CUENTA No.</label>
								<input type='number' name='num_cta_pro' class='form-control' />
							</div>
						</div>
					</fieldset>
				</div>

				<div class="form-group">
                	<fieldset>
                    	<legend>RESPONSABILIDADES, CALIDADES y ATRIBUTOS</legend>
						<div class="row">
							<div class="col-12 col-sm-3">
								<label for="tipo_reg_iva_pro">* TIPO REGIMEN:</label>
								<select class="form-control" name="tipo_reg_iva_pro" id="tipo_reg_iva_pro" required>
									<option value=""></option>   
									<option value="1">No responsable de IVA</option>
									<option value="2">Responsable de IVA</option>
								</select>
							</div>
							<div class="col-12 col-sm-4">
								<label class="containerCheck">No responsable de IVA:</label>
								<input type="hidden" name="no_responsable_iva_pro" value="0">
								<input type="checkbox" name="no_responsable_iva_pro" value="1" disabled>
								<br>
								<label class="containerCheck">Régimen simple de tributación - SIM:</label>
								<input type="hidden" name="reg_simple_trib_pro" value="0">
								<input type="checkbox" name="reg_simple_trib_pro" value="1" disabled>
								<br>
								<label class="containerCheck">Impto. sobre las ventas - IVA:</label>
								<input type="hidden" name="impto_ventas_iva_pro" value="0">
								<input type="checkbox" name="impto_ventas_iva_pro" value="1" disabled>
								<br>
							</div>
							<div class="col-12 col-sm-4">
								<label class="containerCheck">Retención en la fuente a título de renta:</label>
								<input type="hidden" name="rete_fte_pro" value="0">
								<input type="checkbox" name="rete_fte_pro" value="1" disabled>
								<br>
								<label class="containerCheck">Retención en la fuente en el impuesto:</label>
								<input type="hidden" name="rete_iva_pro" value="0">
								<input type="checkbox" name="rete_iva_pro" value="1" disabled>
								<br>
								<label class="containerCheck">Retención de Industria y Comercio:</label>
								<input type="hidden" name="rete_ica_pro" value="0">
								<input type="checkbox" name="rete_ica_pro" value="1" disabled>
								<br>
							</div>
						</div>
					</fieldset>
				</div>

            	<div class="form-group">
                	<fieldset>
                    	<legend>OBSERVACIONES y/o COMENTARIOS ADICIONALES:</legend>
						<div class="row">
							<div class="col-12 col-sm-12">
								<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_pro" style="text-transform:uppercase;" /></textarea>
							</div>
                		</div>
					</fieldset>
            	</div>

            	<div class="form-group">
                	<fieldset>
                    	<legend><i class="fas fa-file-pdf"></i> ADJUNTAR DOCUMENTOS DEL INMUEBLE</legend>
						<div class="row">
							<div class="col-12">
								<input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf">
								<p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
							</div>
                		</div>
					</fieldset>
            	</div>

				<!-- Botones para enviar o resetear -->
				<button type="submit" class="btn btn-outline-warning">
                <span class="spinner-border spinner-border-sm"></span>
                INGRESAR REGISTRO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'>
                <img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>

    <!-- Script para manejar el envío del formulario -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Inicializamos el comportamiento del formulario
            $('#registroForm').on('submit', function() {
                // Aseguramos que los checkboxes deshabilitados seleccionados sean enviados con valor 1
                $('input[type=checkbox]:disabled').each(function() {
                    if (this.checked) {
                        $(this).prop('disabled', false);
                    }
                });

                // Verificamos todos los checkboxes y establecemos su valor a 0 si no están seleccionados
                $('input[type=checkbox]').each(function() {
                    if (!this.checked) {
                        $(this).after('<input type="hidden" name="' + this.name + '" value="0">');
                    }
                });
            });

            // Maneja la lógica de los checkboxes según el valor del select
            $('#tipo_reg_iva_pro').change(function() {
                var tipoRegimen = $(this).val();

                // Reiniciamos los checkboxes a su estado inicial
                $('input[type=checkbox]').prop('checked', false).prop('disabled', true);

                if (tipoRegimen == "1") {
                    $('input[name="no_responsable_iva_pro"]').prop('checked', true).prop('disabled', true);
                } else if (tipoRegimen == "2") {
                    $('input[name="impto_ventas_iva_pro"]').prop('checked', true).prop('disabled', true);
                    $('input[name="reg_simple_trib_pro"]').prop('disabled', false);
                    $('input[name="rete_fte_pro"]').prop('disabled', false);
                    $('input[name="rete_iva_pro"]').prop('disabled', false);
                    $('input[name="rete_ica_pro"]').prop('disabled', false);
                }
            });

            // Activamos la lógica de habilitación de checkboxes al cargar la página
            $('#tipo_reg_iva_pro').trigger('change');
        });
    </script>
</body>
</html>