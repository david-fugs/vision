<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../conexion.php");

session_start();

if(!isset($_SESSION['id_usu'])){
    header("Location: ../../index.php");
    exit();
}

$num_con                = $_POST['num_con'];
$fec_con                = $_POST['fec_con'];
$mat_inm                = $_POST['mat_inm'];
$nit_cc_pro             = $_POST['nit_cc_pro_hidden'];
$arrendador_con         = $_POST['arrendador_con'];
$nit_cc_arr             = $_POST['nit_cc_arr'];
$fec_inicio_con         = $_POST['fec_inicio_con'];
$vigencia_duracion_con  = $_POST['vigencia_duracion_con'];
$serv_agua_con          = $_POST['serv_agua_con'];
$serv_ener_con          = $_POST['serv_ener_con'];
$serv_gas_con           = $_POST['serv_gas_con'];
$canon_con              = $_POST['canon_con'];
$iva_con                = $_POST['iva_con'];
$admon_con              = $_POST['admon_con'];
$renta_con              = $_POST['renta_con'];
$iva_arrendador_con     = $_POST['iva_arrendador_con'];
$obs_con                = $_POST['obs_con'];
$estado_con             = 1;
$fecha_alta_con         = date('Y-m-d H:i:s'); // Corrección de formato de fecha
$id_usu_alta_con        = $_SESSION['id_usu'];
$fecha_edit_con         = '0000-00-00 00:00:00';
$id_usu                 = $_SESSION['id_usu'];

// Insertar en la tabla CONTRATOS
$query_contratos = "INSERT INTO contratos (num_con, fec_con, mat_inm, nit_cc_pro, arrendador_con, nit_cc_arr, fec_inicio_con, vigencia_duracion_con, serv_agua_con, serv_ener_con, serv_gas_con, canon_con, iva_con, admon_con, renta_con, iva_arrendador_con, obs_con, estado_con, fecha_alta_con, id_usu_alta_con, fecha_edit_con, id_usu) 
                    VALUES ('$num_con', '$fec_con', '$mat_inm', '$nit_cc_pro', '$arrendador_con', '$nit_cc_arr', '$fec_inicio_con', '$vigencia_duracion_con', '$serv_agua_con', '$serv_ener_con', '$serv_gas_con', '$canon_con', '$iva_con', '$admon_con', '$renta_con', '$iva_arrendador_con', '$obs_con', '$estado_con', '$fecha_alta_con', '$id_usu_alta_con', '$fecha_edit_con', '$id_usu')";

// Ejecutar la consulta e identificar errores
if (!mysqli_query($mysqli, $query_contratos)) {
    die('Error al insertar en contratos: ' . mysqli_error($mysqli));
}

$fecha_alta_con_cod     = date('Y-m-d H:i:s'); // Corrección de formato de fecha
$id_usu_alta_con_cod    = $_SESSION['id_usu'];
$fecha_edit_con_cod     = '0000-00-00 00:00:00';
$id_usu                 = $_SESSION['id_usu'];

// Insertar en la tabla FIANZA_CODEUDOR
if (!empty($_POST['codeudores'])) {
    foreach ($_POST['codeudores'] as $nit_cc_cod) {
        $query_contratos_codeudores = "INSERT INTO contratos_codeudores (num_con, nit_cc_cod, fecha_alta_con_cod, id_usu_alta_con_cod, fecha_edit_con_cod, id_usu) 
            VALUES ('$num_con', '$nit_cc_cod', '$fecha_alta_con_cod', '$id_usu_alta_con_cod', '$fecha_edit_con_cod', '$id_usu')";
        if (!mysqli_query($mysqli, $query_contratos_codeudores)) {
            die('Error al insertar en contratos_codeudores: ' . mysqli_error($mysqli));
        }
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
                        <h3><b><i class='fa-solid fa-file-signature'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='showcont.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>
