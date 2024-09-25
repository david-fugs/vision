<?php
session_start();

if(!isset($_SESSION['id_usu'])){
    header("Location: ../../index.php");
}

$nombre         = $_SESSION['nombre'];
$tipo_usu       = $_SESSION['tipo_usu'];
$nit_cc_ase     = $_SESSION['id_usu']; // Asignar el valor del ID de usuario a nit_cc_ase
$nombre_usu     = $_SESSION['nombre']; // Asignar el nombre de usuario a nombre_usu

// Capturar los valores precargados desde la URL
$direccion_inm_exh = isset($_GET['direccion_inm_exh']) ? $_GET['direccion_inm_exh'] : '';
$nom_ape_inte_exh = isset($_GET['nom_ape_inte_exh']) ? $_GET['nom_ape_inte_exh'] : '';
$raz_soc_exh = isset($_GET['raz_soc_exh']) ? $_GET['raz_soc_exh'] : 'N/A';
$nit_cc_exh = isset($_GET['nit_cc_exh']) ? $_GET['nit_cc_exh'] : '';
$cel_inte_exh = isset($_GET['cel_inte_exh']) ? $_GET['cel_inte_exh'] : '';
$tel_inte_exh = isset($_GET['tel_inte_exh']) ? $_GET['tel_inte_exh'] : '';
$email_inte_exh = isset($_GET['email_inte_exh']) ? $_GET['email_inte_exh'] : '';

include("../../conexion.php");
require_once("../../zebra.php");
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");

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
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
        .signature-pad {
            border: 1px solid #000000;
            width: 100%;
            height: 200px;
        }
        .disabled-canvas {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><img src='../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-store"></i> PREREGISTRO EXHIBICION DE INMUEBLE COMERCIAL</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

        <form action='addexhpre1.php' enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="cod_fr_exh">* COD F.R.</label>
                        <input type='number' name='cod_fr_exh' class='form-control' id="cod_fr_exh" required />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="fec_exh">FECHA:</label>
                        <input type='datetime' name='fec_exh' id="fec_exh" class='form-control' value="<?php echo date("Y-m-d H:i:s"); ?>" readonly />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="direccion_inm_exh">* DIRECCIÓN INMUEBLE:</label>
                        <input type='text' name='direccion_inm_exh' id="direccion_inm_exh" class='form-control' required style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="nom_ape_inte_exh">NOMBRE Y APELLIDOS INTERESAD@:</label>
                        <input type='text' name='nom_ape_inte_exh' id="nom_ape_inte_exh" class='form-control' value="<?php echo htmlspecialchars($nom_ape_inte_exh); ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-5">
                        <label for="raz_soc_exh">RAZON SOCIAL:</label>
                        <input type='text' name='raz_soc_exh' id="raz_soc_exh" class='form-control' value="<?php echo htmlspecialchars($raz_soc_exh); ?>" readonly />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="nit_cc_exh">NIT y/o CC No.</label>
                        <input type='number' name='nit_cc_exh' id="nit_cc_exh" class='form-control' value="<?php echo htmlspecialchars($nit_cc_exh); ?>" readonly />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="cel_inte_exh">CEL:</label>
                        <input type='text' name='cel_inte_exh' id="cel_inte_exh" class='form-control' value="<?php echo htmlspecialchars($cel_inte_exh); ?>" readonly />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tel_inte_exh">TEL:</label>
                        <input type='text' name='tel_inte_exh' id="tel_inte_exh" class='form-control' value="<?php echo htmlspecialchars($tel_inte_exh); ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-5">
                        <label for="email_inte_exh">EMAIL:</label>
                        <input type='text' name='email_inte_exh' id="email_inte_exh" class='form-control' value="<?php echo htmlspecialchars($email_inte_exh); ?>" readonly />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tipo_inm_exh">* TIPO INMUEBLE:</label>
                        <select class="form-control" name="tipo_inm_exh" id="tipo_inm_exh" required>
                            <option value=""></option>   
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr style="border: 2px solid #F59212; border-radius: 5px;">
            <p><i><b><font size=3 color=#F59212>Inmuebles comerciales:</i></b></font></p>    
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="area_max_exh">AREA MAX:</label>
                        <input type='number' name='area_max_exh' id="area_max_exh" class='form-control' value=0 disabled/>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="area_min_exh">AREA MIN:</label>
                        <input type='number' name='area_min_exh' id="area_min_exh" class='form-control' value=0 disabled/>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tipo_sis_elec_exh">SIST. ELECTRICO:</label>
                        <select class="form-control" name="tipo_sis_elec_exh" id="tipo_sis_elec_exh" disabled>
                            <option value=""></option>   
                            <option value="Monofásico">Monofásico</option>
                            <option value="Bifásico">Bifásico</option>
                            <option value="Trifásico">Trifásico</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="kVA_exh">kVA:</label>
                        <input type='number' name='kVA_exh' id="kVA_exh" class='form-control' value=0 disabled/>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="presupuesto_max_exh">PRESUP. MAX:</label>
                        <input type='number' name='presupuesto_max_exh' id="presupuesto_max_exh" class='form-control' value=0 disabled/>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="presupuesto_min_exh">PRESUP. MIN:</label>
                        <input type='number' name='presupuesto_min_exh' id="presupuesto_min_exh" class='form-control' value=0 disabled/>
                    </div>
                </div>
            </div>
            <hr style="border: 2px solid #F59212; border-radius: 5px;">

            <hr style="border: 2px solid #24E924; border-radius: 5px;">
            <p><i><b><font size=3 color=#24E924>Inmuebles residenciales:</i></b></font></p>        
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="valor_ubicacion_exh">UBICACION:</label>
                        <input type='number' min=0 max=10 name='valor_ubicacion_exh' id="valor_ubicacion_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_fachada_exh">FACHADAS:</label>
                        <input type='number' min=0 max=10 name='valor_fachada_exh' id="valor_fachada_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_area_exterior_exh">AREA EXTERIOR:</label>
                        <input type='number' min=0 max=10 name='valor_area_exterior_exh' id="valor_area_exterior_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_iluminacion_exh">ILUMINACION:</label>
                        <input type='number' min=0 max=10 name='valor_iluminacion_exh' id="valor_iluminacion_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_altura_exh">ALTURA:</label>
                        <input type='number' min=0 max=10 name='valor_altura_exh' id="valor_altura_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_pisos_exh">PISOS:</label>
                        <input type='number' min=0 max=10 name='valor_pisos_exh' id="valor_pisos_exh" class='form-control' disabled />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="valor_paredes_exh">PAREDES:</label>
                        <input type='number' min=0 max=10 name='valor_paredes_exh' id="valor_paredes_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_carpinteria_exh">CARPINTERIA:</label>
                        <input type='number' min=0 max=10 name='valor_carpinteria_exh' id="valor_carpinteria_exh" class='form-control' disabled />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_banhos_exh">BAÑOS:</label>
                        <input type='number' min=0 max=10 name='valor_banhos_exh' id="valor_banhos_exh" class='form-control' disabled />
                    </div>
                </div>
            </div>
            
            <hr style="border: 2px solid #24E924; border-radius: 5px;">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="obs1_exh">¿QUE LE FALTARIA AL INMUEBLE?</label>
                        <textarea class="form-control" id="obs1_exh" rows="3" name="obs1_exh" style="text-transform:uppercase;" disabled></textarea>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="obs2_exh">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                        <textarea class="form-control" id="obs2_exh" rows="3" name="obs2_exh" style="text-transform:uppercase;" disabled></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="nombre_usu">* ASESOR COMERCIAL:</label>
                        <input type="text" name="nombre_usu" id="nombre_usu" class="form-control" readonly value="<?php echo htmlspecialchars($nombre_usu, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="nit_cc_ase" id="nit_cc_ase" value="<?php echo htmlspecialchars($nit_cc_ase, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="signature">FIRMAR VISITA:</label>
                        <canvas id="signature-pad" class="signature-pad disabled-canvas"></canvas>
                        <button id="clear" class="btn btn-outline-danger" type="button" disabled>BORRAR FIRMA</button>
                        <input type="hidden" id="signature" name="signature">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="archivo"><strong><i class="fa-regular fa-image"></i> ADJUNTAR FOTOGRAFIA DE LA VISITA</strong></label>
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="image/jpeg,image/gif,image/png,image/jpg,image/bmp,image/webp,application/pdf,image/x-eps">
                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;">Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
                    </div>
                </div>
            </div>

            <input type="hidden" id="inicio_tiempo" name="inicio_tiempo" value="<?php echo date("Y-m-d H:i:s"); ?>" />

            <button type="submit" class="btn btn-outline-warning">
                <span class="spinner-border spinner-border-sm"></span>
                INGRESAR REGISTRO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            function toggleFields() {
                var tipoInmuebleValue = $('#tipo_inm_exh').val();

                // Deshabilitar todos los campos al inicio
                $('#area_max_exh, #area_min_exh, #tipo_sis_elec_exh, #kVA_exh, #presupuesto_max_exh, #presupuesto_min_exh').prop('disabled', true);
                $('#valor_ubicacion_exh, #valor_fachada_exh, #valor_area_exterior_exh, #valor_iluminacion_exh, #valor_altura_exh, #valor_pisos_exh, #valor_paredes_exh, #valor_carpinteria_exh, #valor_banhos_exh').prop('disabled', true).val(0);
                $('#obs1_exh, #obs2_exh').prop('disabled', true);
                $('#signature-pad').addClass('disabled-canvas');
                $('#clear').prop('disabled', true);

                if (tipoInmuebleValue == 'Comercial') {
                    $('#area_max_exh, #area_min_exh, #tipo_sis_elec_exh, #kVA_exh, #presupuesto_max_exh, #presupuesto_min_exh').prop('disabled', false);
                    $('#obs1_exh, #obs2_exh').prop('disabled', false);
                    $('#signature-pad').removeClass('disabled-canvas');
                    $('#clear').prop('disabled', false);
                } else if (tipoInmuebleValue == 'Residencial') {
                    $('#valor_ubicacion_exh, #valor_fachada_exh, #valor_area_exterior_exh, #valor_iluminacion_exh, #valor_altura_exh, #valor_pisos_exh, #valor_paredes_exh, #valor_carpinteria_exh, #valor_banhos_exh').prop('disabled', false);
                    $('#obs1_exh, #obs2_exh').prop('disabled', false);
                    $('#signature-pad').removeClass('disabled-canvas');
                    $('#clear').prop('disabled', false);
                }
            }

            // Inicializar la lógica al cargar la página
            toggleFields();

            // Cambios en los select para actualizar la lógica
            $('#tipo_inm_exh').change(function() {
                toggleFields();
            });

            // Inicializar Signature Pad
            var canvas = document.getElementById('signature-pad');
            var signaturePad = new SignaturePad(canvas);
            var clearButton = document.getElementById('clear');
            var signatureInput = document.getElementById('signature');

            clearButton.addEventListener('click', function () {
                signaturePad.clear();
            });

            $('form').on('submit', function(e) {
                if ($('#tipo_inm_exh').val() !== '' && signaturePad.isEmpty()) {
                    alert("Por favor, firme antes de enviar el formulario.");
                    e.preventDefault();
                } else {
                    var dataUrl = signaturePad.toDataURL('image/png');
                    signatureInput.value = dataUrl;
                }
            });
        });
    </script>
</body>
</html>
