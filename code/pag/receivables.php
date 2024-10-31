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

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class='fa-solid fa-money-check-dollar'></i> COMISIONES PENDIENTES</b></h1>

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

    $query = "SELECT  COUNT(*) as total_filas, pr.*,p.num_con FROM pagos_realizados as pr
    JOIN pagos as  p ON pr.id_pago = p.id_pago
     WHERE pr.diferencia > 0";

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
                        <th >CONT. No.</th>
                        <th >FECHA PAGO</th>
                        <th style='width:300px;'>NÚMERO CUENTAS POR COBRAR </th>
                        <th>+ INF</th>
                    </tr>
                </thead>
                <tbody>";

    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);

    $consulta = "SELECT COUNT(*) as total_filas, pr.*,p.num_con FROM pagos_realizados as pr
    JOIN pagos as  p ON pr.id_pago = p.id_pago
     WHERE pr.diferencia > 0
             LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";

    $result = $mysqli->query($consulta);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $paginacion->render();
    while ($row = mysqli_fetch_array($result)) {
        // Formatear los valores como moneda
        echo '
        <tr>
        <td data-label="CONT. No.">' . $row['num_con'] . '</td>
        <td data-label="FECHA INICIO">' . $row['fecha_pago_realizado'] . '</td>
        <td data-label="NÚMERO DE PAGOS">' . $row['total_filas'] . '</td>
         <td data-label="+ INFO"><a href="showReceivables1.php?num_con=' . $row['num_con'] . '"><img src="../../img/buscar.png" width=28 height=28></a></td>
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
