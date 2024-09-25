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
            $id_exh                     =   $_POST['id_exh'];
            $cod_fr_exh                 =   $_POST['cod_fr_exh'];
            $direccion_inm_exh          =   mb_strtoupper($_POST['direccion_inm_exh']);
            $nom_ape_inte_exh           =   mb_strtoupper($_POST['nom_ape_inte_exh']);
            $raz_soc_exh                =   mb_strtoupper($_POST['raz_soc_exh']);
            $nit_cc_exh                 =   $_POST['nit_cc_exh'];
            $cel_inte_exh               =   $_POST['cel_inte_exh'];
            $tel_inte_exh               =   $_POST['tel_inte_exh'];
            $email_inte_exh             =   $_POST['email_inte_exh'];
            $valor_ubicacion_exh        =   $_POST['valor_ubicacion_exh'];
            $valor_fachada_exh          =   $_POST['valor_fachada_exh'];
            $valor_area_exterior_exh    =   $_POST['valor_area_exterior_exh'];
            $valor_iluminacion_exh      =   $_POST['valor_iluminacion_exh'];
            $valor_altura_exh           =   $_POST['valor_altura_exh'];
            $valor_pisos_exh            =   $_POST['valor_pisos_exh'];
            $valor_paredes_exh          =   $_POST['valor_paredes_exh'];
            $valor_carpinteria_exh      =   $_POST['valor_carpinteria_exh'];
            $valor_banhos_exh           =   $_POST['valor_banhos_exh'];
            $obs1_exh                   =   $_POST['obs1_exh'];
            $obs2_exh                   =   $_POST['obs2_exh'];
            $nit_cc_ase                 =   $_POST['nit_cc_ase'];
            $estado_exh                 =   1;
            $fecha_edit_exh             =   date('Y-m-d h:i:s');
            $id_usu                     =   $_SESSION['id_usu'];
           
            $update = "UPDATE exhibiciones SET cod_fr_exh='".$cod_fr_exh."', direccion_inm_exh='".$direccion_inm_exh."', nom_ape_inte_exh='".$nom_ape_inte_exh."', raz_soc_exh='".$raz_soc_exh."', raz_soc_exh='".$raz_soc_exh."', cel_inte_exh='".$cel_inte_exh."', tel_inte_exh='".$tel_inte_exh."', email_inte_exh='".$email_inte_exh."', valor_ubicacion_exh='".$valor_ubicacion_exh."', valor_fachada_exh='".$valor_fachada_exh."', valor_area_exterior_exh='".$valor_area_exterior_exh."', valor_iluminacion_exh='".$valor_iluminacion_exh."', valor_altura_exh='".$valor_altura_exh."', valor_pisos_exh='".$valor_pisos_exh."', valor_paredes_exh='".$valor_paredes_exh."', valor_carpinteria_exh='".$valor_carpinteria_exh."', valor_banhos_exh='".$valor_banhos_exh."', obs1_exh='".$obs1_exh."', obs2_exh='".$obs2_exh."', nit_cc_ase='".$nit_cc_ase."', estado_exh='".$estado_exh."', fecha_edit_exh='".$fecha_edit_exh."', id_usu='".$id_usu."' WHERE id_exh='".$id_exh."'";

            $up = mysqli_query($mysqli, $update);

            $id_insert = $cod_fr_exh;
            //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
            {
                //Validamos que el archivo exista
                if($_FILES["archivo"]["name"][$key])
                {
                    $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                    
                    $directorio = 'files/'.$id_insert.'/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    
                    //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($directorio))
                    {
                        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    
                    $dir=opendir($directorio); //Abrimos el directorio de destino
                    $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                    
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(move_uploaded_file($source, $target_path))
                    { 
                        //echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
                    } 
                        else 
                        {    
                            echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                        }
                    closedir($dir); //Cerramos el directorio de destino
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
                                    <h3><b><i class='fa-solid fa-store'></i> SE ACTUALIZÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                                <p align='center'><a href='showexh.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                            </div>
                            </center>
                        </body>
                    </html>
        ";
        }
    ?>

</body>
</html>