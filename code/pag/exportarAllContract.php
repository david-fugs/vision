<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');
$num_con = isset($_GET['num_con']) ? $_GET['num_con'] : '';

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

$sql = "SELECT * FROM pagos
WHERE num_con = $num_con";
// Ejecutar la consulta
$res = mysqli_query($mysqli, $sql);
// Verificar si la consulta se ejecutó correctamente
if ($res === false) {
    // Mostrar un mensaje de error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($mysqli);
    exit;
}

// Aplicar color de fondo a las celdas A1 a AL1
$sheet->getStyle('A2:S2')->applyFromArray([
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
$sheet->getStyle('A2:S2')->applyFromArray(['font' => $boldFontStyle]);

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
$sheet->getStyle('A2:S2')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

// Definir los encabezados de columna
$sheet->setCellValue('A1', 'NUM CONTRATO ' . $num_con);
$sheet->setCellValue('B1', 'DATOS GENERALES');
$sheet->setCellValue('K1', 'IMPUESTOS PROPIETARIO');
$sheet->setCellValue('O1', 'IMPUESTOS INMOBILIARIA');
$sheet->setCellValue('A2', 'MES');
$sheet->setCellValue('B2', 'RENTA');
$sheet->setCellValue('C2', 'CANON');
$sheet->setCellValue('D2', 'PAGADO A');
$sheet->setCellValue('E2', 'FACTURA ELECTRONICA');
$sheet->setCellValue('F2', 'FACTURA PROPIETARIO');
$sheet->setCellValue('G2', 'IVA');
$sheet->setCellValue('H2', 'COMISION APLICA A');
$sheet->setCellValue('I2', 'COMISION %');
$sheet->setCellValue('J2', 'ACUERDO');
$sheet->setCellValue('K2', 'RTE FUENTE');
$sheet->setCellValue('L2', 'RTE ICA');
$sheet->setCellValue('M2', 'RTE IVA');
$sheet->setCellValue('N2', 'IVA ');
$sheet->setCellValue('O2', 'RTE FUENTE');
$sheet->setCellValue('P2', 'RTE ICA');
$sheet->setCellValue('Q2', 'RTE IVA');
$sheet->setCellValue('R2', 'VALOR COMISION');
$sheet->setCellValue('S2', 'FECHA PAGO');

$sheet->mergeCells('B1:I1');
$sheet->mergeCells('K1:N1');
$sheet->mergeCells('O1:Q1');

$sheet->getStyle('B1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('O1:Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


// Ajustar el ancho de las columna

$sheet->getColumnDimension('A')->setWidth(35);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(25);
$sheet->getColumnDimension('E')->setWidth(25);
$sheet->getColumnDimension('F')->setWidth(25);
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
$sheet->getColumnDimension('T')->setWidth(25);
$sheet->getColumnDimension('U')->setWidth(25);
$sheet->getColumnDimension('V')->setWidth(25);

$sheet->getDefaultRowDimension()->setRowHeight(25);
$nombreEst = '';
$rowIndex = 3;
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    //print_r($row['comision_aplica_a']);
    $sheet->setCellValue('A' . $rowIndex, obtenerNombreDelMes($row['fecha_pago']));
    $sheet->setCellValue('B' . $rowIndex, $row['renta_con']);
    $sheet->setCellValue('C' . $rowIndex, $row['canon_con']);
    $sheet->setCellValue('D' . $rowIndex, $row['pagado_a']);
    $sheet->setCellValue('E' . $rowIndex, $row['factura_electronica0']);
    $sheet->setCellValue('F' . $rowIndex, $row['factura_electronica2']);
    $sheet->setCellValue('G' . $rowIndex, $row['iva_con']);
    $sheet->setCellValue('H' . $rowIndex, comisionAplica($row['comision_aplica_a']));
    $sheet->setCellValue('I' . $rowIndex, $row['comision1']);
    $sheet->setCellValue('J' . $rowIndex, $row['acuerdo']);
    $sheet->setCellValue('K' . $rowIndex, $row['rte_fte2']);
    $sheet->setCellValue('L' . $rowIndex, $row['rte_ica2']);
    $sheet->setCellValue('M' . $rowIndex, $row['rte_iva2']);
    $sheet->setCellValue('N' . $rowIndex, $row['iva_inmobi']);
    $sheet->setCellValue('O' . $rowIndex, $row['rte_fte4']);
    $sheet->setCellValue('P' . $rowIndex, $row['rte_ica4']);
    $sheet->setCellValue('Q' . $rowIndex, $row['rte_iva_inmobi']);
    $sheet->setCellValue('R' . $rowIndex, $row['comision_pago']);
    $sheet->setCellValue('S' . $rowIndex, $row['fecha_pago']);


      $sheet->getStyle('A' .$rowIndex. ':S'.$rowIndex.'')->applyFromArray(['font' => $boldFontStyle]);
     $rowIndex++;
}


$filename = 'Pagos Contrato '.$num_con. '.xlsx';
$writer = new Xlsx($spreadsheet);

// Set the headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output the generated Excel file to the browser
$writer->save('php://output');
exit;
