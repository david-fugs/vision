<?php
session_start();

if(!isset($_SESSION['id_usu'])){
    header("Location: ../../index.php");
}

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];
function nombreAsesor($nit_cc_ase)
{
    include("../../conexion.php");
    $sql = "SELECT nom_ape_ase FROM asesores WHERE nit_cc_ase = '$nit_cc_ase'";
    $result = $mysqli->query($sql);
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

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-store"></i> CONSTANCIA DE EXHIBICIONES </b>
    </h1>

    <div class="flex">
        <div class="box">
            <form action="showFichaTec.php" method="get" class="form">
                <input name="cod_cap" type="text" placeholder="Código ">
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

$query = "SELECT * FROM capta_comercial ORDER BY fecha_alta_cap DESC";
$res = $mysqli->query($query);
$num_registros = mysqli_num_rows($res);
$resul_x_pagina = 50;

echo "<div class='flex'>
        <div class='box'>
            <table class='table'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>CODIGO </th>
                        <th>ASESOR</th>
                        <th>EXPORTAR</th>
                    </tr>
                </thead>
                <tbody>";

$paginacion = new Zebra_Pagination();
$paginacion->records($num_registros);
$paginacion->records_per_page($resul_x_pagina);

$consulta = "SELECT * FROM capta_comercial ORDER BY fecha_alta_cap DESC LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ", " . $resul_x_pagina;
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
    echo '
                <tr>
                    <td data-label="No.">'.($i + (($paginacion->get_page() - 1) * $resul_x_pagina)).'</td>
                    <td data-label="FECHA">'.$row['cod_cap'].'</td>
                    <td data-label="ASESOR">'.nombreAsesor($row['nit_cc_ase']).'</td>
                    <td data-label="EXPORTAR">
                        <a href="exportarFichaTec.php?id_cap='.$row['id_cap'].'" target="_blank"><img src="../../img/excel.png" width="32" height="32" title="Exportar a excel" /></a>
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
