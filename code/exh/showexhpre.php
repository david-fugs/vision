<?php
session_start();

if(!isset($_SESSION['id_usu'])){
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

// Obtener los registros distintos desde la base de datos, incluyendo raz_soc_exh
$stmt = $mysqli->prepare("
    SELECT DISTINCT cod_fr_exh, direccion_inm_exh, nom_ape_inte_exh, cel_inte_exh, raz_soc_exh, fec_exh, nit_cc_exh, tel_inte_exh, email_inte_exh,nit_cc_ase
    FROM exhibiciones
    WHERE id_usu = ?
    ORDER BY id_exh ASC");
$stmt->bind_param('i', $_SESSION['id_usu']);
$stmt->execute();
$result = $stmt->get_result();


function nombreAsesor($nit_cc_ase) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT nom_ape_ase FROM asesores WHERE nit_cc_ase = ?");
    $stmt->bind_param('s', $nit_cc_ase);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['nom_ape_ase'];
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
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
</head>
<body>

    <center>
        <img src='../../img/logo.png' width="300" height="212" class="responsive">
    </center>

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-store"></i> PREREGISTROS </b>
    </h1>

    <div class="flex">
        <div class="box">
            <form action="showexh.php" method="get" class="form">
                <input name="cod_fr_exh" type="text" placeholder="Código Finca Raíz">
                <input name="direccion_inm_exh" type="text" placeholder="Dirección">
                <input name="nit_cc_ase" type="text" placeholder="Asesor">
                <input value="Realizar Busqueda" type="submit">
            </form>
        </div>
    </div>

    <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

date_default_timezone_set("America/Bogota");
include("../../conexion.php");
require_once("../../zebra.php");

@$cod_fr_exh        = ($_GET['cod_fr_exh']);
@$direccion_inm_exh = ($_GET['direccion_inm_exh']);
@$nit_cc_ase        = ($_GET['nit_cc_ase']);

// Consulta principal con DISTINCT incluyendo raz_soc_exh
$query = "SELECT DISTINCT cod_fr_exh, direccion_inm_exh, nom_ape_inte_exh, cel_inte_exh, raz_soc_exh, fec_exh, nit_cc_exh, tel_inte_exh, email_inte_exh,nit_cc_ase
          FROM exhibiciones
          WHERE direccion_inm_exh LIKE '%".$direccion_inm_exh."%'
          AND nit_cc_ase LIKE '%".$nit_cc_ase."%'
          AND cod_fr_exh LIKE '%".$cod_fr_exh."%'
          ORDER BY fec_exh DESC";
$res = $mysqli->query($query);
$num_registros = mysqli_num_rows($res);
$resul_x_pagina = 50;

echo "<div class='flex'>
        <div class='box'>
            <table class='table'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>FECHA</th>
                        <th>ASESOR </th>
                        <th>CODIGO FR</th>
                        <th>DIRECCION</th>
                        <th>INTERESAD@</th>
                        <th>RAZON SOCIAL</th>
                        <th>CEL</th>
                        <th>ADICIONAR</th>
                    </tr>
                </thead>
                <tbody>";

$paginacion = new Zebra_Pagination();
$paginacion->records($num_registros);
$paginacion->records_per_page($resul_x_pagina);

// Consulta principal con GROUP BY para eliminar duplicados
$consulta = "SELECT cod_fr_exh, direccion_inm_exh, nom_ape_inte_exh, cel_inte_exh, raz_soc_exh, fec_exh, nit_cc_exh, tel_inte_exh, email_inte_exh, nit_cc_ase
             FROM exhibiciones
             WHERE direccion_inm_exh LIKE '%".$direccion_inm_exh."%'
             AND nit_cc_ase LIKE '%".$nit_cc_ase."%'
             AND cod_fr_exh LIKE '%".$cod_fr_exh."%'
             AND visita_exh=1
             GROUP BY cod_fr_exh, direccion_inm_exh, nom_ape_inte_exh, raz_soc_exh, cel_inte_exh
             ORDER BY fec_exh DESC
             LIMIT " .(($paginacion->get_page() - 1) * $resul_x_pagina). "," .$resul_x_pagina;
$result = $mysqli->query($consulta);

function obtenerNumeroArchivos($cod_fr_exh) {
    $directorio = 'files/'.$cod_fr_exh.'/';

    if (file_exists($directorio)) {
        $num_archivos = count(glob($directorio . '*.*'));
        return max(0, $num_archivos);
    } else {
        return 0;
    }
}

$i = 1;
while($row = mysqli_fetch_array($result))
{
    $cod_fr_exh = $row['cod_fr_exh'];
    $nit_cc_exh = $row['nit_cc_exh'];
    $num_archivos = obtenerNumeroArchivos($cod_fr_exh);

    // Construye la ruta de la firma
    $signature_dir = 'files/signatures/' . $nit_cc_exh . '/';
    $signature_files = glob($signature_dir . '*.png');
    $signature_img = '';
    if ($signature_files) {
        $signature_img = '<img src="'.$signature_files[0].'" width="50" height="50">';
    }

    // Aplicar estilo a los tres primeros registros (los más recientes por fecha)
    if ($i <= 3) {
        $row_style = 'color: blue; font-weight: bold; font-size: larger;';
    } else {
        $row_style = ''; // Sin estilos especiales para el resto
    }

    echo '
<tr style="' . $row_style . '">
    <td data-label="No.">'.($i + (($paginacion->get_page() - 1) * $resul_x_pagina)).'</td>
    <td data-label="FECHA">'.$row['fec_exh'].'</td>
    <td data-label="ASESOR">'.nombreAsesor($row['nit_cc_ase']).'</td>
    <td data-label="CODIGO FR">'.$row['cod_fr_exh'].'</td>
    <td data-label="DIRECCION">'.$row['direccion_inm_exh'].'</td>
    <td data-label="INTERESAD@">'.$row['nom_ape_inte_exh'].'</td>
    <td data-label="RAZON SOCIAL">'.$row['raz_soc_exh'].'</td>
    <td data-label="CEL">'.$row['cel_inte_exh'].'</td>
    <td data-label="ADICIONAR">
        <a href="addexhpre.php?direccion_inm_exh='.urlencode($row['direccion_inm_exh']).'&nom_ape_inte_exh='.urlencode($row['nom_ape_inte_exh']).'&raz_soc_exh='.urlencode($row['raz_soc_exh']).'&nit_cc_exh='.urlencode($row['nit_cc_exh']).'&cel_inte_exh='.urlencode($row['cel_inte_exh']).'&tel_inte_exh='.urlencode($row['tel_inte_exh']).'&email_inte_exh='.urlencode($row['email_inte_exh']).'">
            <img src="../../img/add.png" width="20" height="20">
        </a>
    </td>
</tr>';

    $i++;
}


echo '        </table>
        </div>        ';

$paginacion->render();

?>

    </div>
    <center>
        <br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

</body>
</html>
