<?php
session_start();

// Mostrar errores de PHP
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

// Preparar y ejecutar la consulta para obtener los registros con los datos necesarios
$stmt = $mysqli->prepare("
    SELECT c.id_cap, c.area_total_cap, d.nom_dep, m.nom_mun, c.estrato_cap, c.posición_cap, 
           c.cel_repre_legal_cap, c.renta_total_cap
    FROM capta_comercial c
    LEFT JOIN departamentos d ON c.cod_dane_dep = d.cod_dane_dep
    LEFT JOIN municipios m ON c.id_mun = m.id_mun
    WHERE c.id_usu = ?
    ORDER BY c.id_cap ASC");

// Enlazar el parámetro y ejecutar la consulta
$stmt->bind_param('i', $_SESSION['id_usu']);
$stmt->execute();
$result = $stmt->get_result();
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
    
    <style>
        table {
            width: 100%; /* Ajustar la tabla para que ocupe todo el ancho disponible */
            border-collapse: collapse; /* Eliminar espacios entre celdas */
            table-layout: fixed; /* Establecer un layout fijo para que las celdas tengan el mismo ancho */
        }

        th, td {
            padding: 10px; /* Añadir relleno a las celdas */
            text-align: left; /* Alinear el texto a la izquierda */
            border: 1px solid #dddddd; /* Añadir un borde ligero */
            overflow-wrap: break-word; /* Forzar que las palabras largas se dividan en varias líneas */
        }

        /* Ajustar el ancho de las columnas según sea necesario */
        th:nth-child(1), td:nth-child(1) { width: 5%; } /* Columna No. */
        th:nth-child(2), td:nth-child(2) { width: 10%; } /* Columna FECHA */
        th:nth-child(3), td:nth-child(3) { width: 10%; } /* Columna ÁREA */
        th:nth-child(4), td:nth-child(4) { width: 10%; } /* Columna DEPART. */
        th:nth-child(5), td:nth-child(5) { width: 10%; } /* Columna MUNIC. */
        th:nth-child(6), td:nth-child(6) { width: 10%; } /* Columna CANON */
        th:nth-child(7), td:nth-child(7) { width: 10%; } /* Columna ADMIN */
        th:nth-child(8), td:nth-child(8) { width: 10%; } /* Columna RENTA */
        th:nth-child(9), td:nth-child(9) { width: 15%; } /* Columna RAZON SOCIAL */
        th:nth-child(10), td:nth-child(10) { width: 10%; } /* Columna CELULAR */
        th:nth-child(11), td:nth-child(11) { width: 10%; } /* Columna ADICIONAR */
    </style>
</head>

<body>

    <div class="container">
        <img src='../../img/logo.png' width="80" height="56" class="responsive"><h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><strong><i class="fa-solid fa-building-circle-check"></i> PREREGISTRO CAPTACIÓN DE INMUEBLE COMERCIAL</strong></h1>

    <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

date_default_timezone_set("America/Bogota");
require_once("../../zebra.php");

// Contar el número total de registros
$num_registros = $result->num_rows;
$resul_x_pagina = 50;

echo "<div class='flex'>
        <div class='box'>
            <table class='table'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>FECHA</th>
                        <th>ÁREA</th>
                        <th>MUNI.</th>
                        <th>CANON</th>
                        <th>IVA</th>
                        <th>ADMIN</th>
                        <th>RENTA</th>
                        <th>RAZON SOCIAL</th>
                        <th>CELULAR</th>
                        <th>ADICIONAR</th>
                    </tr>
                </thead>
                <tbody>";

$paginacion = new Zebra_Pagination();
$paginacion->records($num_registros);
$paginacion->records_per_page($resul_x_pagina);

// Reajustar la consulta con límite para la paginación
$stmt = $mysqli->prepare("
    SELECT c.id_cap, c.area_total_cap, d.nom_dep, m.nom_mun, c.estrato_cap, c.valor_iva_cap, 
           c.cel_repre_legal_cap, c.canon_neto_cap, c.admon_cap, c.renta_total_cap, c.nombre_razon_social_cap, c.cel_repre_legal_cap, c.renta_total_cap, c.fecha_alta_cap
    FROM capta_comercial c
    LEFT JOIN departamentos d ON c.cod_dane_dep = d.cod_dane_dep
    LEFT JOIN municipios m ON c.id_mun = m.id_mun
    WHERE c.id_usu = ?
    ORDER BY c.fecha_alta_cap DESC
    LIMIT ?, ?");
$page_offset = ($paginacion->get_page() - 1) * $resul_x_pagina;
$stmt->bind_param('iii', $_SESSION['id_usu'], $page_offset, $resul_x_pagina);
$stmt->execute();
$result = $stmt->get_result();

$i = 1;
while ($row = mysqli_fetch_array($result)) {
    $nit_cc_exh = $row['cel_repre_legal_cap'];

    // Aplicar estilo a los tres primeros registros (los más recientes por fecha)
    if ($i <= 3) {
        $row_style = 'color: #5096f2; font-weight: bold; font-size: larger;';
    } else {
        $row_style = ''; // Sin estilos especiales para el resto
    }

    echo '
<tr style="' . $row_style . '">
    <td data-label="No.">' . ($i + (($paginacion->get_page() - 1) * $resul_x_pagina)) . '</td>
    <td data-label="FECHA">' . $row['fecha_alta_cap'] . '</td>
    <td data-label="ÁREA">' . $row['area_total_cap'] . '</td>
    <td data-label="MUNI.">' . $row['nom_mun'] . '</td>
    <td data-label="CANON">' . '$' . number_format($row['canon_neto_cap'], 0, ',', '.') . '</td>
    <td data-label="IVA">' . '$' . number_format($row['valor_iva_cap'], 0, ',', '.') . '</td>
    <td data-label="ADMIN">' . '$' . number_format($row['admon_cap'], 0, ',', '.') . '</td>
    <td data-label="RENTA">' . '$' . number_format($row['renta_total_cap'], 0, ',', '.') . '</td>
    <td data-label="RAZON SOCIAL">' . $row['nombre_razon_social_cap'] . '</td>
    <td data-label="CELULAR">' . $row['cel_repre_legal_cap'] . '</td>
    <td data-label="EDITAR">
        <a href="addcap3.php?id_cap=' . $row['id_cap'] . '"><img src="../../img/add.png" width=28 height=28></a></td>
    </td>
</tr>';

    $i++;
}


echo '</tbody></table></div>';

$paginacion->render();
?>

    </div>
    <center>
        <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

</body>
</html>
