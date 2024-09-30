<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

$num_con = $_POST['num_con'];
$id_pago = $_POST['id_pago'];
$prorrateo_fecha = $_POST['prorrateo_fecha'];

$sql = "SELECT * FROM pagos WHERE num_con = '$num_con'";
$res_pago = $mysqli->query($sql);
$pagos = $res_pago->fetch_assoc();

// Convertir las fechas a objetos DateTime 
$fecha1 = new DateTime($pagos['fecha_pago']);
$fecha2 = new DateTime($prorrateo_fecha);

// Calcular la diferencia entre las dos fechas
$diferencia = $fecha1->diff($fecha2);

// Obtener el número de días de diferencia para calcular canon e impuestos
$dias_diferencia = $diferencia->days;
var_dump($dias_diferencia);

var_dump($prorrateo_fecha);


$canon_con = $pagos['canon_con'];
$iva_con = $pagos['iva_con'];
$admon_con = $pagos['admon_con'];
$canonConProrrateo = ($canon_con / 30) * $dias_diferencia;
$renta_con = $pagos['renta_con'];
$rte_fte2 = $pagos['rte_fte2'];
$rte_fte4 = $pagos['rte_fte4'];
$rte_ica2 = $pagos['rte_ica2'];
$rte_ica4 = $pagos['rte_ica4'];
$rte_iva2 = $pagos['rte_iva2'];
$iva_inmobi = $pagos['iva_inmobi'];
$rte_iva_inmobi = $pagos['rte_iva_inmobi'];
$comision_pago = $pagos['comision_pago'];
$total_consignar_pago = $pagos['total_consignar_pago'];


if ($canon_con > 0) $canonConProrrateo = ($canon_con / 30) * $dias_diferencia;
else $canonConProrrateo = 0;
if($iva_con > 0) $ivaConProrrateo = ($iva_con / 30) * $dias_diferencia;
else $ivaConProrrateo = 0;
if($admon_con > 0) $admonConProrrateo = ($admon_con / 30) * $dias_diferencia;
else $admonConProrrateo = 0;
if($renta_con > 0) $rentaConProrrateo = ($renta_con / 30) * $dias_diferencia;
else $rentaConProrrateo = 0;
if($rte_fte2 > 0) $rteFte2Prorrateo = ($rte_fte2 / 30) * $dias_diferencia;
else $rteFte2Prorrateo = 0;
if($rte_fte4 > 0) $rteFte4Prorrateo = ($rte_fte4 / 30) * $dias_diferencia;
else $rteFte4Prorrateo = 0;
if($rte_ica2 > 0) $rteIca2Prorrateo = ($rte_ica2 / 30) * $dias_diferencia;
else $rteIca2Prorrateo = 0;
if($rte_ica4 > 0) $rteIca4Prorrateo = ($rte_ica4 / 30) * $dias_diferencia;
else $rteIca4Prorrateo = 0;
if($iva_inmobi > 0) $ivaInmobiProrrateo = ($iva_inmobi / 30) * $dias_diferencia;
else $ivaInmobiProrrateo = 0;
if($rte_iva_inmobi > 0) $rteIvaInmobiProrrateo = ($rte_iva_inmobi / 30) * $dias_diferencia;
else $rteIvaInmobiProrrateo = 0;
if($comision_pago > 0) $comisionPagoProrrateo = ($comision_pago / 30) * $dias_diferencia;
else $comisionPagoProrrateo = 0;
if($total_consignar_pago > 0) $totalConsignarPagoProrrateo = ($total_consignar_pago / 30) * $dias_diferencia;
else $totalConsignarPagoProrrateo = 0;
if($rte_iva2 > 0) $rteIva2Prorrateo = ($rte_iva2 / 30) * $dias_diferencia;
else $rteIva2Prorrateo = 0;




//insertar la fecha insertada en prorrateo 
$sql_insert = "INSERT INTO pagos (
     num_con, fecha_pago, num_pago, pagado_a, pago_a_inmobiliaria, metodo_pago, 
    factura_electronica0, factura_electronica1, factura_electronica2, canon_con, iva_con, 
    admon_con, renta_con, comision_aplica_a, comision1, comision2, acuerdo, rte_fte1, 
    rte_fte2, rte_fte3, rte_fte4, rte_ica1, rte_ica2, rte_ica3, rte_ica4, rte_iva1, 
    rte_iva2, iva_aplica_inmobi, iva_inmobi, rte_iva_aplica_inmobi, rte_iva_inmobi, 
    cuenta_cobro, factura_colbodegas, comision_pago, total_consignar_pago, prorrateo, 
    dias_prorra, valor_prorra, estado_pago, fecha_alta_pago, id_usu_alta_pago, 
    fecha_edit_pago, id_usu
) VALUES (
     '{$pagos['num_con']}', '$prorrateo_fecha', '{$pagos['num_pago']}', 
    '{$pagos['pagado_a']}', '{$pagos['pago_a_inmobiliaria']}', '{$pagos['metodo_pago']}', 
    '{$pagos['factura_electronica0']}', '{$pagos['factura_electronica1']}', 
    '{$pagos['factura_electronica2']}', '{$canonConProrrateo}', '{ $ivaConProrrateo', 
    '{$admonConProrrateo}', '{$rentaConProrrateo}', '{$pagos['comision_aplica_a']}', 
    '{$pagos['comision1']}', '{$pagos['comision2']}', '{$pagos['acuerdo']}', 
    '{$pagos['rte_fte1']}', '{$rteFte2Prorrateo}', '{$pagos['rte_fte3']}', 
    '{$rteFte4Prorrateo}', '{$pagos['rte_ica1']}', '{$rteIca2Prorrateo}', 
    '{$pagos['rte_ica3']}', '{$rteIca4Prorrateo}', '{$pagos['rte_iva1']}', 
    '{$rteIva2Prorrateo}', '{$pagos['iva_aplica_inmobi']}', '{$ivaInmobiProrrateo}', 
    '{$pagos['rte_iva_aplica_inmobi']}', '{$rteIvaInmobiProrrateo}', 
    '{$pagos['cuenta_cobro']}', '{$pagos['factura_colbodegas']}', '{$comisionPagoProrrateo}', 
    '{$totalConsignarPagoProrrateo}', '{$pagos['prorrateo']}', '{$pagos['dias_prorra']}', 
    '{$pagos['valor_prorra']}', '{$pagos['estado_pago']}', '{$pagos['fecha_alta_pago']}', 
    '{$pagos['id_usu_alta_pago']}', '{$pagos['fecha_edit_pago']}', '{$pagos['id_usu']}'
)";

if ($mysqli->query($sql_insert) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
}


