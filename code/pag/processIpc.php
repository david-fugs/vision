<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
}
$id_pago = intval($_POST['id_pago']); // Asegurarse de que sea un entero

include("../../conexion.php");
$sql = "SELECT renta_con, canon_con,iva_con,comision_pago FROM pagos WHERE id_pago = $id_pago";
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

    }

    // Preparar la consulta UPDATE
    if ($ipc != "") {
        $sql = "UPDATE pagos SET renta_con = $renta_ipc , canon_con = $canon_ipc , iva_con = $iva_ipc, comision_pago= $comision_ipc WHERE  num_pago > $num_pago";
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
