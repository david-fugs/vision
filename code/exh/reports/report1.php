<?php
// Include the main TCPDF library
require_once('../../../tcpdf/tcpdf.php');

// Conexión a la base de datos
$conn = new mysqli('localhost', 'visioni4_crm', '0IqlF]ox$teq', 'visioni4_crm');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores del formulario
$fecha_inicial = $_POST['de'];
$fecha_final = $_POST['hasta'];
$tipo_inmueble = $_POST['tipo_inm_exh'];

// Crear una clase personalizada extendiendo TCPDF para el pie de página
class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Footer text
        $this->Cell(0, 10, 'Vision Inmobiliaria / ColBodegas, Centro Comercial el Lago, Cl. 24 #7-29 Oficina 606, Pereira, Risaralda. Cel. 3005494969, visioninmobiliaria.co', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Crear una instancia de TCPDF, orientación horizontal (landscape)
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configurar la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('VISION');
$pdf->SetTitle('Informe de Exhibiciones');
$pdf->SetSubject('Informe Generado');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, informe, exhibiciones');

// Configurar la cabecera y el pie de página
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true); // Activar el pie de página

// Configurar la fuente
$pdf->SetFont('helvetica', '', 10);

// Consulta SQL con filtros
$sql = "SELECT fec_exh, cod_fr_exh, direccion_inm_exh, nom_ape_inte_exh, raz_soc_exh, 
               nit_cc_exh, cel_inte_exh, tipo_inm_exh, visita_exh,
               valor_ubicacion_exh, valor_fachada_exh, valor_area_exterior_exh, valor_iluminacion_exh, 
               valor_altura_exh, valor_pisos_exh, valor_paredes_exh, valor_carpinteria_exh, valor_banhos_exh,
               area_max_exh, area_min_exh, tipo_sis_elec_exh, kVA_exh, presupuesto_max_exh, presupuesto_min_exh,
               obs1_exh, obs2_exh, nit_cc_ase
        FROM exhibiciones
        WHERE fec_exh BETWEEN ? AND ? 
        AND tipo_inm_exh = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $fecha_inicial, $fecha_final, $tipo_inmueble);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Agregar una nueva página para cada registro
        $pdf->AddPage();

        // Agregar el logo en la parte superior (reducción del tamaño en un 30%)
        $pdf->Image('../../../img/logo.png', 10, 10, 28, '', 'PNG');
        $pdf->Ln(15);

        // Título del informe
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Informe de Exhibiciones', 0, 1, 'C');
        $pdf->Ln(10);

        // Encabezados de la tabla
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(211, 211, 211); // Color gris claro
        $pdf->MultiCell(30, 10, 'Fecha', 1, 'C', 1, 0);
        $pdf->MultiCell(25, 10, 'Cod. FR', 1, 'C', 1, 0);
        $pdf->MultiCell(50, 10, 'Direccion', 1, 'C', 1, 0);
        $pdf->MultiCell(45, 10, 'Nombre Interesado', 1, 'C', 1, 0);
        $pdf->MultiCell(50, 10, 'Razon Social', 1, 'C', 1, 0);
        $pdf->MultiCell(30, 10, 'NIT/CC', 1, 'C', 1, 0);
        $pdf->MultiCell(30, 10, 'Celular', 1, 'C', 1, 1);

        // Imprimir los datos en las celdas
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(30, 10, $row['fec_exh'], 1, 'C', 0, 0);
        $pdf->MultiCell(25, 10, $row['cod_fr_exh'], 1, 'C', 0, 0);
        $pdf->MultiCell(50, 10, $row['direccion_inm_exh'], 1, 'L', 0, 0);
        $pdf->MultiCell(45, 10, $row['nom_ape_inte_exh'], 1, 'L', 0, 0);
        $pdf->MultiCell(50, 10, $row['raz_soc_exh'], 1, 'L', 0, 0);
        $pdf->MultiCell(30, 10, $row['nit_cc_exh'], 1, 'L', 0, 0);
        $pdf->MultiCell(30, 10, $row['cel_inte_exh'], 1, 'C', 0, 1);

        // Mostrar campos adicionales si es 'Residencial'
        if ($row['tipo_inm_exh'] == 'Residencial') {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(260, 10, 'Detalles Residencial:', 1, 1, 'L', 1);
            $pdf->SetFont('helvetica', '', 10);

            // Crear un array de los campos con los valores a mostrar
            $fields = [
                'Ubicacion' => $row['valor_ubicacion_exh'],
                'Fachada' => $row['valor_fachada_exh'],
                'Area Exterior' => $row['valor_area_exterior_exh'],
                'Iluminacion' => $row['valor_iluminacion_exh'],
                'Altura' => $row['valor_altura_exh'],
                'Pisos' => $row['valor_pisos_exh'],
                'Paredes' => $row['valor_paredes_exh'],
                'Carpinteria' => $row['valor_carpinteria_exh'],
                'Banos' => $row['valor_banhos_exh']
            ];

            $total = 0;
            $count = 0;

            // Iterar sobre los campos para imprimirlos con los colores apropiados
            foreach ($fields as $label => $value) {
                if ($row['visita_exh'] == 1) {
                    $total += $value;
                    $count++;
                    if ($value >= 0 && $value <= 4) {
                        $pdf->SetTextColor(255, 0, 0); // Rojo
                    } elseif ($value >= 5 && $value <= 7) {
                        $pdf->SetTextColor(255, 165, 0); // Naranja
                    } elseif ($value >= 8 && $value <= 10) {
                        $pdf->SetTextColor(0, 128, 0); // Verde
                    }
                } else {
                    $value = 0;
                    $pdf->SetTextColor(0, 0, 0); // Negro
                }
                // Espacio sencillo entre los campos
                $pdf->MultiCell(260, 6, "$label: $value", 1, 'L', 0, 1);
            }

            $pdf->SetTextColor(0, 0, 0); // Restablecer a negro

            // Observaciones
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(260, 10, 'Observaciones:', 1, 1, 'L', 1);
            $pdf->SetFont('helvetica', '', 10);

            // Ajustar dinámicamente la altura de las celdas para obs1_exh y obs2_exh
            $pdf->MultiCell(260, 0, "Obs1: {$row['obs1_exh']}", 1, 'L', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
            $pdf->MultiCell(260, 0, "Obs2: {$row['obs2_exh']}", 1, 'L', 0, 1, '', '', true, 0, false, true, 0, 'T', false);

            // Calcular y mostrar el promedio
            if ($row['visita_exh'] == 1 && $count > 0) {
                $average = $total / $count;
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->SetFillColor(211, 211, 211); // Relleno gris claro
                if ($average >= 0 && $average <= 4) {
                    $pdf->SetTextColor(255, 0, 0); // Rojo
                } elseif ($average >= 5 && $average <= 7) {
                    $pdf->SetTextColor(255, 165, 0); // Naranja
                } elseif ($average >= 8 && $average <= 10) {
                    $pdf->SetTextColor(0, 128, 0); // Verde
                }
                $pdf->MultiCell(260, 10, "Promedio de Evaluación: $average", 1, 'C', 1, 1);
            } else {
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->SetFillColor(211, 211, 211); // Relleno gris claro
                $pdf->MultiCell(260, 10, "No aplica promedio", 1, 'C', 1, 1);
            }

            $pdf->SetTextColor(0, 0, 0); // Restablecer a negro
        }

        // Mostrar campos adicionales si es 'Comercial'
        if ($row['tipo_inm_exh'] == 'Comercial') {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(260, 10, 'Detalles Comercial:', 1, 1, 'L', 1);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->MultiCell(260, 6, "Area Max: {$row['area_max_exh']}   Area Min: {$row['area_min_exh']}   Tipo Sist. Electrico: {$row['tipo_sis_elec_exh']}   kVA: {$row['kVA_exh']}   Presupuesto Max: {$row['presupuesto_max_exh']}   Presupuesto Min: {$row['presupuesto_min_exh']}", 1, 'L', 0, 1);

            // Observaciones
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(260, 10, 'Observaciones:', 1, 1, 'L', 1);
            $pdf->SetFont('helvetica', '', 10);
            $pdf->MultiCell(260, 0, "Obs1: {$row['obs1_exh']}", 1, 'L', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
            $pdf->MultiCell(260, 0, "Obs2: {$row['obs2_exh']}", 1, 'L', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
        }

        // Mostrar el nombre del asesor y el documento para 'nit_cc_ase'
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(260, 10, 'Asesor:', 1, 1, 'L', 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(260, 10, "Asesor: {$row['nit_cc_ase']}", 1, 1, 'L', 0);
    }
} else {
    $pdf->Cell(260, 10, 'No se encontraron resultados.', 1, 1, 'C');
}

// Cerrar y emitir el documento
$pdf->Output('informe_exhibiciones.pdf', 'I');

$stmt->close();
$conn->close();
?>
