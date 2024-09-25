<?php
include("../../conexion.php");

session_start();

if(!isset($_SESSION['id_usu'])){
    header("Location: ../../index.php");
}
	$con_fia 			= $_POST['con_fia'];
	$fec_fia 			= $_POST['fec_fia'];
	$can_arr_fia 		= $_POST['can_arr_fia'];
	$cuo_adm_fia 		= $_POST['cuo_adm_fia'];
	$iva_arr_fia 		= $_POST['iva_arr_fia'];
	$otro_concepto_fia 	= $_POST['otro_concepto_fia'];
	$nom_concepto_fia 	= $_POST['nom_concepto_fia'];
	$nit_cc_arr 		= $_POST['nit_cc_arr'];
	$mat_inm 			= $_POST['mat_inm'];
	$obs_fia 			= $_POST['obs_fia'];
	$estado_fia         =   1;
    $fecha_alta_fia     =   date('Y-m-d h:i:s');
    $id_usu_alta_fia    =   $_SESSION['id_usu'];
    $fecha_edit_fia     =   ('0000-00-00 00:00:00');
    $id_usu             =   $_SESSION['id_usu'];

// Insertar en la tabla FIANZAS
$query_fianzas = "INSERT INTO fianzas (con_fia, fec_fia, can_arr_fia, cuo_adm_fia, iva_arr_fia, otro_concepto_fia, nom_concepto_fia, nit_cc_arr, mat_inm, obs_fia, estado_fia, fecha_alta_fia, id_usu_alta_fia, fecha_edit_fia, id_usu) 
                  VALUES ('$con_fia', '$fec_fia', '$can_arr_fia', '$cuo_adm_fia', '$iva_arr_fia', '$otro_concepto_fia', '$nom_concepto_fia', '$nit_cc_arr', '$mat_inm', '$obs_fia','$estado_fia', '$fecha_alta_fia', '$id_usu_alta_fia', '$fecha_edit_fia', '$id_usu')";
mysqli_query($mysqli, $query_fianzas);


	$fecha_alta_fia_cod     =   date('Y-m-d h:i:s');
    $id_usu_alta_fia_cod    =   $_SESSION['id_usu'];
    $fecha_edit_fia_cod     	=   ('0000-00-00 00:00:00');
    $id_usu             	=   $_SESSION['id_usu'];

// Insertar en la tabla FIANZA_CODEUDOR
if (!empty($_POST['codeudores'])) {
    foreach ($_POST['codeudores'] as $nit_cc_cod) {
        $query_fianza_codeudor = "INSERT INTO fianza_codeudor (con_fia, nit_cc_cod, fecha_alta_fia_cod, id_usu_alta_fia_cod, fecha_edit_fia_cod, id_usu) 
                                  VALUES ('$con_fia', '$nit_cc_cod', '$fecha_alta_fia_cod', '$id_usu_alta_fia_cod', '$fecha_edit_fia_cod', '$id_usu')";
        mysqli_query($mysqli, $query_fianza_codeudor);
    }
}

echo "
        <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta charset='utf-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                    <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                    <link href='../../fontawesome/css/all.css' rel='stylesheet'>
                    <script src='https://kit.fontawesome.com/fed2435e21.js' crossorigin='anonymous'></script>
                    <title>VISION | SOFT</title>
                    <style>
                        .responsive {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
                </head>
                <body>
                    <center>
                       <img src='../../img/logo.png' width=300 height=212 class='responsive'>
                    <div class='container'>
                        <br />
                        <h3><b><i class='fa-solid fa-money-bill-transfer'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='showfia.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>