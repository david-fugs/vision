<?php
function prorratearPagos($num_con, $dias_prorrateo, $mysqli) {
    $query = "SELECT * FROM pagos WHERE num_con = $num_con ORDER BY fecha_pago ASC";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $new_payments = [];
        while ($row = $result->fetch_assoc()) {
            $fecha_pago = new DateTime($row['fecha_pago']);
            $fecha_pago->modify("+$dias_prorrateo days");
            $new_payments[] = [
                'id_pago' => $row['id_pago'],
                'fecha_prorrateada' => $fecha_pago->format('Y-m-d'),
                'canon_prorrateado' => ($row['canon_con'] / 30) * $dias_prorrateo // ejemplo simple
            ];
        }

        foreach ($new_payments as $payment) {
            $query = "INSERT INTO pagos_prorrateos (id_pago, fecha_prorrateada, canon_prorrateado) 
                      VALUES ({$payment['id_pago']}, '{$payment['fecha_prorrateada']}', {$payment['canon_prorrateado']})
                      ON DUPLICATE KEY UPDATE fecha_prorrateada = '{$payment['fecha_prorrateada']}', canon_prorrateado = {$payment['canon_prorrateado']}";
            $mysqli->query($query);
        }
    }
}
?>
