<?php
    
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }
    
    $nombre         = $_SESSION['nombre'];
    $tipo_usu       = $_SESSION['tipo_usu'];

    include("../../conexion.php");
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Bogota");

    $nit_cc_ase         =   $_POST['nit_cc_ase'];
    $nom_ape_ase        =   mb_strtoupper($_POST['nom_ape_ase']);
    $dir_ase            =   mb_strtoupper($_POST['dir_ase']);
    $mun_ase            =   $_POST['mun_ase'];
    $tel1_ase           =   $_POST['tel1_ase'];
    $tel2_ase           =   $_POST['tel2_ase'];
    $email_ase          =   $_POST['email_ase'];
    $fecha_nac_ase      =   $_POST['fecha_nac_ase'];
    $fecha_vin_ase      =   $_POST['fecha_vin_ase'];
    $obs_ase            =   $_POST['obs_ase'];
    $estado_ase         =   1;
    $fecha_alta_ase     =   date('Y-m-d h:i:s');
    $id_usu_alta_ase    =   $_SESSION['id_usu'];
    $fecha_edit_ase     =   ('0000-00-00 00:00:00');
    $id_usu             =   $_SESSION['id_usu'];

   $sql = "INSERT INTO asesores (nit_cc_ase, nom_ape_ase, mun_ase, dir_ase, tel1_ase, tel2_ase, email_ase, fecha_nac_ase, fecha_vin_ase, obs_ase, estado_ase, fecha_alta_ase, id_usu_alta_ase, fecha_edit_ase, id_usu) values ('$nit_cc_ase', '$nom_ape_ase', '$mun_ase', '$dir_ase', '$tel1_ase','$tel2_ase','$email_ase','$fecha_nac_ase','$fecha_vin_ase','$obs_ase', '$estado_ase', '$fecha_alta_ase', '$id_usu_alta_ase', '$fecha_edit_ase', '$id_usu')";
    $resultado = $mysqli->query($sql);

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
                        <h3><b><i class='fa-solid fa-people-roof'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>