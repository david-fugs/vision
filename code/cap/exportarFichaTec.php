<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

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


// Rango de celdas para bordes
$range = 'B2:C28';
$range2 = 'E2:F28';
$range3 = 'H2:I28';
$range4 = 'K2:L28';
$range5 = 'N2:O28';
$range6 = 'Q2:R25';

// Estilo de bordes
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN, // Bordes delgados
            'color' => ['argb' => Color::COLOR_BLACK], // Color negro
        ],
    ],
];
// Aplicar el estilo de bordes al rango
$sheet->getStyle($range)->applyFromArray($styleArray);
$sheet->getStyle($range2)->applyFromArray($styleArray);
$sheet->getStyle($range3)->applyFromArray($styleArray);
$sheet->getStyle($range4)->applyFromArray($styleArray);
$sheet->getStyle($range5)->applyFromArray($styleArray);
$sheet->getStyle($range6)->applyFromArray($styleArray);

$sql = "SELECT * FROM capta_comercial WHERE id_cap = '$id_cap'";
// Ejecutar la consulta
$res = mysqli_query($mysqli, $sql);
// Verificar si la consulta se ejecutó correctamente
if ($res === false) {
    // Mostrar un mensaje de error si la consulta falla
    echo "Error en la consulta: " . mysqli_error($mysqli);
    exit;
}
function asesorCaracteristicas($nit_cc_ase, $campo){
    include("../../conexion.php");
    $sql = "SELECT * FROM asesores WHERE nit_cc_ase = '$nit_cc_ase'";
    $res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    if($campo == 'nombre'){
        return $row['nom_ape_ase'];
    }
    if($campo == 'celular'){
        return $row['tel1_ase'];
    }
    if($campo == 'email'){
        return $row['email_ase'];
    }

}

// // Aplicar color de fondo a las celdas A1 a AL1
// $sheet->getStyle('B2')->applyFromArray([
//     'fill' => [
//         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//         'startColor' => [
//             'rgb' => 'ffd880', // Cambia 'CCE5FF' al color deseado en formato RGB
//         ],
//     ],
// ]);

$cellStyle = [
    'fill' => [
        'fillType' =>  \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FFD880', // Cambia al color deseado
        ],
    ],
];
// Aplicar formato en negrita a las celdas con títulos
$boldFontStyle = [
    'bold' => true,
];

// Define las celdas a las que quieres aplicar el estilo
$cells = ['B2', 'E2', 'H2', 'K2', 'N2', 'Q2','B5','B10','B18','B24','E4','E15','H19','K23','N12','N20','Q19'];

// Aplica el estilo a cada celda
foreach ($cells as $cell) {
    $sheet->getStyle($cell)->applyFromArray($cellStyle);
    $sheet->getStyle($cell)->applyFromArray(['font' => $boldFontStyle]);
}



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
$sheet->getStyle('B2:O2')->applyFromArray(['font' => $styleHeader, 'fill' => $styleHeader, 'alignment' => $styleHeader]);

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
$sheet->setCellValue('B34', 'Yo _____________________________________________, Propietario (  ), Apoderado (  ) doy fe que la información  aquí plasmada es verídica y que me comprometo a pagar a la agencia  inmobiliaria por su gestión en caso de conseguir arrendatario el __________% de la renta por concepto  de ________________, ó ____% sobre el valor en caso de venta.');
$sheet->getStyle('B34')->getAlignment()->setWrapText(true);
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
$sheet->setCellValue('H34', 'VISION INMOBILIARIA DE COLOMBIA / COLBODEGAS.COM / RAICES M&M  WWW.COLBODEGAS.COM / COLBODEGAS@GMAIL.COM
    (57/6) 325 2655 / (57) 311 765 6036 / (57) 312 876 5040  CL 24 # 7-29 OF 606 EL LAGO  PEREIRA COLOMBIA');
$sheet->getStyle('H34')->getAlignment()->setWrapText(true);
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

$sheet->setCellValue('N2', 'VALORES:');
$sheet->setCellValue('N3', 'VENTA NETA');
$sheet->setCellValue('N4', 'VENTA $ M2');
$sheet->setCellValue('N5', 'RENTA CANON NETO');
$sheet->setCellValue('N6', 'RENTA CANON $ M2');
$sheet->setCellValue('N7', '% IVA');
$sheet->setCellValue('N8', '$ IVA');
$sheet->setCellValue('N9', 'MAS ADMINISTRACION');
$sheet->setCellValue('N10', 'RENTA TOTAL');
 $sheet->setCellValue('N11', 'RETEFUENTE');

$sheet->setCellValue('N12', 'ACCESO VEHICULAR');
$sheet->setCellValue('N13', 'PARQUEADEROS CUBIERTOS');
$sheet->setCellValue('N14', 'PARQUEADEROS DESCUBIERTOS');
$sheet->setCellValue('N15', 'ENTRADAS VEHICULAR DIRECTA');
$sheet->setCellValue('N16', 'PUERTAS VEHICULARES');
$sheet->setCellValue('N17', 'PUERTAS PEATONALES');
$sheet->setCellValue('N18', 'FRENTES INMUEBLE');
$sheet->setCellValue('N20', 'MATERIAL DISPONIBLE: ');
$sheet->setCellValue('N21', 'FOTOS ');
$sheet->setCellValue('N22', 'VIDEOS');
$sheet->setCellValue('N23', 'PLANOS');
$sheet->setCellValue('N24', 'USO SUELOS ');
$sheet->setCellValue('N25', 'MAPAS');
 $sheet->setCellValue('N26', 'BENEF, TRIBUT Y ARANCEL');

$sheet->setCellValue('N27', 'EMPRESAS VECINAS ');
$sheet->setCellValue('N28', 'OTROS: ');

$sheet->setCellValue('Q2', 'PROPIETARIOS:');
$sheet->setCellValue('Q3', 'DIRECCION INMUEBLE');
$sheet->setCellValue('Q4', '# MATRICULA INMOBILIARIA');
$sheet->setCellValue('Q5', '# MATRICULA AGUA');
$sheet->setCellValue('Q6', '#MATRICULA LUZ');
$sheet->setCellValue('Q7', '# MATRICULA GAS');
$sheet->setCellValue('Q8', 'NOMBRE O RAZON SOCIAL');
$sheet->setCellValue('Q9', 'REPRESENTANTE LEGAL');
$sheet->setCellValue('Q10', 'CC REP LEG');
$sheet->setCellValue('Q11', 'CELULAR');
$sheet->setCellValue('Q12', 'TELEFONO FIJO');
$sheet->setCellValue('Q13', 'CORREO ELECTRONICO');
$sheet->setCellValue('Q14', 'DIRECCION');
$sheet->setCellValue('Q15', 'REMUNERACION VENTA');
$sheet->setCellValue('Q16', 'REMUNERACION RENTA');
$sheet->setCellValue('Q17', 'NOTAS');

$sheet->setCellValue('Q19', 'ASESOR');
$sheet->setCellValue('Q20', 'NOMBRE');
$sheet->setCellValue('Q21', 'CEDULA');
$sheet->setCellValue('Q22', 'CELULAR');
$sheet->setCellValue('Q23', 'EMAIL');
$sheet->setCellValue('Q24', 'INMOBILIARIA');
$sheet->setCellValue('Q25', 'NOTAS');


 $sheet->mergeCells('B34:E34');
 $sheet->mergeCells('H34:J34');

 $sheet->getRowDimension(34)->setRowHeight(74);

// $sheet->mergeCells('K1:M1');
$sheet->getStyle('B1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('K1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('O1:Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Ajustar el ancho de las columna

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(5);
$sheet->getColumnDimension('E')->setWidth(25);
$sheet->getColumnDimension('F')->setWidth(25);
$sheet->getColumnDimension('G')->setWidth(5);
$sheet->getColumnDimension('H')->setWidth(25);
$sheet->getColumnDimension('I')->setWidth(25);
$sheet->getColumnDimension('J')->setWidth(5);
$sheet->getColumnDimension('K')->setWidth(25);
$sheet->getColumnDimension('L')->setWidth(25);
$sheet->getColumnDimension('M')->setWidth(5);
$sheet->getColumnDimension('N')->setWidth(25);
$sheet->getColumnDimension('O')->setWidth(25);
$sheet->getColumnDimension('P')->setWidth(5);
$sheet->getColumnDimension('Q')->setWidth(25);
$sheet->getColumnDimension('R')->setWidth(25);
$sheet->getColumnDimension('S')->setWidth(25);
$sheet->getColumnDimension('T')->setWidth(25);
$sheet->getColumnDimension('U')->setWidth(25);
$sheet->getColumnDimension('V')->setWidth(25);

$nombreEst = '';
$rowIndex = 3;
$codigo = 0;
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    // print_r($row);
    $sheet->setCellValue('C2', $row['cod_cap']);
    $sheet->setCellValue('C6', $row['area_total_cap']);
    $sheet->setCellValue('C7', $row['area_lote_capr']);
    $sheet->setCellValue('C8', $row['area_piso1_cap']);
    $sheet->setCellValue('C9', $row['area_piso2_cap']);
    $sheet->setCellValue('C11', $row['frente_habi1_capr'] . ' X ' . $row['fondo_habi1_capr']);
    $sheet->setCellValue('C12', $row['frente_habi2_capr'] . ' X ' . $row['fondo_habi2_capr']);
    $sheet->setCellValue('C13', $row['frente_habi3_capr'] . ' X ' . $row['fondo_habi3_capr']);
    $sheet->setCellValue('C14', $row['frente_sala_capr'] . ' X ' . $row['fondo_sala_capr']);
    $sheet->setCellValue('C15', $row['vestidores_capr']);
    $sheet->setCellValue('C16', $row['closets_capr']);
    $sheet->setCellValue('C17', $row['salas_capr']);
    $sheet->setCellValue('C19', $row['balcon_capr']);
    $sheet->setCellValue('C20', $row['terraza_capr']);
    $sheet->setCellValue('C21', $row['patio_capr']);
    $sheet->setCellValue('C22', $row['sotanos_capr']);
    $sheet->setCellValue('C23', $row['pisos_capr']);
    $sheet->setCellValue('C25', $row['tipo_cocina_capr']);
    $sheet->setCellValue('C26', $row['isla_cocina_capr']);
    $sheet->setCellValue('C27', $row['tipo_lavaplatos_capr']);
    $sheet->setCellValue('C28', $row['espacio_nevecon_capr']);

    $sheet->setCellValue('F3', '');
    $sheet->setCellValue('F4', '');
    $sheet->setCellValue('F5', $row['cod_dane_dep']);
    $sheet->setCellValue('F6', $row['id_mun']);
    $sheet->setCellValue('F7', $row['sector_capr']);
    $sheet->setCellValue('F8', $row['ubicacion_gps_capr']);
    $sheet->setCellValue('F9', $row['estrato_cap']);
    $sheet->setCellValue('F10', $row['posición_cap']);
    $sheet->setCellValue('F11', $row['conjunto_cerrado_cap']);
    $sheet->setCellValue('F12', $row['conjunto_vigilado_cap']);
    $sheet->setCellValue('F13', $row['porteria_recpecion_cap']);
    $sheet->setCellValue('F14', $row['citofonia_capr']);
    $sheet->setCellValue('F16', $row['edad_cap']);
    $sheet->setCellValue('F17', $row['estado_bod_cap']);
    $sheet->setCellValue('F18', $row['niveles_internos_cap']);
    $sheet->setCellValue('F19', $row['tipo_bodega_cap']);
    $sheet->setCellValue('F20', $row['esquinera_medianera_cap']);
    $sheet->setCellValue('F21', $row['oficinas_cap']);
    $sheet->setCellValue('F22', $row['duchas_cap']);
    $sheet->setCellValue('F23', $row['lavamanos_cap']);
    $sheet->setCellValue('F24', $row['sanitarios_cap']);
    $sheet->setCellValue('F25', $row['poceta_cap']);
    $sheet->setCellValue('F26', $row['cocineta_cap']);
    $sheet->setCellValue('F27', $row['tinas_capr']);
    $sheet->setCellValue('F28', $row['transporte_publico_cap']);

    $sheet->setCellValue('I3', $row['energia_precio_kv_cap']);
    $sheet->setCellValue('I4', $row['agua_precio_m3_cap']);
    $sheet->setCellValue('I5', $row['empresa_energia_capr']);
    $sheet->setCellValue('I6', $row['kva_transformador_cap']);
    $sheet->setCellValue('I7', $row['calibre_acometida_cap']);
    $sheet->setCellValue('I8', $row['tomas_220_cap']);
    $sheet->setCellValue('I9', $row['redes_inde_cap']);
    $sheet->setCellValue('I10', $row['planta_electrica_cap']);
    $sheet->setCellValue('I11', $row['empresa_agua_capr']);
    $sheet->setCellValue('I12', $row['tanques_agua_reserva_cap']);
    $sheet->setCellValue('I13', $row['hidrante_cap']);
    $sheet->setCellValue('I14', $row['gabinete_cont_incendio_cap']);
    $sheet->setCellValue('I15', $row['red_contra_incendios_cap']);
    $sheet->setCellValue('I16', $row['gas_cap']);
    $sheet->setCellValue('I17', $row['agua_caliente_capr']);
    $sheet->setCellValue('I18', $row['internet_telefonia_capr']);
    $sheet->setCellValue('I20', $row['restaurantes_capr']);
    $sheet->setCellValue('I21', $row['supermercados_capr']);
    $sheet->setCellValue('I22', $row['droguerias_capr']);
    $sheet->setCellValue('I23', $row['centro_comer_capr']);
    $sheet->setCellValue('I24', $row['universidades_capr']);
    $sheet->setCellValue('I25', $row['colegios_capr']);
    $sheet->setCellValue('I26', $row['jardines_infantiles_capr']);
    $sheet->setCellValue('I27', $row['otros_capr']);

    $sheet->setCellValue('L3', $row['aire_acondicionado_capr']);
    $sheet->setCellValue('L4', $row['jardines_capr']);
    $sheet->setCellValue('L5', $row['turco_capr']);
    $sheet->setCellValue('L6', $row['jacuzzi_capr']);
    $sheet->setCellValue('L7', $row['sauna_capr']);
    $sheet->setCellValue('L8', $row['cancha_tenis_capr']);
    $sheet->setCellValue('L9', $row['cancha_futbol_capr']);
    $sheet->setCellValue('L10', $row['cancha_micro_fut_capr']);
    $sheet->setCellValue('L11', $row['cancha_basquet_capr']);
    $sheet->setCellValue('L12', $row['piscina_adultos_capr']);
    $sheet->setCellValue('L13', $row['piscina_ninos_capr']);
    $sheet->setCellValue('L14', $row['sendero_ecol_capr']);
    $sheet->setCellValue('L15', $row['mascotas_capr']);
    $sheet->setCellValue('L16', $row['zona_mascotas_capr']);
    $sheet->setCellValue('L17', $row['gym_capr']);
    $sheet->setCellValue('L18', $row['ascensor_capr']);
    $sheet->setCellValue('L19', $row['juegos_ninos_capr']);
    $sheet->setCellValue('L20', $row['lago_pesca_capr']);
    $sheet->setCellValue('L21', $row['cancha_squash_capr']);
    $sheet->setCellValue('L22', $row['otros_juegos_capr']);
    $sheet->setCellValue('L24', $row['acabados_pisos_capr']);
    $sheet->setCellValue('L25', $row['acabados_muro_capr']);
    $sheet->setCellValue('L26', $row['material_muros_porc_cap']);
    $sheet->setCellValue('L27', $row['tipo_techo_cap']);
    $sheet->setCellValue('L28', $row['material_techo_cap']);

    $sheet->setCellValue('O3', $row['venta_neta_cap']);
    $sheet->setCellValue('O4', $row['venta_m2_cap']);
    $sheet->setCellValue('O5', $row['canon_neto_cap']);
    $sheet->setCellValue('O6', $row['canon_m2_cap']);
    $sheet->setCellValue('O7', $row['porcentaje_iva_cap']);
    $sheet->setCellValue('O8', $row['valor_iva_cap']);
    $sheet->setCellValue('O9', $row['admon_cap']);
    $sheet->setCellValue('O10', $row['renta_total_cap']);
    $sheet->setCellValue('O13', $row['parquead_cubi_capr']);
    $sheet->setCellValue('O14', $row['parquead_descubi_capr']);
    $sheet->setCellValue('O15', $row['entrada_veh_directo_cap']);
    $sheet->setCellValue('O16', $row['puertas_vehic_capr']);
    $sheet->setCellValue('O17', $row['puertas_peaton_capr']);
    $sheet->setCellValue('O18', $row['frentes_inmu_capr']);
    $sheet->setCellValue('O21', $row['fotos_cap']);
    $sheet->setCellValue('O22', $row['videos_cap']);
    $sheet->setCellValue('O23', $row['planos_cap']);
    $sheet->setCellValue('O24', $row['uso_suelos_cap']);
    $sheet->setCellValue('O25', $row['mapas_cap']);
    $sheet->setCellValue('O27', $row['empresas_vecinas_cap']);

    $sheet->setCellValue('R3', $row['direccion_inm_capr']);
    $sheet->setCellValue('R4', $row['num_matricula_inm_capr']);
    $sheet->setCellValue('R5', $row['num_matricula_agua_cap']);
    $sheet->setCellValue('R6', $row['num_matricula_energia_cap']);
    $sheet->setCellValue('R7', $row['num_matricula_gas_cap']);
    $sheet->setCellValue('R8', $row['nombre_razon_social_capr']);
    $sheet->setCellValue('R9', $row['representante_legal_capr']);
    $sheet->setCellValue('R10', $row['cc_nit_repre_legal_cap']);
    $sheet->setCellValue('R11', $row['cel_repre_legal_cap']);
    $sheet->setCellValue('R12', $row['tel_repre_legal_capr']);
    $sheet->setCellValue('R13', $row['email_repre_legal_capr']);
    $sheet->setCellValue('R14', $row['dir_repre_legal_capr']);
    $sheet->setCellValue('R15', $row['remuneracion_vta_cap']);
    $sheet->setCellValue('R16', $row['remuneracion_renta_cap']);
    $sheet->setCellValue('R17', $row['obs1_capr1']  );

    $sheet->setCellValue('R20', asesorCaracteristicas($row['nit_cc_ase'],"nombre") );
    $sheet->setCellValue('R21', $row['nit_cc_ase'] );
    $sheet->setCellValue('R22', asesorCaracteristicas($row['nit_cc_ase'],"celular") );
    $sheet->setCellValue('R23', asesorCaracteristicas($row['nit_cc_ase'],"email") );
    $sheet->setCellValue('R24', '');
    $sheet->setCellValue('R25', $row['obs1_capr1']);

    $rowIndex++;
    $codigo = $row['cod_cap'];
}
$filename = 'Ficha Tec_residencial '. $codigo . '.xlsx';
$writer = new Xlsx($spreadsheet);

// Set the headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output the generated Excel file to the browser
$writer->save('php://output');
exit;
