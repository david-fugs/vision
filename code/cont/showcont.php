<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
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
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/estilos2024.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm">
    
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        .selector-for-some-widget {
            box-sizing: content-box;
        }

        .pending {
            background-color: orange;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .ok {
            background-color: lightblue;
            color: black;
            font-weight: bold;
            text-align: center;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"></script>

<center>
    <img src='../../img/logo.png' width="300" height="212" class="responsive">
</center>

<h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature"></i> CONTRATOS VIGENTES</b></h1>

<div class="flex">
    <div class="box">
        <form action="showexh.php" method="get" class="form">
            <input name="num_con" type="text" placeholder="Código Fianza">
            <input name="mat_inm" type="text" placeholder="CC Arrendatario">
            <input name="nit_cc_arr" type="text" placeholder="Matricula Inm.">
            <input value="Realizar Busqueda" type="submit">
        </form>
    </div>
</div>

<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

date_default_timezone_set("America/Bogota");
include("../../conexion.php");
require_once("../../zebra.php");

$num_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';
$mat_inm = isset($_GET['mat_inm']) ? $_GET['mat_inm'] : '';
$nit_cc_arr = isset($_GET['nit_cc_arr']) ? $_GET['nit_cc_arr'] : '';

// Verifica si la conexión a la base de datos es exitosa
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$query = "SELECT contratos.*, inmuebles.nom_inm, inmuebles.dir_inm, arrendatarios.nom_ape_arr 
          FROM contratos 
          INNER JOIN inmuebles ON contratos.mat_inm=inmuebles.mat_inm
          INNER JOIN arrendatarios ON contratos.nit_cc_arr=arrendatarios.nit_cc_arr
          WHERE (contratos.mat_inm LIKE '%$mat_inm%') 
          AND (contratos.nit_cc_arr LIKE '%$nit_cc_arr%') 
          AND (contratos.num_con LIKE '%$num_con%') 
          ORDER BY contratos.num_con DESC";

$res = $mysqli->query($query);
if (!$res) {
    die("Error en la consulta: " . $mysqli->error);
}

$num_registros = mysqli_num_rows($res);
$resul_x_pagina = 500;

echo "<section class='content'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>CONT. No.</th>
                            <th>INMUEBLE</th>
                            <th>DIRECCION</th>
                            <th>ARRENDATARIO</th>
                            <th>FECHA INICIO</th>
                            <th>VIGENCIA</th>
                            <th>CANON</th>
                            <th>ADMON</th>
                            <th>IVA</th>
                            <th>RENTA</th>
                            <th>VER COD.</th>
                            <th>EST. PAGO</th>
                            <th>GEN. PAGO</th>
                            <th>EDIT</th>
                        </tr>
                    </thead>
                    <tbody>";

$paginacion = new Zebra_Pagination();
$paginacion->records($num_registros);
$paginacion->records_per_page($resul_x_pagina);

$consulta = "SELECT contratos.*, inmuebles.nom_inm, inmuebles.dir_inm, arrendatarios.nom_ape_arr 
             FROM contratos 
             INNER JOIN inmuebles ON contratos.mat_inm=inmuebles.mat_inm
             INNER JOIN arrendatarios ON contratos.nit_cc_arr=arrendatarios.nit_cc_arr
             WHERE (contratos.mat_inm LIKE '%$mat_inm%') 
             AND (contratos.nit_cc_arr LIKE '%$nit_cc_arr%') 
             AND (contratos.num_con LIKE '%$num_con%') 
             ORDER BY contratos.num_con DESC 
             LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";

$result = $mysqli->query($consulta);
if (!$result) {
    die("Error en la consulta: " . $mysqli->error);
}

$paginacion->render();
$i = 1;
while ($row = mysqli_fetch_array($result)) {
    // Formatear los valores como moneda
    $canon_con = '$' . number_format($row['canon_con'], 0, ',', '.');
    $admon_con = '$' . number_format($row['admon_con'], 0, ',', '.');
    $iva_con = '$' . number_format($row['iva_con'], 0, ',', '.');
    $renta_con = '$' . number_format($row['renta_con'], 0, ',', '.');

    // Verificar si se han generado pagos
    $num_contrato = $row['num_con'];
    $pagos_query = "SELECT COUNT(*) AS pagos_count FROM pagos WHERE num_con = '$num_contrato'";
    $pagos_result = $mysqli->query($pagos_query);
    $pagos_row = $pagos_result->fetch_assoc();
    $pagos_generados = $pagos_row['pagos_count'] > 0;

    $estado_pago = $pagos_generados ? 'OK' : 'Pendiente';
    $estado_pago_clase = $pagos_generados ? 'ok' : 'pending';
    $gen_pago_disabled = $pagos_generados ? 'disabled-link' : '';

    echo '
        <tr>
        <td data-label="No.">' . ($i + (($paginacion->get_page() - 1) * $resul_x_pagina)) . '</td>
        <td data-label="CONT. No.">' . $row['num_con'] . '</td>
        <td data-label="INMUEBLE">' . $row['nom_inm'] . '</td>
        <td data-label="DIRECCION">' . $row['dir_inm'] . '</td>
        <td data-label="ARRENDATARIO">' . $row['nom_ape_arr'] . '</td>
        <td data-label="FECHA INICIO">' . $row['fec_inicio_con'] . '</td>
        <td data-label="VIGENCIA">' . $row['vigencia_duracion_con'] . '</td>
        <td data-label="CANON">' . $canon_con . '</td>
        <td data-label="ADMON">' . $admon_con . '</td>
        <td data-label="IVA">' . $iva_con . '</td>
        <td data-label="RENTA"><strong>' . $renta_con . '</strong></td>
        <td data-label="VER COD."><a href="showCodeu.php?num_con=' . $row['num_con'] . '" ><img src="../../img/codeudores.png" width=28 height=28></a></td>
        <td data-label="EST. PAGO" class="' . $estado_pago_clase . '">' . $estado_pago . '</td>
        <td data-label="GEN. PAGO"><a class="' . $gen_pago_disabled . '" href="../pag/makepay.php?num_con=' . $row['num_con'] . '"><img src="../../img/pagos.png" width=28 height=28></a></td>
        <td data-label="EDITAR"><a href="editcont.php?num_con=' . $row['num_con'] . '"><img src="../../img/editar.png" width=28 height=28></a></td>
        </tr>';
    
    $i++;
}

echo '</table>
</div>';
?>

<center>
<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
</center>

<script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

</body>
</html>
