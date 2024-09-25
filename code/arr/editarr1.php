<?php

    date_default_timezone_set("America/Bogota");
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VISION | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- Using Select2 from a CDN-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

   	<?php
        include("../../conexion.php");
        header("Content-Type: text/html;charset=utf-8");
	    if(isset($_POST['btn-update']))
        {
            $nit_cc_arr         =   $_POST['nit_cc_arr'];
            $nom_ape_arr        =   mb_strtoupper($_POST['nom_ape_arr']);
            $dir_arr            =   mb_strtoupper($_POST['dir_arr']);
            $mun_arr            =   $_POST['mun_arr'];
            $tel1_arr           =   $_POST['tel1_arr'];
            $tel2_arr           =   $_POST['tel2_arr'];
            $email_arr          =   $_POST['email_arr'];
            $fecha_nac_arr      =   $_POST['fecha_nac_arr'];
            $obs_arr            =   $_POST['obs_arr'];
            $estado_arr         =   1;
            $fecha_edit_arr     =   ('0000-00-00 00:00:00');
            $id_usu             =   $_SESSION['id_usu'];
           
            $update = "UPDATE arrendatarios SET nom_ape_arr='".$nom_ape_arr."', dir_arr='".$dir_arr."', mun_arr='".$mun_arr."', tel1_arr='".$tel1_arr."', tel2_arr='".$tel2_arr."', email_arr='".$email_arr."', fecha_nac_arr='".$fecha_nac_arr."', obs_arr='".$obs_arr."', estado_arr='".$estado_arr."', fecha_edit_arr='".$fecha_edit_arr."', id_usu='".$id_usu."' WHERE nit_cc_arr='".$nit_cc_arr."'";

            $up = mysqli_query($mysqli, $update);

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
                                    <h3><b><i class='fa-solid fa-user-group'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                                <p align='center'><a href='showarr.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                            </div>
                            </center>
                        </body>
                    </html>
        ";
        }
    ?>

</body>
</html>