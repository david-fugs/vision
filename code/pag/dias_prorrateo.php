<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
include("functions.php");

$num_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';
$dias_prorrateo = isset($_GET['dias']) ? (int)$_GET['dias'] : 0;

if ($num_con && $dias_prorrateo > 0) {
    prorratearPagos($num_con, $dias_prorrateo, $mysqli);
    header("Location: showpay1.php?num_con=$num_con");
    exit();
} else {
    echo "Parámetros inválidos.";
}
?>
