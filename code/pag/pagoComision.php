<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
if (isset($_GET['id_pago'])) {
    $id_pago = $_GET['id_pago'];
    $num_con = $_GET['num_con'];
    $sql = "UPDATE pagos_realizados SET estado_comision = 1 WHERE id_pago = $id_pago";

    if ($mysqli->query($sql)) {
        // Redirigir de vuelta a la página original después de confirmar la comisión
        header("Location:showPendingPay1.php?num_con=$num_con");
        exit();
    } else {
        header("Location:access.php");
    }
} else {
    echo "ID de pago no proporcionado.";
}
