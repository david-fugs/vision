<?php

session_start();

if(!isset($_SESSION['id_usu'])){
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");

$cod_fr_exh          = $_POST['cod_fr_exh'];
$visita_exh          = $_POST['visita_exh'];
$tipo_inm_exh        = isset($_POST['tipo_inm_exh']) ? $_POST['tipo_inm_exh'] : 'N/A';
$nom_vis_exh         = isset($_POST['nom_vis_exh']) ? $_POST['nom_vis_exh'] : 'N/A';
$fec_exh             = date('Y-m-d H:i:s');
$direccion_inm_exh   = mb_strtoupper($_POST['direccion_inm_exh']);
$nom_ape_inte_exh    = mb_strtoupper($_POST['nom_ape_inte_exh']);
$raz_soc_exh         = mb_strtoupper($_POST['raz_soc_exh']);
$nit_cc_exh          = isset($_POST['nit_cc_exh']) ? $_POST['nit_cc_exh'] : 0;
$cel_inte_exh        = $_POST['cel_inte_exh'];
$tel_inte_exh        = $_POST['tel_inte_exh'];
$email_inte_exh      = $_POST['email_inte_exh'];
$area_max_exh        = isset($_POST['area_max_exh']) ? $_POST['area_max_exh'] : 0;
$area_min_exh        = isset($_POST['area_min_exh']) ? $_POST['area_min_exh'] : 0;
$tipo_sis_elec_exh   = isset($_POST['tipo_sis_elec_exh']) ? $_POST['tipo_sis_elec_exh'] : 'N/A';
$kVA_exh             = isset($_POST['kVA_exh']) ? $_POST['kVA_exh'] : 0;
$presupuesto_max_exh = isset($_POST['presupuesto_max_exh']) ? $_POST['presupuesto_max_exh'] : 0;
$presupuesto_min_exh = isset($_POST['presupuesto_min_exh']) ? $_POST['presupuesto_min_exh'] : 0;
$valor_ubicacion_exh = isset($_POST['valor_ubicacion_exh']) ? $_POST['valor_ubicacion_exh'] : 0;
$valor_fachada_exh   = isset($_POST['valor_fachada_exh']) ? $_POST['valor_fachada_exh'] : 0;
$valor_area_exterior_exh = isset($_POST['valor_area_exterior_exh']) ? $_POST['valor_area_exterior_exh'] : 0;
$valor_iluminacion_exh = isset($_POST['valor_iluminacion_exh']) ? $_POST['valor_iluminacion_exh'] : 0;
$valor_altura_exh    = isset($_POST['valor_altura_exh']) ? $_POST['valor_altura_exh'] : 0;
$valor_pisos_exh     = isset($_POST['valor_pisos_exh']) ? $_POST['valor_pisos_exh'] : 0;
$valor_paredes_exh   = isset($_POST['valor_paredes_exh']) ? $_POST['valor_paredes_exh'] : 0;
$valor_carpinteria_exh = isset($_POST['valor_carpinteria_exh']) ? $_POST['valor_carpinteria_exh'] : 0;
$valor_banhos_exh    = isset($_POST['valor_banhos_exh']) ? $_POST['valor_banhos_exh'] : 0;
$obs1_exh            = mb_strtoupper(isset($_POST['obs1_exh']) ? $_POST['obs1_exh'] : '');
$obs2_exh            = mb_strtoupper(isset($_POST['obs2_exh']) ? $_POST['obs2_exh'] : '');
$nit_cc_ase          = $_POST['nit_cc_ase'];
$estado_exh          = 1;
$fecha_alta_exh      = date('Y-m-d H:i:s');
$id_usu              = $_SESSION['id_usu'];
$fecha_edit_exh      = ('0000-00-00 00:00:00');
$id_usu_alta_exh     = $_SESSION['id_usu'];

$sql = "INSERT INTO exhibiciones (
    cod_fr_exh, visita_exh, tipo_inm_exh, nom_vis_exh, fec_exh, 
    direccion_inm_exh, nom_ape_inte_exh, raz_soc_exh, nit_cc_exh, 
    cel_inte_exh, tel_inte_exh, email_inte_exh, area_max_exh, area_min_exh, 
    tipo_sis_elec_exh, kVA_exh, presupuesto_max_exh, presupuesto_min_exh, 
    valor_ubicacion_exh, valor_fachada_exh, valor_area_exterior_exh, valor_iluminacion_exh, 
    valor_altura_exh, valor_pisos_exh, valor_paredes_exh, valor_carpinteria_exh, 
    valor_banhos_exh, obs1_exh, obs2_exh, nit_cc_ase, estado_exh, 
    fecha_alta_exh, id_usu_alta_exh, fecha_edit_exh, id_usu
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('sssssssssssssssssssssssssssssssssss', 
    $cod_fr_exh, $visita_exh, $tipo_inm_exh, $nom_vis_exh, $fec_exh, 
    $direccion_inm_exh, $nom_ape_inte_exh, $raz_soc_exh, $nit_cc_exh, 
    $cel_inte_exh, $tel_inte_exh, $email_inte_exh, $area_max_exh, $area_min_exh, 
    $tipo_sis_elec_exh, $kVA_exh, $presupuesto_max_exh, $presupuesto_min_exh, 
    $valor_ubicacion_exh, $valor_fachada_exh, $valor_area_exterior_exh, $valor_iluminacion_exh, 
    $valor_altura_exh, $valor_pisos_exh, $valor_paredes_exh, $valor_carpinteria_exh, 
    $valor_banhos_exh, $obs1_exh, $obs2_exh, $nit_cc_ase, $estado_exh, 
    $fecha_alta_exh, $id_usu_alta_exh, $fecha_edit_exh, $id_usu
);

if ($stmt->execute()) {
    // Usa cod_fr_exh como nombre de directorio
    $directorio = 'files/' . $cod_fr_exh . '/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true) or die("No se puede crear el directorio de extracción");    
    }

    // Asegúrate de que el directorio de firmas basado en nit_cc_exh exista y tenga permisos de escritura
    $signature_dir = 'files/signatures/' . $nit_cc_exh . '/';
    if (!file_exists($signature_dir)) {
        mkdir($signature_dir, 0777, true);
    }

    // Manejar la firma
    if (!empty($_POST['signature'])) {
        $signature = $_POST['signature'];
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $data = base64_decode($signature);
        $file = $signature_dir . uniqid() . '.png';
        file_put_contents($file, $data);
    }

    // Manejar la subida de archivos
    foreach ($_FILES["archivo"]['tmp_name'] as $key => $tmp_name) {
        if ($_FILES["archivo"]["name"][$key]) {
            $filename = $_FILES["archivo"]["name"][$key];
            $source = $_FILES["archivo"]["tmp_name"][$key];

            $target_path = $directorio . $filename;

            if (move_uploaded_file($source, $target_path)) {
                echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
            } else {
                echo "Ha ocurrido un error al mover el archivo $filename, por favor inténtelo de nuevo.<br>";
            }
        } else {
            echo "No se detectó archivo para el índice $key.<br>";
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
                    <h3><b><i class='fa-solid fa-store'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                    <p align='center'><a href='showexhpre.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                </div>
                </center>
            </body>
        </html>
    ";
} else {
    echo "Error al guardar el registro: " . $stmt->error;
}

$stmt->close();

?>