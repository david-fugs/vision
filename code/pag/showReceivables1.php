<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
}
$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];

$nume_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';;
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
        .pago:hover {
            cursor: pointer;
        }

        .text-blue {
            color: blue;
        }


        .excelAtras {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .responsive {
            max-width: 100%;
            height: auto;
        }

        .selector-for-some-widget {
            box-sizing: content-box;
        }

        .text-blue {
            color: blue;
        }

        .text-green {
            color: white;
            background-color: green;
        }

        .text-orange {
            color: white;
            background-color: orange;
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
    <br>
    <div class="excelAtras">
        <a href="receivables.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
        </a>
        <br>
    </div>
    <br>
    <?php
    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");
    require_once("../../zebra.php");

    $num_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';
    $id_pago = isset($_GET['id_pago']) ? $_GET['id_pago'] : '';
    $nit_cc_arr = isset($_GET['nit_cc_arr']) ? $_GET['nit_cc_arr'] : '';

    // Verifica si la conexión a la base de datos es exitosa
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $query = "SELECT *FROM cuentas_cobrar WHERE num_con = $num_con
        GROUP BY num_con
    ";
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
                        <th>FECHA PAGO</th>
                        <th>DIFERENCIA</th>
                        <th>ESTADO</th>
                        <th>REALIZAR PAGO</th>
                    </tr>
                </thead>
                <tbody>";
    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);

    $offset = ($paginacion->get_page() - 1) * $resul_x_pagina;

    $consulta = "SELECT * FROM cuentas_cobrar WHERE num_con = $num_con
             LIMIT $offset, $resul_x_pagina";
    $result = $mysqli->query($consulta);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }
    $paginacion->render();
    $i = 1;
    $hoy = new DateTime();
    $pago_habilitado = false;

    while ($row = mysqli_fetch_array($result)) {
        if ($row['estado_cuenta'] == 0) {
            $pago_cuenta = "PAGADA";
            $clase_cuenta = "text-green";
        } else {
            $pago_cuenta = "PENDIENTE";
            $clase_cuenta = "text-orange";
        }
        echo '
        <tr style="height:36px;">
        <td  data-label="CONT. No.">' . $row['num_con'] . '</td>
        <td data-label="FECHA PAGO">' . $row['fecha_pago'] . '</td>
        <td data-label="FECHA PAGO">' . $row['diferencia'] . '</td>
        <td data-label="ESTADO" class="' . $clase_cuenta . '">' . $pago_cuenta . '</td> ';
        if ($row['estado_cuenta'] == 1) {
            echo       '   <td data-label="EXCEL"><a ><img onclick="enviarPagoParcial(' . $row['id_pago'] . ', ' . $row['num_con']  . ' )" class="pago" src="../../img/pagar.png" width=28 height=28></a></td> ';
        } else {
            echo '   <td data-label="EXCEL"></td> ';
        }
    }
    echo '</table>
</div>';
    ?>
    <center>
        <br /><a href="receivables.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>
    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>
</body>

<script>
    function enviarPagoParcial(id_pago, num_con) {
        window.location.href = "makePartialPay.php?id_pago=" + id_pago + "&num_con=" + num_con;
    }
</script>

</html>
