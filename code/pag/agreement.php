<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
}

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];
header("Content-Type: text/html;charset=utf-8");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VISION | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- Using Select2 from a CDN-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        .comision-pago {
            font-weight: bold;
            font-size: 20px;
        }

        fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        legend {
            font-weight: bold;
            font-size: 0.9em;
            color: #4a4a4a;
            padding: 0 10px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        /* Efecto de enfoque para el fieldset */
        fieldset:focus-within {
            background-color: #e6f7ff;
            /* Azul muy claro */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            /* Sombreado azul claro */
        }
    </style>

</head>

<body>
    <?php
    include("../../conexion.php");

    $num_con  = $_GET['num_con'];
    $id_pago = $_GET['id_pago'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $num_con = $_POST['num_con'];
        $num_pago = $_POST['num_pago'];
        $canon_con = $_POST['canon_con'];
        $iva_con = $_POST['iva_con'] ?? 0;
        $renta_con = $_POST['renta_con'] ?? 0 ;
        $total_consignar_pago = $_POST['total_consignar_pago'] ?? 0;
        $comision1 = $_POST['comision1'] ?? 0;
        $comision2 = $_POST['comision2'] ?? 0;
        $acuerdo = $_POST['acuerdo'] ?? 0;
        $comision_aplica_a = $_POST['comision_aplica_a'] ?? 0;
        $rte_fte1 = $_POST['rte_fte1'] ?? 0;
        $rte_fte2 = $_POST['rte_fte2'] ?? 0;
        $rte_ica1 = $_POST['rte_ica1'] ?? 0;
        $rte_ica2 = $_POST['rte_ica2'] ?? 0;
        $rte_iva1 = $_POST['rte_iva1'] ?? 0;
        $rte_iva2 = $_POST['rte_iva2']?? 0 ;
        $rte_fte3 = $_POST['rte_fte3']?? 0 ;
        $rte_fte4 = $_POST['rte_fte4']?? 0 ;
        $rte_ica3 = $_POST['rte_ica3']?? 0 ;
        $rte_ica4 = $_POST['rte_ica4']?? 0 ;
        $rte_iva3 = $_POST['rte_iva3']?? 0 ;
        $rte_iva4 = $_POST['rte_iva4']?? 0;
        $comision_pago = $_POST['comision_pago'] ?? 0;
        $iva3 = $_POST['iva3'] ?? 0;
        $iva4 = $_POST['iva4']?? 0;

        $sql_update = "UPDATE pagos SET  canon_con = '$canon_con', iva_con = '$iva_con', renta_con = '$renta_con', total_consignar_pago = '$total_consignar_pago', comision1 = '$comision1', comision2 = '$comision2', acuerdo = '$acuerdo', rte_fte1 = '$rte_fte1', rte_fte2 = '$rte_fte2', rte_ica1 = '$rte_ica1', rte_ica2 = '$rte_ica2', rte_iva1 = '$rte_iva1', rte_iva2 = '$rte_iva2', rte_fte3 = '$rte_fte3', rte_fte4 = '$rte_fte4', rte_ica3 = '$rte_ica3', rte_ica4 = '$rte_ica4', rte_iva_aplica_inmobi = '$rte_iva3', rte_iva_inmobi = '$rte_iva4', comision_pago = '$comision_pago', iva_aplica_inmobi = '$iva3', iva_inmobi = '$iva4' WHERE num_con = '$num_con' AND num_pago > '$num_pago'";

        if (!mysqli_query($mysqli, $sql_update)) {
            die("Error al insertar en la tabla PAGOS: " . mysqli_error($mysqli));
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
    }
    if (isset($_GET['num_con'])) {
        $sql = mysqli_query($mysqli, "SELECT * FROM contratos WHERE num_con = '$num_con'");
        $row = mysqli_fetch_array($sql);

        $sql_pagos = mysqli_query($mysqli, "SELECT * FROM pagos WHERE num_con = '$num_con' AND id_pago = '$id_pago'");
        $row_pagos = mysqli_fetch_array($sql_pagos);
    }
    ?>

    <div class="container">
        <h1><img src='../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-money-check-dollar"></i> GENERAR ACUERDO AL CONTRATO</b></h1>
        <p><i><b>
                    <font size=3 color=#c68615>*Datos obligatorios</i></b></font>
        </p>

        <form action='agreement.php?num_con=<?php echo $row['num_con']; ?>' enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <fieldset>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="num_con">CONTRATO No.</label>
                            <input type='number' name='num_con' class='form-control' id="num_con" value='<?php echo $row['num_con']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fec_inicio_con">FECHA INICIO:</label>
                            <input type='date' name='fec_inicio_con' class='form-control' id="fec_inicio_con" value='<?php echo $row['fec_inicio_con']; ?>' readonly />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="vigencia_duracion_con">VIGENCIA:</label>
                            <input type='number' name='vigencia_duracion_con' class='form-control' id="vigencia_duracion_con" value='<?php echo $row['vigencia_duracion_con']; ?>' readonly />
                        </div>

                    </div>


                </fieldset>
            </div>
            <div class="form-group">
                <fieldset>
                    <legend>*** DATOS INMOBILIARIA ***</legend>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="comision_aplica_a">* COMISION APLICA A:</label>
                            <select class="form-control" name="comision_aplica_a" id="comision_aplica_a" required disabled>
                                <option value="" <?php if ($row_pagos['comision_aplica_a'] == "") echo "selected"; ?>></option>
                                <option value=1 <?php if ($row_pagos['comision_aplica_a'] == 1) echo "selected"; ?>>Canon</option>
                                <option value=2 <?php if ($row_pagos['comision_aplica_a'] == 2) echo "selected"; ?>>Renta</option>
                                <option value=3 <?php if ($row_pagos['comision_aplica_a'] == 3) echo "selected"; ?>>Canon y Administracion</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="comision1">* COMISION:</label>
                            <select class="form-control" name="comision1" id="comision1" required>
                                <option value="" <?php if ($row_pagos['comision1'] == "") echo "selected"; ?>></option>
                                <option value=8 <?php if ($row_pagos['comision1'] == 8) echo "selected"; ?>>8%</option>
                                <option value=10 <?php if ($row_pagos['comision1'] == 10) echo "selected"; ?>>10%</option>
                                <option value=12 <?php if ($row_pagos['comision1'] == 12) echo "selected"; ?>>12%</option>
                                <option value=0 <?php if ($row_pagos['comision1'] == 0) echo "selected"; ?>>OTRO</option>
                                <option value=1 <?php if ($row_pagos['comision1'] == 1) echo "selected"; ?>>ACUERDO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="comision2">% COMISION:</label>
                            <input type="number" min="8.0" max="12.0" step="0.1" name="comision2" id="comision2" class="form-control" value="<?php echo intval($row_pagos['comision2']) ?>" readonly />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="acuerdo">ACUERDO $</label>
                            <input type="number" name="acuerdo" id="acuerdo" class="form-control" value="<?php echo $row_pagos['acuerdo'] ?>" readonly />
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="form-group">
                <fieldset>
                    <legend>*** VALORES DEL CONTRATRO ***</legend>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <strong><label for="canon_con">CANON $</label></strong>
                            <input type='number' step="any"  onchange="CanonChange()" name='canon_con' id="canon_con" class='form-control' value='<?php echo $row_pagos['canon_con']; ?>' style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="iva_con">IVA $</label></strong>
                            <input type='number' step="any"  name='iva_con' id="iva_con" class='form-control' value='<?php echo $row_pagos['iva_con']; ?>' style="font-weight:bold;" />
                        </div>

                        <div class="col-12 col-sm-3">
                            <strong><label for="renta_con">RENTA $</label></strong>
                            <input type='number' step="any"  name='renta_con' id="renta_con" class='form-control' value='<?php echo $row_pagos['renta_con']; ?>' style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="total_consignar_pago">TOTAL CONSIGNAR $</label></strong>
                            <input type='number' step="any"  name='total_consignar_pago' id="total_consignar_pago" class='form-control' value='<?php echo $row_pagos['total_consignar_pago']; ?>' style="font-weight:bold;" />
                        </div>

                    </div>
                </fieldset>
            </div>



            <hr style="border: 1px solid #F3840D; border-radius: 5px;">
            <h4><strong>Impuestos Propietario:</strong></h4>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="rte_fte1">RTE FTE %</label>
                        <select class="form-control" name="rte_fte1" id="rte_fte1" disabled>
                            <option value="" <?php if ($row_pagos['rte_fte1'] == "")  echo "selected";  ?>></option>
                            <option value=3.5 <?php if ($row_pagos['rte_fte1'] == 3.5)  echo "selected";  ?>>3.5%</option>
                            <option value=20 <?php if ($row_pagos['rte_fte1'] == 20)  echo "selected";  ?>>20%</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_fte2">RTE FTE $</label></strong>
                        <input type='text' name='rte_fte2' id='rte_fte2' class='form-control' readonly style="font-weight:bold;" value="<?php echo !empty($row_pagos['rte_fte2']) ? $row_pagos['rte_fte2'] : 0; ?>" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_ica1">RTE ICA</label>
                        <select class="form-control" name="rte_ica1" id="rte_ica1" disabled>
                            <option value="" <?php if (intval($row_pagos['rte_ica1']) === 0) echo "selected"; ?>></option>
                            <option value="7" <?php if (intval($row_pagos['rte_ica1']) === 7) echo "selected"; ?>>7</option>
                            <option value="8" <?php if (intval($row_pagos['rte_ica1']) === 8) echo "selected"; ?>>8</option>
                            <option value="9" <?php if (intval($row_pagos['rte_ica1']) === 9) echo "selected"; ?>>9</option>
                            <option value="10" <?php if (intval($row_pagos['rte_ica1']) === 10) echo "selected"; ?>>10</option>
                            <option value="0" <?php if (intval($row_pagos['rte_ica1']) === 0) echo "selected"; ?>>N/A</option>
                        </select>

                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_ica2">RTE ICA $</label></strong>
                        <input type='text' name='rte_ica2' id="rte_ica2" class='form-control' readonly style="font-weight:bold;" value="<?php echo isset($row_pagos['rte_ica2']) ? $row_pagos['rte_ica2'] : '0'; ?>" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_iva1">RTE IVA:</label>
                        <select class="form-control" name="rte_iva1" id="rte_iva1" required disabled>
                            <option value="" <?php if ($row_pagos['rte_iva1'] == "")  echo "selected";  ?>></option>
                            <option value=1 <?php if ($row_pagos['rte_iva1'] == 1)  echo "selected";  ?>>Sí</option>
                            <option value=0 <?php if ($row_pagos['rte_iva1'] == 0)  echo "selected";  ?>>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_iva2">RTE IVA $</label></strong>
                        <input type='text' name='rte_iva2' id="rte_iva2" class='form-control' readonly style="font-weight:bold;" value="<?php echo isset($row_pagos['rte_iva2']) ? $row_pagos['rte_iva2'] : '0'; ?>" />
                    </div>
                </div>
            </div>

            <h4><strong>Impuestos Inmobiliaria:</strong></h4>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <strong><label for="comision_pago">COMISIÓN</label>
                            <input type='text' name='comision_pago' id="comision_pago" class='form-control comision-pago' readonly value="<?php echo isset($row_pagos['comision_pago']) ? $row_pagos['comision_pago'] : '0'; ?>" /></strong>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="iva3"> IVA:</label>
                        <select onchange="updateIvaInmobi()" class="form-control" name="iva3" id="iva3" disabled>
                            <option value="" <?php echo (isset($row_pagos['iva3']) && $row_pagos['iva3'] === "") ? "selected" : ""; ?>></option>
                            <option value="1" <?php echo (isset($row_pagos['iva3']) && $row_pagos['iva3'] == 1) ? "selected" : ""; ?>>Sí</option>
                            <option value="0" <?php echo (isset($row_pagos['iva3']) && $row_pagos['iva3'] == 0) ? "selected" : ""; ?>>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="iva4">IVA $</label></strong>
                        <input type='text' name='iva4' id="iva4" class='form-control' readonly style="font-weight:bold;" value="<?php echo isset($row_pagos['iva4']) ? $row_pagos['iva4'] : '0'; ?>" />
                    </div>

                    <div class="col-12 col-sm-2">
                        <label for="rte_fte3">RTE FTE %</label>
                        <select class="form-control" name="rte_fte3" id="rte_fte3" disabled>
                            <option value="" <?php if ($row_pagos['rte_fte3'] == "")  echo "selected";  ?>></option>
                            <option value=3.5 <?php if ($row_pagos['rte_fte3'] == 3.5)  echo "selected";  ?>>3.5%</option>
                            <option value=4 <?php if ($row_pagos['rte_fte3'] == 4)  echo "selected";  ?>>4%</option>
                            <option value=10 <?php if ($row_pagos['rte_fte3'] == 10)  echo "selected";  ?>>10%</option>
                            <option value=11 <?php if ($row_pagos['rte_fte3'] == 11)  echo "selected";  ?>>11%</option>

                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_fte4">RTE FTE $</label></strong>
                        <input type='text' name='rte_fte4' id="rte_fte4" class='form-control' readonly style="font-weight:bold;" value="<?php echo isset($row_pagos['rte_fte4']) ? $row_pagos['rte_fte4'] : '0'; ?>" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_ica1">RTE ICA</label>
                        <select class="form-control" name="rte_ica3" id="rte_ica3" disabled>
                            <option value="" <?php if ($row_pagos['rte_ica3'] == "")  echo "selected";  ?>></option>
                            <option value=7 <?php if ($row_pagos['rte_ica3'] == 7)  echo "selected";  ?>>7</option>
                            <option value=8 <?php if ($row_pagos['rte_ica3'] == 8)  echo "selected";  ?>>8</option>
                            <option value=9 <?php if ($row_pagos['rte_ica3'] == 9)  echo "selected";  ?>>9</option>
                            <option value=10 <?php if ($row_pagos['rte_ica3'] == 10)  echo "selected";  ?>>10</option>
                            <option value=0 <?php if ($row_pagos['rte_ica3'] == 0)  echo "selected";  ?>>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_ica2">RTE ICA $</label></strong>
                        <input type='text' name='rte_ica4' id="rte_ica4" class='form-control' readonly style="font-weight:bold;" value=" <?php echo isset($row_pagos['rte_ica4']) ? $row_pagos['rte_ica4'] : '0'; ?>" />
                    </div>

                    <div class="col-12 col-sm-2">
                        <label for="rte_iva3">RTE IVA:</label>
                        <select onchange="updateRteIvaInmobi()" class="form-control" name="rte_iva3" id="rte_iva3" required onchange="updateRteIvaInmobi()" disabled>
                            <option value="" <?php echo (isset($row_pagos['rte_iva3']) && $row_pagos['rte_iva3'] == "") ? "selected" : ""; ?>></option>
                            <option value=1 <?php echo (isset($row_pagos['rte_iva3']) && $row_pagos['rte_iva3'] == 1) ? "selected" : ""; ?>>Sí</option>
                            <option value=0 <?php echo (isset($row_pagos['rte_iva3']) && $row_pagos['rte_iva3'] == 0) ? "selected" : ""; ?>>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_iva4">RTE IVA $</label></strong>
                        <input type='text' name='rte_iva4' id="rte_iva4" class='form-control' readonly style="font-weight:bold;" value=" <?php echo isset($row_pagos['rte_iva4']) ? $row_pagos['rte_iva4'] : '0'; ?>" />
                    </div>

                    <input type="hidden" name="num_pago" value="<?php echo $_GET['num_pago']   ?>">
                    <input type="hidden" name="num_con" value="<?php echo $_GET['num_con']   ?>">



                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                GENERAR ACUERDO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>

</html>
<script>
    function CanonChange() {
        var canon = document.getElementById('canon_con').value;
        updateIva(canon);
        updateRenta(canon);
        updaterteFtePropietario(canon);
        updateRteIcaPropietario(canon);
        updateIvaPropietario(canon);
        updateComisionPago(canon);
        updateIvaInmobi();
        updateRteFteInmobi();
        updateRteIcaInmobi();
        updateRteIvaInmobi();
        updateTotalConsignar();
    }

    function updateIva(canon) {
        var iva = canon * 0.19;
        document.getElementById('iva_con').value = iva;

    }

    function updateRenta(canon) {
        var canonNumber = parseFloat(canon); // Convierte canon a un número
        var iva = canonNumber * 0.19;
        var renta = canonNumber + iva;
        document.getElementById('renta_con').value = renta.toFixed(2); // Opcional: redondear a 2 decimales
    }

    function updaterteFtePropietario(canon) {
        var canonNumber = parseFloat(canon); // Convierte canon a un número
        var rteFtePropietario = document.getElementById('rte_fte1').value;
        var rteFte = (canonNumber * rteFtePropietario) / 100;
        document.getElementById('rte_fte2').value = rteFte.toFixed(2);
    }

    function updateRteIcaPropietario(canon) {
        var canonNumber = parseFloat(canon); // Convierte canon a un número
        var rteIcaPropietario = document.getElementById('rte_ica1').value;
        var rteIca = (canonNumber * rteIcaPropietario) / 1000;
        document.getElementById('rte_ica2').value = rteIca.toFixed(2);

    }

    function updateIvaPropietario(canon) {
        var canonNumber = parseFloat(canon); // Convierte canon a un número
        var rteIvaPropietario = document.getElementById('rte_iva1').value;
        console.log(rteIvaPropietario);
        if (ivaPropietario === 1) {
            var ivaPropietario = document.getElementById('iva_con').value;
            var rteIvaProp = (ivaPropietario * 15) / 100;
            document.getElementById('rte_iva2').value = rteIvaProp.toFixed(2);
        } else {
            document.getElementById('rte_iva2').value = 0;
        }
    }

    function updateComisionPago(canon) {
        var canonNumber = parseFloat(canon); // Convierte canon a un número
        var comisionAplicaA = document.getElementById('comision_aplica_a').value;
        var comision1 = document.getElementById('comision1').value;
        var comision2 = document.getElementById('comision2').value;
        var acuerdo = document.getElementById('acuerdo').value;

        if (comisionAplicaA == 1) {
            canonNumber = canonNumber;
        }
        if (comisionAplicaA == 2) {
            canonNumber = document.getElementById('renta_con').value;
        }

        comision = 0;
        if (comision1 != 0 && comision2 <= 0 && acuerdo <= 0) {
            comision = (canonNumber * comision1) / 100;
            console.log("1");
        } else if (comision1 == 0 && comision2 > 0 && acuerdo <= 0) {
            comision = (canonNumber * comision2) / 100;
            console.log("2");

        } else if (comision1 == 1 && comision2 <= 0 && acuerdo > 0) {
            comision = acuerdo;
            console.log("3");
        }
        document.getElementById('comision_pago').value = comision;
    }

    function updateIvaInmobi() {
        var iva3 = document.getElementById('iva3').value;
        var iva4 = 0;
        console.log(iva3);
        if (iva3 == 1) {
            var comision = document.getElementById('comision_pago').value;
            iva4 = (comision * 0.19);
        }
        document.getElementById('iva4').value = iva4.toFixed(2);
    }

    function updateRteFteInmobi() {
        var rteFte3 = document.getElementById('rte_fte3').value;
        var rteFte4 = 0;
        if (rteFte3 != 0) {
            var comision = document.getElementById('comision_pago').value;
            rteFte4 = (comision * rteFte3) / 100;
        }
        document.getElementById('rte_fte4').value = rteFte4.toFixed(2);

    }

    function updateRteIcaInmobi() {
        var rteIca3 = document.getElementById('rte_ica3').value;
        var rteIca4 = 0;
        if (rteIca3 != 0) {
            var comision = document.getElementById('comision_pago').value;
            rteIca4 = (comision * rteIca3) / 1000;
        }
        document.getElementById('rte_ica4').value = rteIca4.toFixed(2);
    }

    function updateRteIvaInmobi() {
        var rteIva3 = document.getElementById('rte_iva3').value;
        var rteIva4 = 0;
        if (rteIva3 == 1) {
            var comision = document.getElementById('comision_pago').value;
            rteIva4 = (comision * 0.15);
        }
        document.getElementById('rte_iva4').value = rteIva4.toFixed(2);
    }

    function updateTotalConsignar() {
        var renta = document.getElementById('renta_con').value;
        var comision = document.getElementById('comision_pago').value;
        var total = renta - comision;
        document.getElementById('total_consignar_pago').value = total.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const comisionSelect = document.getElementById("comision1");
        const comisionInput = document.getElementById("comision2");
        const acuerdoInput = document.getElementById("acuerdo");

        comisionSelect.addEventListener("change", function() {
            if (this.value == "0") { // OTRO seleccionado
                comisionInput.readOnly = false;
                acuerdoInput.readOnly = true;
                acuerdoInput.value = ""; // Limpia el valor de acuerdo
            } else if (this.value == "1") { // ACUERDO seleccionado
                comisionInput.readOnly = true;
                acuerdoInput.readOnly = false;
                comisionInput.value = ""; // Limpia el valor de % comision
            } else {
                // Resto de opciones
                comisionInput.readOnly = true;
                acuerdoInput.readOnly = true;
                comisionInput.value = ""; // Limpia el valor de % comision
                acuerdoInput.value = ""; // Limpia el valor de acuerdo
            }
        });
    });
</script>
