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
            $nit_cc_cod         =   $_POST['nit_cc_cod'];
            $nom_ape_cod        =   mb_strtoupper($_POST['nom_ape_cod']);
            $dir_cod            =   mb_strtoupper($_POST['dir_cod']);
            $mun_cod            =   $_POST['mun_cod'];
            $tel1_cod           =   $_POST['tel1_cod'];
            $tel2_cod           =   $_POST['tel2_cod'];
            $email_cod          =   $_POST['email_cod'];
            $obs_cod            =   $_POST['obs_cod'];
            $nit_cc_arr         =   $_POST['nit_cc_arr'];
            $estado_cod         =   1;
            $fecha_edit_cod     =   ('0000-00-00 00:00:00');
            $id_usu             =   $_SESSION['id_usu'];
           
            $update = "UPDATE codeudor SET nom_ape_cod='".$nom_ape_cod."', dir_cod='".$dir_cod."', mun_cod='".$mun_cod."', tel1_cod='".$tel1_cod."', tel2_cod='".$tel2_cod."', email_cod='".$email_cod."', obs_cod='".$obs_cod."', nit_cc_arr='".$nit_cc_arr."', estado_cod='".$estado_cod."', fecha_edit_cod='".$fecha_edit_cod."', id_usu='".$id_usu."' WHERE nit_cc_cod='".$nit_cc_cod."'";

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
                                    <h3><b><i class='fa-solid fa-user-plus'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                                <p align='center'><a href='showcod.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                            </div>
                            </center>
                        </body>
                    </html>
        ";
        }
    ?>

</body>
</html>