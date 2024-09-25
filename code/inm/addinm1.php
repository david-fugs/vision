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
    $nom_inm            =   mb_strtoupper($_POST['nom_inm']);
    $mun_inm            =   $_POST['mun_inm'];
    $dir_inm            =   mb_strtoupper($_POST['dir_inm']);
    $tel_inm            =   $_POST['tel_inm'];
    $est_inm            =   $_POST['est_inm'];
    $zona_inm           =   $_POST['zona_inm'];
    $obs_inm            =   $_POST['obs_inm'];
    $estado_inm         =   1;
    $fecha_alta_inm     =   date('Y-m-d h:i:s');
    $id_usu_alta_inm    =   $_SESSION['id_usu'];
    $fecha_edit_inm     =   ('0000-00-00 00:00:00');
    $id_usu             =   $_SESSION['id_usu'];

   $sql = "INSERT INTO inmuebles (mat_inm, nom_inm, mun_inm, dir_inm, tel_inm, est_inm, zona_inm, obs_inm, estado_inm, fecha_alta_inm, id_usu_alta_inm, fecha_edit_inm, id_usu) values ('$mat_inm', '$nom_inm', '$mun_inm', '$dir_inm', '$tel_inm','$est_inm','$zona_inm','$obs_inm', '$estado_inm', '$fecha_alta_inm', '$id_usu_alta_inm', '$fecha_edit_inm', '$id_usu')";
    $resultado = $mysqli->query($sql);

    $id_insert = $mat_inm;
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
                        <p align='center'><a href='../../access.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
?>