<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];
header("Content-Type: text/html;charset=utf-8");

include("../../conexion.php");

// Verificar si el parámetro num_con está presente y válido
if (!isset($_GET['num_con']) || empty($_GET['num_con'])) {
    die("Número de contrato no especificado.");
}

$num_con = $_GET['num_con'];

// Consulta a la base de datos
$sql = mysqli_query($mysqli, "SELECT * FROM contratos WHERE num_con = '$num_con'");
if (!$sql) {
    die("Error en la consulta SQL: " . mysqli_error($mysqli));
}
$row = mysqli_fetch_array($sql);

if (!$row) {
    die("Contrato no encontrado para el número: $num_con");
}

$fec_inicio_con = new DateTime($row['fec_inicio_con']);
$vigencia_duracion_con = $row['vigencia_duracion_con'];
// Verificar si se recibieron los datos del formulario correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pago_propietario           = $_POST['pago_propietario'] ?? '';
    // $transferencia_propietario  = $_POST['transferencia_propietario'] ?? 'N/A';
    $factura_electronica0       = $_POST['factura_electronica0'] ?? '';
    $factura_electronica1       = $_POST['factura_electronica1'] ?? 'N/A';
    $factura_electronica2       = $_POST['factura_electronica2'] ?? 'N/A';
    $cuenta_cobro               = $_POST['cuenta_cobro'] ?? 'N/A';
    $factura_colbodegas        = $_POST['factura_colbodegas'] ?? 'N/A';


    $canon_con                  = $row['canon_con'];
    $iva_con                    = $row['iva_con'];
    $renta_con                  = $row['renta_con'];
    $admon_con                  = $row['admon_con'];
    $perfil                     = $_POST['perfil'] ?? '';
    $comision1                  = $_POST['comision1'] ?? 0;
    //rte propietario
    $rte_fte1                  = $_POST['rte_fte1'] ?? 0;
    $rte_fte2                  = $_POST['rte_fte2'] ?? 0;
    $rte_ica1                 = $_POST['rte_ica1'] ?? 0;
    $rte_ica2                 = $_POST['rte_ica2'] ?? 0;
    $rte_iva1                 = $_POST['rte_iva1'] ?? 0;
    $rte_iva2                 = $_POST['rte_iva2'] ?? 0;
    //rete inmobiliaria
    $rte_fte3                  = $_POST['rte_fte3'] ?? 0;
    $rte_fte4                  = $_POST['rte_fte4'] ?? 0;
    $rte_ica3                 = $_POST['rte_ica3'] ?? 0;
    $rte_ica4                 = $_POST['rte_ica4'] ?? 0;
    $iva3                      = $_POST['iva3'] ?? 0;
    $iva4                      = $_POST['iva4'] ?? 0;
    $rte_iva3                = $_POST['rte_iva3'] ?? 0;
    $rte_iva4                = $_POST['rte_iva4'] ?? 0;

    $comision_aplica_a          = $_POST['comision_aplica_a'] ?? '';
    $comision2                  = $_POST['comision2'] ?? 0;
    $acuerdo                    = $_POST['acuerdo'];
    $estado_pago                = 1;
    $fecha_alta_pago            = date('Y-m-d h:i:s');
    $id_usu_alta_pago           = $_SESSION['id_usu'];
    $fecha_edit_pago            = ('0000-00-00 00:00:00');
    $id_usu                     = $_SESSION['id_usu'];

    if (empty($pago_propietario)) {
        die("Por favor, completa todos los campos obligatorios del formulario.");
    }

    // Generar registros en la tabla PAGOS
    for ($i = 0; $i < $vigencia_duracion_con; $i++) {
        $fecha_pago = $fec_inicio_con->format('Y-m-d');
        $num_pago = $i + 1; // Número de pago secuencial

        // Calcular comision_pago y total_consignar_pago
        if ($comision1 != 0) {
            $comision_pago = $renta_con * ($comision1 / 100);
        } else {
            $comision_pago = $renta_con * ($comision2 / 100);
        }
        if($acuerdo > 0) {
            $comision_pago = $acuerdo;
        }
        $total_consignar_pago = $renta_con - $comision_pago;

        // Insertar registro en la tabla PAGOS
        $insert_sql = "INSERT INTO pagos (num_con, fecha_pago, num_pago, pagado_a, pago_a_inmobiliaria, metodo_pago, factura_electronica0, factura_electronica1, factura_electronica2, canon_con, iva_con, admon_con, renta_con, comision_aplica_a, comision1, comision2, acuerdo, rte_fte1, rte_fte2, rte_fte3, rte_fte4, rte_ica1, rte_ica2, rte_ica3, rte_ica4, rte_iva1, rte_iva2, cuenta_cobro,
        iva_aplica_inmobi, iva_inmobi,rte_iva_aplica_inmobi,rte_iva_inmobi,
        factura_colbodegas, comision_pago, total_consignar_pago, prorrateo, dias_prorra, valor_prorra, estado_pago, fecha_alta_pago, id_usu_alta_pago, fecha_edit_pago, id_usu)
        VALUES ('$num_con', '$fecha_pago', '$num_pago', '$pago_propietario', '', '', '$factura_electronica0', '$factura_electronica1', '$factura_electronica2', '$canon_con', '$iva_con', '$admon_con', '$renta_con', '$comision_aplica_a', '$comision1', '$comision2', '$acuerdo', '$rte_fte1', '$rte_fte2', '$rte_fte3', '$rte_fte4', '$rte_ica1', '$rte_ica2', '$rte_ica3', '$rte_ica4', '$rte_iva1', '$rte_iva2', '$cuenta_cobro',
        '$iva3', '$iva4', '$rte_iva3', '$rte_iva4',
        '$factura_colbodegas', '$comision_pago', '$total_consignar_pago', '', '', '', '$estado_pago', '$fecha_alta_pago', '$id_usu_alta_pago', '$fecha_edit_pago', '$id_usu')";


        if (!mysqli_query($mysqli, $insert_sql)) {
            die("Error al insertar en la tabla PAGOS: " . mysqli_error($mysqli));
        }

        // Sumar un mes a la fecha de inicio
        $fec_inicio_con->modify('+1 month');
    }
    echo "
        <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta charset='utf-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                    <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                    <link href='../../fontawesome/css/all.css' rel='stylesheet'>
                    <script src='https://kit.fontawesome.com/fed2435e21.js' crossorigin='anonymous'></script>
                    <title>VISION | SOFT</title>
                    <style>
                        .responsive {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
                </head>
                <body>
                    <center>
                       <img src='../../img/logo.png' width=300 height=212 class='responsive'>
                    <div class='container'>
                        <br />
                        <h3><b><i class='fa-solid fa-money-check-dollar'></i> SE GENERÓ LOS PAGOS DE FORMA EXITOSA</b></h3>";
    echo "<h5>Número de contrato recibido: $num_con</h5><br>
                        <p align='center'><a href='showpay.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                    </div>
                    </center>
                </body>
            </html>
        ";
    //echo "Registros generados exitosamente.";
    //header("Location: ../cont/showcont.php");
    exit();
} else {
    echo "No se recibieron datos del formulario.<br>"; // Mensaje de depuración
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}
