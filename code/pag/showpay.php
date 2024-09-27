<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
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

        .bg-red {
            background-color: red;
            color: white;
        }

        .bg-green {
            background-color: green;
            color: white;
        }
    </style>
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxmHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"></script>

    <center>
        <img src='../../img/logo.png' width="300" height="212" class="responsive">
    </center>

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class='fa-solid fa-money-check-dollar'></i> FACTURACIÓN Y COBROS</b></h1>

    <div class="flex">
        <div class="box">
            <form action="showpay.php" method="get" class="form">
                <input name="num_con" type="text" placeholder="Contrato No.">
                <input value="Realizar Busqueda" type="submit">
            </form>
        </div>
    </div>

    <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

    <?php

    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");
    require_once("../../zebra.php");

    $num_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';

    // Verifica si la conexión a la base de datos es exitosa
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $query = "SELECT contratos.num_con, contratos.fec_inicio_con, 
                 SUM(pagos.canon_con) AS total_canon, 
                 SUM(pagos.admon_con) AS total_admon, 
                 SUM(pagos.iva_con) AS total_iva, 
                 SUM(pagos.renta_con) AS total_renta, 
                 SUM(pagos.comision_pago) AS total_comision, 
                 SUM(pagos.total_consignar_pago) AS total_consignar, 
                 COUNT(pagos.id_pago) AS num_pagos,
                 SUM(CASE WHEN pagos_realizados.valor_pagado IS NULL AND pagos.fecha_pago < NOW() THEN 1 ELSE 0 END) AS pagos_vencidos,
                 SUM(CASE WHEN pagos_realizados.valor_pagado IS NOT NULL AND pagos_realizados.valor_pagado >= pagos.canon_con THEN 1 ELSE 0 END) AS pagos_al_dia
          FROM contratos
          INNER JOIN pagos ON contratos.num_con = pagos.num_con
          INNER JOIN inmuebles ON contratos.mat_inm = inmuebles.mat_inm
          LEFT JOIN pagos_realizados ON pagos.id_pago = pagos_realizados.id_pago
          WHERE contratos.num_con LIKE '%$num_con%'
          GROUP BY contratos.num_con, contratos.fec_inicio_con
          ORDER BY contratos.num_con ASC";

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
                        <th>CONT. No.</th>
                        <th>FECHA INICIO</th>
                        <th>TOTAL CANON</th>
                        <th>TOTAL ADMON</th>
                        <th>TOTAL IVA</th>
                        <th>TOTAL RENTA</th>
                        <th>TOTAL COMISION</th>
                        <th>TOTAL PROPIETARIO</th>
                        <th>NÚMERO DE PAGOS</th>
                        <th>PAGOS PENDIENTES</th>
                        <th>PAGOS AL DÍA</th>
                        <th>+ INF</th>
                    </tr>
                </thead>
                <tbody>";

    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);

    $consulta = "SELECT contratos.num_con, contratos.fec_inicio_con, 
                    SUM(pagos.canon_con) AS total_canon, 
                    SUM(pagos.admon_con) AS total_admon, 
                    SUM(pagos.iva_con) AS total_iva, 
                    SUM(pagos.renta_con) AS total_renta, 
                    SUM(pagos.comision_pago) AS total_comision, 
                    SUM(pagos.total_consignar_pago) AS total_consignar, 
                    COUNT(pagos.id_pago) AS num_pagos,
                    SUM(CASE WHEN pagos_realizados.valor_pagado IS NULL AND pagos.fecha_pago < NOW() THEN 1 ELSE 0 END) AS pagos_vencidos,
                    SUM(CASE WHEN pagos_realizados.valor_pagado IS NOT NULL AND pagos_realizados.valor_pagado >= pagos.canon_con THEN 1 ELSE 0 END) AS pagos_al_dia
             FROM contratos
             INNER JOIN pagos ON contratos.num_con = pagos.num_con
             INNER JOIN inmuebles ON contratos.mat_inm = inmuebles.mat_inm
             LEFT JOIN pagos_realizados ON pagos.id_pago = pagos_realizados.id_pago
             WHERE contratos.num_con LIKE '%$num_con%'
             GROUP BY contratos.num_con, contratos.fec_inicio_con
             ORDER BY contratos.num_con ASC 
             LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";

    $result = $mysqli->query($consulta);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $paginacion->render();
    while ($row = mysqli_fetch_array($result)) {
        // Formatear los valores como moneda
        $total_canon = '$' . number_format($row['total_canon'], 0, ',', '.');
        $total_admon = '$' . number_format($row['total_admon'], 0, ',', '.');
        $total_iva = '$' . number_format($row['total_iva'], 0, ',', '.');
        $total_renta = '$' . number_format($row['total_renta'], 0, ',', '.');
        $total_comision = '$' . number_format($row['total_comision'], 0, ',', '.');
        $total_consignar = '$' . number_format($row['total_consignar'], 0, ',', '.');

        // Determinar el estado de pagos pendientes
        if ($row['pagos_vencidos'] > 0) {
            $pagos_pendientes = $row['pagos_vencidos'];
            $clase_estado = "bg-red";
        } else {
            $pagos_pendientes = "AL DÍA";
            $clase_estado = "bg-green";
        }

        echo '
        <tr>
        <td data-label="CONT. No.">' . $row['num_con'] . '</td>
        <td data-label="FECHA INICIO">' . $row['fec_inicio_con'] . '</td>
        <td data-label="TOTAL CANON">' . $total_canon . '</td>
        <td data-label="TOTAL ADMON">' . $total_admon . '</td>
        <td data-label="TOTAL IVA">' . $total_iva . '</td>
        <td data-label="TOTAL RENTA">' . $total_renta . '</td>
        <td data-label="TOTAL COMISION"><strong>' . $total_comision . '</strong></td>
        <td data-label="TOTAL PROPIETARIO"><strong>' . $total_consignar . '</strong></td>
        <td data-label="NÚMERO DE PAGOS">' . $row['num_pagos'] . '</td>
        <td data-label="PAGOS PENDIENTES" class="' . $clase_estado . '">' . $pagos_pendientes . '</td>
        <td data-label="PAGOS AL DÍA" class="bg-green">' . $row['pagos_al_dia'] . '</td>
        <td data-label="+ INFO"><a href="showpay1.php?num_con=' . $row['num_con'] . '"><img src="../../img/buscar.png" width=28 height=28></a></td>
        </tr>';
    }

    echo '</table>
</div>';
    ?>

    <center>
        <br /><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

</body>

</html>