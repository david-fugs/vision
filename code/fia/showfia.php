<?php
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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>VISION | SOFT</title>
        <script src="js/64d58efce2.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
        <link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
        <link href="../../fontawesome/css/all.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    </head>
    <body>
        
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>

        <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-money-bill-transfer"></i> VERIFICACIÓN FIANZAS </b>
        </h1>

        <div class="flex">
            <div class="box">
                <form action="showexh.php" method="get" class="form">
                    <input name="con_fia" type="text" placeholder="Código Fianza">
                    <input name="nit_cc_arr" type="text" placeholder="CC Arrendatario">
                    <input name="mat_inm" type="text" placeholder="Matricula Inm.">
                    <input value="Realizar Busqueda" type="submit">
                </form>
            </div>
        </div>

        <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");
    require_once("../../zebra.php");

    $con_fia = isset($_GET['con_fia']) ? $_GET['con_fia'] : '';
    $nit_cc_arr = isset($_GET['nit_cc_arr']) ? $_GET['nit_cc_arr'] : '';
    $mat_inm = isset($_GET['mat_inm']) ? $_GET['mat_inm'] : '';

    // Verifica si la conexión a la base de datos es exitosa
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $query = "SELECT * FROM fianzas 
              INNER JOIN arrendatarios ON fianzas.nit_cc_arr=arrendatarios.nit_cc_arr 
              WHERE (fianzas.nit_cc_arr LIKE '%$nit_cc_arr%') 
              AND (fianzas.mat_inm LIKE '%$mat_inm%') 
              AND (fianzas.con_fia LIKE '%$con_fia%') 
              ORDER BY fianzas.con_fia DESC";
    
    $res = $mysqli->query($query);
    if (!$res) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $num_registros = $res->num_rows;
    $resul_x_pagina = 50;

    echo "<div class='flex'>
            <div class='box'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>FIANZA No.</th>
                            <th>FECHA</th>
                            <th>CANON</th>
                            <th>ADMON</th>
                            <th>IVA</th>
                            <th>ARRENDATARIO</th>
                            <th>INMUEBLE</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>";

    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);

    $consulta = "SELECT * FROM fianzas 
                 INNER JOIN arrendatarios ON fianzas.nit_cc_arr=arrendatarios.nit_cc_arr 
                 WHERE (fianzas.nit_cc_arr LIKE '%$nit_cc_arr%') 
                 AND (fianzas.mat_inm LIKE '%$mat_inm%') 
                 AND (fianzas.con_fia LIKE '%$con_fia%') 
                 ORDER BY fianzas.con_fia DESC 
                 LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";
    
    $result = $mysqli->query($consulta);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    function obtenerNumeroArchivos($con_fia) {
        $directorio = 'files/'.$con_fia.'/';
        if (file_exists($directorio)) {
            $num_archivos = count(glob($directorio . '*.*'));
            return max(0, $num_archivos);
        } else {
            return 0;
        }
    }

    $i = 1;
    while($row = $result->fetch_assoc())
    {
        $con_fia = $row['con_fia'];
        $num_archivos = obtenerNumeroArchivos($con_fia);

        // Establecer el color a rojo si el número de archivos es cero
        $color = ($num_archivos == 0) ? 'color: red;' : '';
        $visita_exh_text = ($row['visita_exh'] == 1) ? 'SI' : 'NO';

        echo '
                    <tr>
                        <td data-label="No." style="' . $color . '">'.($i + (($paginacion->get_page() - 1) * $resul_x_pagina)).'</td>
                        <td data-label="FIANZA No">'.$row['con_fia'].'</td>
                        <td data-label="FECHA">'.$row['fec_fia'].'</td>
                        <td data-label="CANON">'.$row['can_arr_fia'].'</td>
                        <td data-label="ADMON">'.$row['cuo_adm_fia'].'</td>
                        <td data-label="IVA">'.$row['iva_arr_fia'].'</td>
                        <td data-label="ARRENDATARIO">'.$row['nom_ape_arr'].'</td>
                        <td data-label="INMUEBLE">'.$row['mat_inm'].'</td>
                        <td data-label="EDIT"><a href="editfia.php?con_fia='.$row['con_fia'].'"><img src="../../img/editar.png" width=20 height=20></a></td>
                    </tr>';
        $i++;
    }
 
    echo '        </tbody>
                </table>
            </div>
          </div>';

    $paginacion->render();

?>
        
        </div>
        <center>
            <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
        </center>

    </body>
</html>
