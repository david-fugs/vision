<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
}

$nombre         = $_SESSION['nombre'];
$tipo_usu       = $_SESSION['tipo_usu'];

include("../../conexion.php");
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");

$nit_cc_arr         = $_POST['nit_cc_arr'];
$nom_ape_arr        = mb_strtoupper($_POST['nom_ape_arr']);
$dir_arr            = mb_strtoupper($_POST['dir_arr']);
$mun_arr            = $_POST['mun_arr'];
$tel1_arr           = $_POST['tel1_arr'];
$tel2_arr           = $_POST['tel2_arr'];
$email_arr          = $_POST['email_arr'];
$tipo_reg_iva_arr   = $_POST['tipo_reg_iva_arr'];
$estado_arr         = 1;
$fecha_alta_arr     = date('Y-m-d h:i:s');
$id_usu_alta_arr    = $_SESSION['id_usu'];
$fecha_edit_arr     = '0000-00-00 00:00:00';
$id_usu             = $_SESSION['id_usu'];
 
// Capturamos los valores de los checkboxes (1 si están seleccionados, 0 si no)
$no_responsable_iva_arr = isset($_POST['no_responsable_iva_arr']) && $_POST['no_responsable_iva_arr'] === "1" ? 1 : 0;
$reg_simple_trib_arr    = isset($_POST['reg_simple_trib_arr']) && $_POST['reg_simple_trib_arr'] === "1" ? 1 : 0;
$impto_ventas_iva_arr   = isset($_POST['impto_ventas_iva_arr']) && $_POST['impto_ventas_iva_arr'] === "1" ? 1 : 0;
$rete_fte_arr           = isset($_POST['rete_fte_arr']) && $_POST['rete_fte_arr'] === "1" ? 1 : 0;
$rete_iva_arr           = isset($_POST['rete_iva_arr']) && $_POST['rete_iva_arr'] === "1" ? 1 : 0;
$rete_ica_arr           = isset($_POST['rete_ica_arr']) && $_POST['rete_ica_arr'] === "1" ? 1 : 0;

// Consulta SQL con los nuevos campos
$sql = "INSERT INTO arrendatarios (
            nit_cc_arr, nom_ape_arr, mun_arr, dir_arr, tel1_arr, tel2_arr, email_arr, tipo_reg_iva_arr, 
            estado_arr, fecha_alta_arr, id_usu_alta_arr, fecha_edit_arr, id_usu, no_responsable_iva_arr, reg_simple_trib_arr, impto_ventas_iva_arr, rete_fte_arr, rete_iva_arr, rete_ica_arr
        ) VALUES (
            '$nit_cc_arr', '$nom_ape_arr', '$mun_arr', '$dir_arr', '$tel1_arr','$tel2_arr','$email_arr','$tipo_reg_iva_arr', '$estado_arr', '$fecha_alta_arr', '$id_usu_alta_arr', '$fecha_edit_arr', '$id_usu', 
            '$no_responsable_iva_arr', '$reg_simple_trib_arr', '$impto_ventas_iva_arr', '$rete_fte_arr', '$rete_iva_arr', '$rete_ica_arr'
        )";

$resultado = $mysqli->query($sql);

// Verificar si hubo un error en la consulta
if (!$resultado) {
    die('Error en la consulta: ' . $mysqli->error);
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
                    <h3><b><i class='fa-solid fa-user-group'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                    <p align='center'><a href='showarr.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                </div>
                </center>
            </body>
        </html>
    ";
?>
