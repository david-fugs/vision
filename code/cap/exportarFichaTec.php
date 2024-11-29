<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
include("../../conexion.php");
date_default_timezone_set("America/Bogota");
$mysqli->set_charset('utf8');
$id_cap = isset($_GET['id_cap']) ? $_GET['id_cap'] : '';

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
function obtenerNombreDelMes($fecha)
{
    setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para sistemas Windows

    // Crear un objeto DateTime a partir de la fecha
    $dateTime = new DateTime($fecha);

    // Obtener el nombre del mes en español
    return strftime('%B', $dateTime->getTimestamp());
}

//Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sql = "SELECT * FROM capta_comercial WHERE id_cap = '$id_cap'";
// Ejecutar la consulta
$res = mysqli_query($mysqli, $sql);
// Verificar si la consulta se ejecutó correctamente
if ($res === false) {
    // Mostrar un mensaje de error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($mysqli);
    exit;
}

// Aplicar color de fondo a las celdas A1 a AL1
$sheet->getStyle('A2:O2')->applyFromArray([
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
$sheet->getStyle('A2:O2')->applyFromArray(['font' => $boldFontStyle]);

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
$sheet->getStyle('A2:O2')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

// Definir los encabezados de columna
// $sheet->setCellValue('A1', 'NUM CONTRATO ' . $num_con);
$sheet->setCellValue('B2', 'CODIGO');
$sheet->setCellValue('B3', 'DISPONIBILIDAD');
$sheet->setCellValue('B5', 'MEDIDAS:');
$sheet->setCellValue('B6', 'AREA TOTAL');
$sheet->setCellValue('B7', 'AREA LOTE');
$sheet->setCellValue('B8', 'AREA PISO 1 CONTRUIDO');
$sheet->setCellValue('B9', 'AREA PISO 2 CONTRUIDO');
$sheet->setCellValue('B10', 'HABITACIONES');
$sheet->setCellValue('B11', 'FRENTE X FON HABITAC 1');
$sheet->setCellValue('B12', 'FRENTE X FON HABITAC 2');
$sheet->setCellValue('B13', 'FRENTE X FON HABITAC 3');
$sheet->setCellValue('B14', 'FRENTE X SALA PRINCIPAL');
$sheet->setCellValue('B15', 'VESTIDORES');
$sheet->setCellValue('B16', 'CLOSETS');
$sheet->setCellValue('B17', 'SALAS');
$sheet->setCellValue('B18', 'MIRADORES');
$sheet->setCellValue('B19', 'BALCON');
$sheet->setCellValue('B20', 'TERRAZA');
$sheet->setCellValue('B21', 'PATIO');   
$sheet->setCellValue('B22', 'SOTANO');
$sheet->setCellValue('B23', 'OTROS PISOS');
$sheet->setCellValue('B24', 'COCINA');
$sheet->setCellValue('B25', 'TIPO COCINA INTEGRAL');
$sheet->setCellValue('B26', 'ISLA AUX DE COCINA');
$sheet->setCellValue('B27', 'LAVAPLATOS');
$sheet->setCellValue('B28', 'ESPACIO NEVECON');

$sheet->setCellValue('E2', 'TIPO INMUEBLE');
$sheet->setCellValue('E3', 'ESTRATO');
$sheet->setCellValue('E4', 'UBICACION');
$sheet->setCellValue('E5', 'DEPARTAMENTO');
$sheet->setCellValue('E6', 'CIUDAD');
$sheet->setCellValue('E7', 'BARRIO');
$sheet->setCellValue('E8', 'UBICACION GPS');
$sheet->setCellValue('E9', 'ESTRATO');
$sheet->setCellValue('E10', 'POSICION');
$sheet->setCellValue('E11', 'CONJ/TO CERRADO');
$sheet->setCellValue('E12', 'CONJ/TO VIGILADO');
$sheet->setCellValue('E13', 'PORTERIA');
$sheet->setCellValue('E14', 'CITOFONIA');
$sheet->setCellValue('E15', 'GENERALES:');
$sheet->setCellValue('E16', 'EDAD');
$sheet->setCellValue('E17', 'ESTADO');
$sheet->setCellValue('E18', 'NIVEL INTERNO');
$sheet->setCellValue('E19', 'TIPO');
$sheet->setCellValue('E20', 'ESQUIN/MEDIAN');
$sheet->setCellValue('E21', 'OFICINAS');
$sheet->setCellValue('E22', 'DUCHAS');
$sheet->setCellValue('E23', 'LAVAMANOS');
$sheet->setCellValue('E24', 'SANITARIOS');
$sheet->setCellValue('E25', 'POCETA');
$sheet->setCellValue('E26', 'COCINETA');
$sheet->setCellValue('E27', 'TINAS');
$sheet->setCellValue('E28', 'TRANSPORTE PUBLICO');

$sheet->setCellValue('H2', 'SERVI PUB.');
$sheet->setCellValue('H3', 'ENERGIA $KV A FECHA');
$sheet->setCellValue('H4', 'AGUA $ X M3 A FECHA');
$sheet->setCellValue('H5', 'EMPRESA ENERGIA');
$sheet->setCellValue('H6', 'KVA TRANSFORMADOR');
$sheet->setCellValue('H7', 'CALIBRE ACOMETIDA');
$sheet->setCellValue('H8', 'TOMAS 220');
$sheet->setCellValue('H9', 'REDES INDEP. DAT/ENER');
$sheet->setCellValue('H10', 'PLANTA ELECTRICA');
$sheet->setCellValue('H11', 'EMPRESA AGUA');
$sheet->setCellValue('H12', 'TANQUES AGUA RESERVA');
$sheet->setCellValue('H13', 'HIDRANTE');
$sheet->setCellValue('H14', 'GABINETE CON. INCENDIO');
$sheet->setCellValue('H15', 'RED CONTRA INCENDIO');
$sheet->setCellValue('H16', 'GAS');
$sheet->setCellValue('H17', 'AGUA CALIENTE');
$sheet->setCellValue('H18', 'INTERNET Y TELEFONIA');
$sheet->setCellValue('H19', 'COMERCIO CERCANO');
$sheet->setCellValue('H20', 'RESTAURANTES');
$sheet->setCellValue('H21', 'SUPERMERCADOS');
$sheet->setCellValue('H22', 'DROGUERIAS');
$sheet->setCellValue('H23', 'CENTROS COMERCIALES');
$sheet->setCellValue('H24', 'UNIVERSIDADES');
$sheet->setCellValue('H25', 'COLEGIOS');
$sheet->setCellValue('H26', 'JARDINES INFANTILES');
$sheet->setCellValue('H27', 'OTROS: ');

$sheet->setCellValue('K2', 'JUEGOS');
$sheet->setCellValue('K3', 'AIRE ACONDICIONADO');
$sheet->setCellValue('K4', 'JARDINES');
$sheet->setCellValue('K5', 'TURCO');
$sheet->setCellValue('K6', 'JACUZZY');
$sheet->setCellValue('K7', 'SAUNA');
$sheet->setCellValue('K8', 'CANCHA TENIS');
$sheet->setCellValue('K9', 'CANCHA FUTBOL');
$sheet->setCellValue('K10', 'CANCHA MICRO FUTB');
$sheet->setCellValue('K11', 'CANCHA BALONCESTO');
$sheet->setCellValue('K12', 'PISCINA ADULTOS');
$sheet->setCellValue('K13', 'PISCINA NIÑOS');
$sheet->setCellValue('K14', 'SENDERO ECOLOGICO');
$sheet->setCellValue('K15', 'PERMITEN MASCOTAS');
$sheet->setCellValue('K16', 'ZONA MASCOTAS');
$sheet->setCellValue('K17', 'GIMNASIO');
$sheet->setCellValue('K18', 'ASCENSOR');
$sheet->setCellValue('K19', 'JUEGOS NIÑOS');
$sheet->setCellValue('K20', 'LAGO PESCA');
$sheet->setCellValue('K21', 'CANCHA SQUASH');
$sheet->setCellValue('K22', 'OTROS:');
$sheet->setCellValue('K23', 'ACABADOS');
$sheet->setCellValue('K24', 'PISOS');
$sheet->setCellValue('K25', 'MUROS');
$sheet->setCellValue('K26', 'MATERIAL MURO %');
$sheet->setCellValue('K27', 'TIPO TECHO');
$sheet->setCellValue('K28', 'MATERIAL TECHO ');


// $sheet->mergeCells('B1:F1');
// $sheet->mergeCells('G1:J1');
// $sheet->mergeCells('K1:M1');
$sheet->getStyle('B1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
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
$sheet->getColumnDimension('T')->setWidth(25);
$sheet->getColumnDimension('U')->setWidth(25);
$sheet->getColumnDimension('V')->setWidth(25);

$sheet->getDefaultRowDimension()->setRowHeight(25);
$nombreEst = '';
$rowIndex = 3;
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    // print_r($row);
     $sheet->setCellValue('C6', $row['area_total_cap']);
    //  $sheet->setCellValue('C7', $row['area_lote_cap']);
    $sheet->setCellValue('C8', $row['area_piso1_cap']);
    $sheet->setCellValue('C9', $row['area_piso2_cap']);
    $sheet->setCellValue('C11', $row['habitaciones_cap']);

    
      $rowIndex++;
}
$filename = 'Pago  Contrato #.xlsx';
$writer = new Xlsx($spreadsheet);

// Set the headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output the generated Excel file to the browser
$writer->save('php://output');
exit;
