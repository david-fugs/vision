<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
}
$id_pago = intval($_POST['id_pago']); // Asegurarse de que sea un entero

include("../../conexion.php");
<<<<<<< HEAD
$sql = "SELECT renta_con, canon_con,iva_con,comision_pago FROM pagos WHERE id_pago = $id_pago";
=======
$sql = "SELECT renta_con, canon_con,iva_con,comision_pago,rte_fte2,rte_fte4,rte_ica2,rte_ica4,rte_iva2,iva_inmobi,rte_iva_inmobi,total_consignar_pago FROM pagos WHERE id_pago = $id_pago";
>>>>>>> 6eb18556136cc709b4745375d188fcaf9436ff59
$result = mysqli_query($mysqli, $sql);
$renta_con = 1;
if ($result) {
    // Obtener la primera fila como un array asociativo
    $row = mysqli_fetch_assoc($result);
    // Acceder al valor de la columna deseada
    $renta_con = $row['renta_con'];
    $canon_con = $row['canon_con'];
    $iva_con = $row['iva_con'];
    $comision_pago = $row['comision_pago'];
<<<<<<< HEAD
=======
    $rte_fte2 = $row['rte_fte2'];
    $rte_fte4 = $row['rte_fte4'];
    $rte_ica2 = $row['rte_ica2'];
    $rte_ica4 = $row['rte_ica4'];
    $rte_iva2 = $row['rte_iva2'];
    $iva_inmobi = $row['iva_inmobi'];
    $rte_iva_inmobi = $row['rte_iva_inmobi'];
    $total_consignar_pago = $row['total_consignar_pago'];

>>>>>>> 6eb18556136cc709b4745375d188fcaf9436ff59
}

// Verificar que se recibieron los datos esperados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ipc = mysqli_real_escape_string($mysqli, $_POST['ipc']);
    $id_pago = intval($_POST['id_pago']); // Asegurarse de que sea un entero
    $num_con = mysqli_real_escape_string($mysqli, $_POST['num_con']);
    $num_pago = mysqli_real_escape_string($mysqli, $_POST['num_pago']);

    if($ipc != ""){
        $renta_ipc = $renta_con + ($renta_con * ($ipc/100));
        $canon_ipc = $canon_con + ($canon_con * ($ipc/100));
        $iva_ipc = $iva_con + ($iva_con * ($ipc/100));
        $comision_ipc = $comision_pago + ($comision_pago * ($ipc/100));
<<<<<<< HEAD
=======
        if($rte_fte2 != 0){
            $rte_fte2 = $rte_fte2 + ($rte_fte2 * ($ipc/100));
        }
        if($rte_fte4 != 0){
            $rte_fte4 = $rte_fte4 + ($rte_fte4 * ($ipc/100));
        }
        if($rte_ica2 != 0){
            $rte_ica2 = $rte_ica2 + ($rte_ica2 * ($ipc/100));
        }
        if($rte_ica4 != 0){
            $rte_ica4 = $rte_ica4 + ($rte_ica4 * ($ipc/100));
        }
        if($rte_iva2 != 0){
            $rte_iva2 = $rte_iva2 + ($rte_iva2 * ($ipc/100));
        }
        if($iva_inmobi != 0){
            $iva_inmobi = $iva_inmobi + ($iva_inmobi * ($ipc/100));
        }
        if($rte_iva_inmobi != 0){
            $rte_iva_inmobi = $rte_iva_inmobi + ($rte_iva_inmobi * ($ipc/100));
        }
        $total_consignar_pago = $total_consignar_pago + ($total_consignar_pago * ($ipc/100));

>>>>>>> 6eb18556136cc709b4745375d188fcaf9436ff59

    }

    // Preparar la consulta UPDATE
    if ($ipc != "") {
<<<<<<< HEAD
        $sql = "UPDATE pagos SET renta_con = $renta_ipc , canon_con = $canon_ipc , iva_con = $iva_ipc, comision_pago= $comision_ipc WHERE  num_pago > $num_pago";
=======
        $sql = "UPDATE pagos SET renta_con = $renta_ipc , canon_con = $canon_ipc , iva_con = $iva_ipc, comision_pago= $comision_ipc , rte_fte2 = $rte_fte2 , rte_fte4 = $rte_fte4 , rte_ica2 = $rte_ica2 , rte_ica4 = $rte_ica4 , rte_iva2 = $rte_iva2 , iva_inmobi = $iva_inmobi , rte_iva_inmobi = $rte_iva_inmobi , total_consignar_pago = $total_consignar_pago WHERE  num_pago > $num_pago";
>>>>>>> 6eb18556136cc709b4745375d188fcaf9436ff59
    }
    // Ejecutar la consulta
    if (mysqli_query($mysqli, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Registro actualizado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el registro: ' . mysqli_error($mysqli)]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}
// Cerrar la conexión
mysqli_close($mysqli);
