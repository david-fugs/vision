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

    $nit_cc_pro         =   $_POST['nit_cc_pro'];
    $nom_ape_pro        =   mb_strtoupper($_POST['nom_ape_pro']);
    $dir_pro            =   mb_strtoupper($_POST['dir_pro']);
    $mun_pro            =   $_POST['mun_pro'];
    $tel1_pro           =   $_POST['tel1_pro'];
    $tel2_pro           =   $_POST['tel2_pro'];
    $email_pro          =   $_POST['email_pro'];
    $forma_pago_pro     =   $_POST['forma_pago_pro'];
    $entidad_ban_pro    =   $_POST['entidad_ban_pro'];
    $tipo_cta_pro       =   $_POST['tipo_cta_pro'];
    $num_cta_pro        =   $_POST['num_cta_pro'];
    $tipo_reg_iva_pro   =   $_POST['tipo_reg_iva_pro'];
    $obs_pro            =   $_POST['obs_pro'];
    $estado_pro         =   1;
    $fecha_alta_pro     =   date('Y-m-d h:i:s');
    $id_usu_alta_pro    =   $_SESSION['id_usu'];
    $fecha_edit_pro     =   ('0000-00-00 00:00:00');
    $id_usu             =   $_SESSION['id_usu'];

    // Capturamos los valores de los checkboxes (1 si están seleccionados, 0 si no)
    $no_responsable_iva_pro = isset($_POST['no_responsable_iva_pro']) && $_POST['no_responsable_iva_pro'] === "1" ? 1 : 0;
    $reg_simple_trib_pro    = isset($_POST['reg_simple_trib_pro']) && $_POST['reg_simple_trib_pro'] === "1" ? 1 : 0;
    $impto_ventas_iva_pro   = isset($_POST['impto_ventas_iva_pro']) && $_POST['impto_ventas_iva_pro'] === "1" ? 1 : 0;
    $rete_fte_pro           = isset($_POST['rete_fte_pro']) && $_POST['rete_fte_pro'] === "1" ? 1 : 0;
    $rete_iva_pro           = isset($_POST['rete_iva_pro']) && $_POST['rete_iva_pro'] === "1" ? 1 : 0;
    $rete_ica_pro           = isset($_POST['rete_ica_pro']) && $_POST['rete_ica_pro'] === "1" ? 1 : 0;

    // Consulta SQL corregida
    $sql = "INSERT INTO propietarios (
        nit_cc_pro, nom_ape_pro, mun_pro, dir_pro, tel1_pro, tel2_pro, email_pro, forma_pago_pro, entidad_ban_pro, tipo_cta_pro, num_cta_pro, tipo_reg_iva_pro, obs_pro, estado_pro, fecha_alta_pro, id_usu_alta_pro, fecha_edit_pro, id_usu, no_responsable_iva_pro, reg_simple_trib_pro, impto_ventas_iva_pro, rete_fte_pro, rete_iva_pro, rete_ica_pro
        ) VALUES (
        '$nit_cc_pro', '$nom_ape_pro', '$mun_pro', '$dir_pro', '$tel1_pro', '$tel2_pro', '$email_pro', '$forma_pago_pro','$entidad_ban_pro', '$tipo_cta_pro', '$num_cta_pro', '$tipo_reg_iva_pro', '$obs_pro', '$estado_pro', '$fecha_alta_pro', '$id_usu_alta_pro', '$fecha_edit_pro', '$id_usu', 
        '$no_responsable_iva_pro', '$reg_simple_trib_pro', '$impto_ventas_iva_pro', '$rete_fte_pro', '$rete_iva_pro', '$rete_ica_pro')";

    $resultado = $mysqli->query($sql);

    // Verificar si hubo un error en la consulta
    if (!$resultado) {
        die('Error en la consulta: ' . $mysqli->error);
    }

    $id_insert = $nit_cc_pro;
    
    // Manejo de archivos
    foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
    {
        if($_FILES["archivo"]["name"][$key])
        {
            $filename = $_FILES["archivo"]["name"][$key];
            $source = $_FILES["archivo"]["tmp_name"][$key];
            
            $directorio = 'files/'.$id_insert.'/';
            
            if(!file_exists($directorio))
            {
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracción");    
            }
            
            $dir=opendir($directorio);
            $target_path = $directorio.'/'.$filename;
            
            if(move_uploaded_file($source, $target_path))
            { 
                // Archivo subido correctamente
            } 
            else 
            {    
                echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
            }
            closedir($dir);
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
                        <h3><b><i class='fa-solid fa-city'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='showpro.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>
