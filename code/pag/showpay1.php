<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
}

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];

$nume_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';
function consultarPagosParciales($id_pago) {
    include("../../conexion.php");
    $query = "SELECT pagos_realizados.*, pagos.renta_con FROM pagos_realizados
              LEFT JOIN pagos ON pagos_realizados.id_pago = pagos.id_pago
              WHERE pagos_realizados.id_pago = $id_pago";
    $result = $mysqli->query($query);

    // Verificar si hay un resultado
    if ($result && $result->num_rows > 0) {
        // Devolver la primera fila como un array asociativo
        return $result->fetch_assoc();
    } else {
        // Devolver un array vacío si no hay resultados
        return [];
    }
}
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
            color: green;
        }

        .text-orange {
            background-color: orange;
            color: white;
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
    <div>
        <h3 style="color: #3e1913; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 30px; text-align: center;"><b>IMPRIMIR DETALLES DEL CONTRATO</b></h3>
        <a class="ml-4" href="exportarAllContract.php?num_con=<?= urlencode($nume_con) ?>"> <img src='../../img/excel.png' width="75" height="80" title="Regresar" />
<br><br>
    </div>

    <h3 style="color: #3e1913; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 30px; text-align: center;"><b>VOLVER O IMPRIMIR PAGOS DEL CONTRATO</b></h3><br>
    <div class="excelAtras">

        <a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
        <a class="ml-4" href="exportarAllPays.php?num_con=<?= urlencode($nume_con) ?>"> <img src='../../img/excel.png' width="75" height="80" title="Regresar" />
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

    $query = "SELECT pagos.*, contratos.*, inmuebles.*,
                 COALESCE(prorrateos.fecha_prorrateada, pagos.fecha_pago) AS fecha_pago_mostrar,
                 COALESCE(prorrateos.canon_prorrateado, pagos.canon_con) AS canon_mostrar,
                 (SELECT SUM(valor_pagado) FROM pagos_realizados WHERE id_pago = pagos.id_pago) AS total_pagado
          FROM contratos
          INNER JOIN pagos ON contratos.num_con = pagos.num_con
          INNER JOIN inmuebles ON contratos.mat_inm = inmuebles.mat_inm
          LEFT JOIN pagos_prorrateos prorrateos ON pagos.id_pago = prorrateos.id_pago
          WHERE (contratos.num_con LIKE '%$num_con%')
          AND (pagos.id_pago LIKE '%$id_pago%')
          ORDER BY fecha_pago_mostrar ASC, pagos.id_pago ASC";

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
                        <th>PAGO No.</th>
                        <th>CONT. No.</th>
                        <th>FECHA PAGO</th>
                        <th>PROPIETARIO</th>
                        <th>ESTADO</th>
                        <th>PAGO TOTAL</th>
                        <th>PAGO PARCIAL</th>
                        <th>PRORRATEO</th>
                        <th>EXCEL</th>
                    </tr>
                </thead>
                <tbody>";

    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);

    $consulta = "SELECT pagos.*, contratos.*, inmuebles.*,
                    COALESCE(prorrateos.fecha_prorrateada, pagos.fecha_pago) AS fecha_pago_mostrar,
                    COALESCE(prorrateos.canon_prorrateado, pagos.canon_con) AS canon_mostrar,
                    (SELECT SUM(valor_pagado) FROM pagos_realizados WHERE id_pago = pagos.id_pago) AS total_pagado
             FROM contratos
             INNER JOIN pagos ON contratos.num_con = pagos.num_con
             INNER JOIN inmuebles ON contratos.mat_inm = inmuebles.mat_inm
             LEFT JOIN pagos_prorrateos prorrateos ON pagos.id_pago = prorrateos.id_pago
             WHERE (contratos.num_con LIKE '%$num_con%')
             AND (contratos.mat_inm LIKE '%$mat_inm%')
             ORDER BY fecha_pago_mostrar ASC, pagos.id_pago ASC
             LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", $resul_x_pagina";

    $result = $mysqli->query($consulta);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $paginacion->render();
    $i = 1;
    $hoy = new DateTime();
    $pago_habilitado = false;

    while ($row = mysqli_fetch_array($result)) {
        // Formatear los valores como moneda
        $canon_con = '$' . number_format($row['canon_mostrar'], 0, ',', '.');
        $admon_con = '$' . number_format($row['admon_con'], 0, ',', '.');
        $iva_con = '$' . number_format($row['iva_con'], 0, ',', '.');
        $renta_con = '$' . number_format($row['renta_con'], 0, ',', '.');
        $comision_pago = '$' . number_format($row['comision_pago'], 0, ',', '.');
        $total_consignar_pago = '$' . number_format($row['total_consignar_pago'], 0, ',', '.');
        $total_pagado = $row['total_pagado'] ? '$' . number_format($row['total_pagado'], 0, ',', '.') : '$0';

        // Calcular el estado del pago
        $estado_pago = "";
        $clase_estado = "";
        $prorrateo = '<td data-label="PRORRATEO"><a href="dias_prorrateo.php?num_con=' . $row['num_con'] . '&dias=8&id_pago=' . $row['id_pago'] . '"><img src="../../img/prorrateo.png" width=28 height=28></a></td>';
        $pago_parcial_hecho = "";
        $pagos_parciales =consultarPagosParciales($row['id_pago']);
        if ($row['canon_mostrar'] <= $row['total_pagado'] && $pagos_parciales['valor_pagado'] >= $pagos_parciales['renta_con'] ) {
            $estado_pago = "Pago al día";
            $clase_estado = "bg-green";
            $pago_total = '<td data-label="PAGO TOTAL"><span class="text-muted">N/A</span></td>';
            $pago_parcial = '<td data-label="PAGO PARCIAL"><span class="text-muted">N/A</span></td>';
            $prorrateo = '<td data-label="PRORRATEO"><span class="text-muted">N/A</span></td>';
        } else {
            $estado_pago = "Pago al día";
            $fecha_pago = new DateTime($row['fecha_pago_mostrar']);
            $diferencia = $fecha_pago->diff($hoy)->days;

            if ($fecha_pago > $hoy) {
                $estado_pago = "Faltan $diferencia días";
                $clase_estado = "text-blue";
            } else {
                $pago_parcial_hecho = "";
                if($pagos_parciales['valor_pagado'] >= $pagos_parciales['renta_con']){
                    $estado_pago = "Pago vencido";
                    $clase_estado = "bg-red";
                }
                else{
                    $estado_pago = "Pago parcial";
                    $clase_estado = "text-orange";
                    $pago_total = '<td data-label="PAGO TOTAL"><span class="text-muted">N/A</span></td>';
                    $pago_parcial_hecho = 1;
                    $pago_habilitado = true;
                }

            }

            if (!$pago_habilitado) {
                $pago_total = '<td data-label="PAGO TOTAL"><a href="../pag/makepay2.php?id_pago=' . $row['id_pago'] . '"><img src="../../img/pagar.png" width=28 height=28></a></td>';
                $pago_parcial = '<td data-label="PAGO PARCIAL"><a href="../pag/makePartialPay.php?id_pago=' . $row['id_pago'] . '"><img src="../../img/credito.png" width=28 height=28></a></td>';
                $pago_habilitado = true;
            } else {
                $pago_total = '<td data-label="PAGO TOTAL"><span class="text-muted">N/A</span></td>';
                $pago_parcial = '<td data-label="PAGO PARCIAL"><span class="text-muted">N/A</span></td>';
            }

            if($pago_parcial_hecho == 1){
                $pago_parcial = '<td data-label="PAGO PARCIAL"><a href="../pag/makePartialPay.php?id_pago=' . $row['id_pago'] . '"><img src="../../img/credito.png" width=28 height=28></a></td>';
            }
        }

        echo '
        <tr>
        <td data-label="PAGO No.">' . $row['num_pago'] . '</td>
        <td data-label="CONT. No.">' . $row['num_con'] . '</td>
        <td data-label="FECHA PAGO">' . $row['fecha_pago_mostrar'] . '</td>
        <td data-label="PROPIETARIO"><strong>' . $total_consignar_pago . '</strong></td>
        <td data-label="ESTADO" class="' . $clase_estado . '">' . $estado_pago . '</td>
        ' . $pago_total . '
        ' . $pago_parcial . '
        ' . $prorrateo . '
        ';
        if($estado_pago == "Pago al día"){
            echo '<td data-label="EXCEL"><a href="exportarIndPays.php?num_con=' . $row['num_con'] . '&id_pago=' . $row['id_pago'] . '&nit_cc_arr=' . $row['nit_cc_arr'] . '"><img src="../../img/excel.png" width=28 height=28></a></td>';}
        else{
            echo '<td data-label="EXCEL"><span class="text-muted">Aun sin pagar</span></td>';
        }
    }

    echo '</table>
</div>';
    ?>
    <center>
        <br /><a href="showpay.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>
    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

</body>

</html>
