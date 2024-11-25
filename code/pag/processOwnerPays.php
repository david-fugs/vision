<?php
switch ($_GET["action"]) {
    case 'editaPago':
        include("../../conexion.php");
        $id_pago_propietario = $_GET['id_pago_propietario'];
        $monto = $_GET['pago_anterior'];

        $sql_update = "UPDATE pagos_propietarios SET monto = '$monto' WHERE id_pago_propietario = '$id_pago_propietario'";
        mysqli_query($mysqli, $sql_update);
        break;

    case 'eliminarPago':
        include("../../conexion.php");
        $id_pago_propietario = $_GET['id_pago_propietario'];
        $sql_delete = "DELETE FROM pagos_propietarios WHERE id_pago_propietario = '$id_pago_propietario'";
        mysqli_query($mysqli, $sql_delete);
        break;
}
