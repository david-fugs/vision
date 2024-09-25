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

    $mat_inm            =   $_POST['mat_inm'];
    $nit_cc_pro         =   $_POST['nit_cc_pro'];
    $obs_prop           =   $_POST['obs_prop'];
    $estado_prop        =   1;
    $fecha_alta_prop    =   date('Y-m-d h:i:s');
    $id_usu_alta_prop   =   $_SESSION['id_usu'];
    $fecha_edit_prop    =   ('0000-00-00 00:00:00');
    $id_usu             =   $_SESSION['id_usu'];

   $sql = "INSERT INTO propiedades (mat_inm, nit_cc_pro, obs_prop, estado_prop, fecha_alta_prop, id_usu_alta_prop, fecha_edit_prop, id_usu) values ('$mat_inm', '$nit_cc_pro', '$obs_prop', '$estado_prop','$fecha_alta_prop', '$id_usu_alta_prop', '$fecha_edit_prop', '$id_usu')";
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
                        <h3><b><i class='fa-solid fa-building-user'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>