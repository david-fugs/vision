<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');
$num_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';
$id_pago = isset($_GET['id_pago']) ? $_GET['id_pago'] : '';


function getColumnLetter($index)
{
    $letter = '';
    while ($index >= 0) {
        $letter = chr($index % 26 + 65) . $letter;
        $index = floor($index / 26) - 1;
    }
    return $letter;
}
function Si1No2($value)
{
    if ($value == 1) {
        return "SI";
    } else {
        return "NO";
    }
}
function comisionAplica($value)
{
    if ($value == 1) {
        return "CANON";
    } else if ($value == 2) {
        return "RENTA";
    } else if ($value == 3) {
        return "CANON Y ADMINISTRACION";
    } else {
        return "NO APLICA";
    }
}
function obtenerNombreDelMes($fecha)
{
    setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para sistemas Windows

    // Crear un objeto DateTime a partir de la fecha
    $dateTime = new DateTime($fecha);

    // Obtener el nombre del mes en español
    return strftime('%B', $dateTime->getTimestamp());
}
function diferencia($renta_con, $valor_pagado)
{
    return $renta_con - $valor_pagado;
}
//Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sql = "SELECT pr.*,pii.ret_iva_valor_pii
        FROM pagos p
        INNER JOIN pagos_realizados pr ON p.id_pago = pr.id_pago
       INNER JOIN pagos_impuestos_inmobiliaria as pii ON p.id_pago = pii.id_pago
        WHERE p.num_con = '$num_con'";
// Ejecutar la consulta
$res = mysqli_query($mysqli, $sql);
// Verificar si la consulta se ejecutó correctamente
if ($res === false) {
    // Mostrar un mensaje de error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($mysqli);
    exit;
}


// Aplicar color de fondo a las celdas A1 a AL1
$sheet->getStyle('A2:N2')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'ffd880', // Cambia 'CCE5FF' al color deseado en formato RGB
        ],
    ],
]);

// Aplicar formato en negrita a las celdas con títulos
$boldFontStyle = [
    'bold' => true,
];
$sheet->getStyle('A2:N2')->applyFromArray(['font' => $boldFontStyle]);

// Establecer estilos para los encabezados
$styleHeader = [
    'font' => [
        'bold' => true,
        'size' => 20,
        'color' => ['rgb' => '333333'], // Color de texto (negro)
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F2F2F2'], // Color de fondo (gris claro)
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
];

// Aplicar el estilo a las celdas de encabezado
$sheet->getStyle('A2:N2')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

// Definir los encabezados de columna
$sheet->setCellValue('A1', 'NUM CONTRATO ' . $num_con);
$sheet->setCellValue('B1', 'DATOS GENERALES');
$sheet->setCellValue('J1', 'IMPUESTOS INMOBILIARIA');
$sheet->setCellValue('G1', 'IMPUESTOS PROPIETARIO');
$sheet->setCellValue('A2', 'FECHA DEL PAGO');
$sheet->setCellValue('B2', 'VALOR PAGADO');
$sheet->setCellValue('C2', 'COMISION DEL PAGO');
$sheet->setCellValue('D2', 'COMISION PENDIENTE');
$sheet->setCellValue('E2', 'DIFERENCIA');
$sheet->setCellValue('F2', 'GASTOS');
$sheet->setCellValue('G2', 'RTE FUENTE PROPIETARIO');
$sheet->setCellValue('H2', 'RTE ICA PROPIETARIO');
$sheet->setCellValue('I2', 'RTE IVA PROPIETARIO');
$sheet->setCellValue('J2', 'RTE FUENTE INMOBILIARIA');
$sheet->setCellValue('K2', 'RTE ICA INMOBILIARIA');
$sheet->setCellValue('L2', 'RTE IVA INMOBILIARIA');
$sheet->setCellValue('M2', 'PAGADO A');
$sheet->setCellValue('N2', 'PAGO COMISION');

$sheet->mergeCells('B1:F1');
$sheet->mergeCells('G1:I1');
$sheet->mergeCells('J1:L1');
$sheet->getStyle('B1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('O1:Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Ajustar el ancho de las columna

$sheet->getColumnDimension('A')->setWidth(35);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(25);
$sheet->getColumnDimension('E')->setWidth(25);
$sheet->getColumnDimension('F')->setWidth(50);
$sheet->getColumnDimension('G')->setWidth(25);
$sheet->getColumnDimension('H')->setWidth(25);
$sheet->getColumnDimension('I')->setWidth(25);
$sheet->getColumnDimension('J')->setWidth(25);
$sheet->getColumnDimension('K')->setWidth(25);
$sheet->getColumnDimension('L')->setWidth(25);
$sheet->getColumnDimension('M')->setWidth(18);
$sheet->getColumnDimension('N')->setWidth(25);
$sheet->getColumnDimension('O')->setWidth(25);
$sheet->getColumnDimension('P')->setWidth(25);
$sheet->getColumnDimension('Q')->setWidth(25);
$sheet->getColumnDimension('R')->setWidth(25);
$sheet->getColumnDimension('S')->setWidth(25);

$sheet->getDefaultRowDimension()->setRowHeight(25);
$nombreEst = '';
$rowIndex = 3;
// Inicializar las variables de suma
$totalValorPagado = 0;
$totalComisionPago = 0;
$totalComisionPendiente = 0;
$totalDiferencia = 0;
$totalAdecuaciones = 0;
$totalDeposito = 0;
$totalAfianzamiento = 0;
$totalRteFteProp = 0;
$totalRteIcaProp = 0;
$totalRteIvaProp = 0;
$totalRteFteInmobi = 0;
$totalRteIcaInmobi = 0;
$totalRteIvaInmobi = 0;
$totalGastosGenerales = 0;

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $sheet->setCellValue('A' . $rowIndex, $row['fecha_pago_realizado']);
    $sheet->setCellValue('B' . $rowIndex, $row['valor_pagado']);
    $sheet->setCellValue('C' . $rowIndex, $row['comision_pago']);
    $sheet->setCellValue('D' . $rowIndex, $row['comision_pendiente']);
    $sheet->setCellValue('E' . $rowIndex, $row['diferencia']);
    $sheet->setCellValue('F' . $rowIndex, $row['gastos']);
    $sheet->setCellValue('G' . $rowIndex, $row['rte_fte2_prop']);
    $sheet->setCellValue('H' . $rowIndex, $row['rte_ica2_prop']);
    $sheet->setCellValue('I' . $rowIndex, $row['rte_iva2_prop']);
    $sheet->setCellValue('J' . $rowIndex, $row['rte_fte4_inmobi']);
    $sheet->setCellValue('K' . $rowIndex, $row['rte_ica4_inmobi']);
    $sheet->setCellValue('L' . $rowIndex, $row['ret_iva_valor_pii']);
    $sheet->setCellValue('M' . $rowIndex, $row['pagado_a']);
    $sheet->setCellValue('N' . $rowIndex, Si1No2($row['pago_comision']));
      // Sumar los valores de cada columna
      $totalValorPagado += $row['valor_pagado'];
      $totalComisionPago += $row['comision_pago'];
      $totalComisionPendiente += $row['comision_pendiente'];
      $totalAfianzamiento += $row['afianzamiento'];
      $totalRteFteProp += $row['rte_fte2_prop'];
      $totalRteIcaProp += $row['rte_ica2_prop'];
      $totalRteIvaProp += $row['rte_iva2_prop'];
      $totalRteFteInmobi += $row['rte_fte4_inmobi'];
      $totalRteIcaInmobi += $row['rte_ica4_inmobi'];
      $totalRteIvaInmobi += $row['ret_iva_valor_pii'];

       // Extraer y sumar todos los valores de 'gastos'
    $pattern = '/:\s*\$(\d+)/';
    if (preg_match_all($pattern, $row['gastos'], $matches)) {
        foreach ($matches[1] as $valor) {
            $totalGastosGenerales += (int)$valor; // Sumar cada valor numérico extraído
        }
    }

    $sheet->getStyle('A' . $rowIndex . ':S' . $rowIndex . '')->applyFromArray(['font' => $boldFontStyle]);
    $rowIndex++;
}
// Colocar las sumas totales en la siguiente fila
$sheet->setCellValue('A' . $rowIndex, 'TOTAL');
$sheet->setCellValue('B' . $rowIndex, $totalValorPagado);
$sheet->setCellValue('C' . $rowIndex, $totalComisionPago);
$sheet->setCellValue('D' . $rowIndex, $totalComisionPendiente);
$sheet->setCellValue('E' . $rowIndex, $totalDiferencia);
$sheet->setCellValue('F' . $rowIndex, $totalGastosGenerales);
$sheet->setCellValue('G' . $rowIndex, $totalRteFteProp);
$sheet->setCellValue('H' . $rowIndex, $totalRteIcaProp);
$sheet->setCellValue('I' . $rowIndex, $totalRteIvaProp);
$sheet->setCellValue('J' . $rowIndex, $totalRteFteInmobi);
$sheet->setCellValue('K' . $rowIndex, $totalRteIcaInmobi);
$sheet->setCellValue('L' . $rowIndex, $totalRteIvaInmobi);
//Aplicar un estilo de negrita al total
$sheet->getStyle('A' . $rowIndex . ':N' . $rowIndex)->applyFromArray(['font' => $boldFontStyle]);

$filename = 'Pago  Contrato # ' . $num_con . '.xlsx';
$writer = new Xlsx($spreadsheet);

// Set the headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output the generated Excel file to the browser
$writer->save('php://output');
exit;
