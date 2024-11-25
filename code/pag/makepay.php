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
    if (isset($_GET['num_con'])) {
        $sql = mysqli_query($mysqli, "SELECT * FROM contratos WHERE num_con = '$num_con'");
        $row = mysqli_fetch_array($sql);
    }
    ?>

    <div class="container">
        <h1><img src='../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-money-check-dollar"></i> GENERAR PAGOS INMUEBLE</b></h1>
        <p><i><b>
                    <font size=3 color=#c68615>*Datos obligatorios</i></b></font>
        </p>

        <form action='makepay1.php?num_con=<?php echo $row['num_con']; ?>' enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <fieldset>
                    <legend>*** INFORMACIÓN INICIAL ***</legend>
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
                        <div class="col-12 col-sm-2">
                            <label for="pago_propietario">* PAGADO A:</label>
                            <select class="form-control" name="pago_propietario" required>
                                <option value=""></option>
                                <option value="Inmobiliaria">Inmobiliaria</option>
                                <option value="Propietario">Propietario</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="pago_a_inmobiliaria">INMOBILIARIA:</label>
                            <select class="form-control" name="pago_a_inmobiliaria" id="pago_a_inmobiliaria">
                                <option value=""></option>
                                <option value="Videco">Videco</option>
                                <option value="Raíces">Raíces</option>
                                <option value="Colbodegas">Colbodegas</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="metodo_pago">* METODO PAGO:</label>
                            <select class="form-control" name="metodo_pago" required>
                                <option value=""></option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Efectivo">Efectivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="factura_electronica0">* F.E. ARREND.</label>
                            <select class="form-control" name="factura_electronica0" id="factura_electronica0" required>
                                <option value=""></option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="factura_electronica1">FACT. VIDECO:</label>
                            <select class="form-control" name="factura_electronica1" id="factura_electronica1">
                                <option value=""></option>
                                <option value="Factura Electrónica">Factura Electrónica</option>
                                <option value="Orden de Pago">Orden de Pago</option>
                                <option value="NO">NO</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="factura_electronica2">FACT. PROPIETARIO:</label>
                            <select class="form-control" name="factura_electronica2" id="factura_electronica2">
                                <option value=""></option>
                                <option value="Factura Propietario">Factura Propietario</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <!-- Nuevo label y campo para "Cuenta de Cobro" -->
                        <div class="col-12 col-sm-2" id="cuentaCobroContainer" style="display:none;">
                            <label for="cuenta_cobro">Cuenta de Cobro:</label>
                            <input type="text" name="cuenta_cobro" id="cuenta_cobro" class="form-control" value="NO" readonly />
                        </div>
                        <div class="col-12 col-sm-2" id="facturaColbodegasContainer" style="display:none;">
                            <label for="factura_colbodegas">Factura Colbodegas:</label>
                            <select class="form-control" name="factura_colbodegas" id="factura_colbodegas">
                                <option value="NO">NO</option>
                                <option value="SI">SI</option>
                            </select>
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
                            <input type='number' name='canon_con' id="canon_con" class='form-control' value='<?php echo $row['canon_con']; ?>' readonly style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="iva_con">IVA $</label></strong>
                            <input type='number' name='iva_con' id="iva_con" class='form-control' value='<?php echo $row['iva_con']; ?>' readonly style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="admon_con">ADMINISTRACION $</label></strong>
                            <input type='number' name='admon_con' id="admon_con" class='form-control' value='<?php echo $row['admon_con']; ?>' readonly style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="renta_con">RENTA $</label></strong>
                            <input type='number' name='renta_con' id="renta_con" class='form-control' value='<?php echo $row['renta_con']; ?>' readonly style="font-weight:bold;" />
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
                            <select class="form-control" name="comision_aplica_a" required>
                                <option value=""></option>
                                <option value=1>Canon</option>
                                <option value=2>Renta</option>
                                <option value=3>Canon y Administracion</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="comision1">* COMISION:</label>
                            <select class="form-control" name="comision1" required>
                                <option value=""></option>
                                <option value=8>8%</option>
                                <option value=10>10%</option>
                                <option value=12>12%</option>
                                <option value=0>OTRO</option>
                                <option value=1>ACUERDO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="comision2">% COMISION:</label>
                            <input type='number' min='8.0' max='12.0' step='0.1' name='comision2' id='comision2' class='form-control' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="acuerdo">ACUERDO $</label>
                            <input type='number' name='acuerdo' id='acuerdo' class='form-control' />
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
                        <select class="form-control" name="rte_fte1" id="rte_fte1">
                            <option value=""></option>
                            <option value=3.5>3.5%</option>
                            <option value=4>4%</option>
                            <option value=10>10%</option>
                            <option value=20>20%</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_fte2">RTE FTE $</label></strong>
                        <input type='text' name='rte_fte2' id="rte_fte2" class='form-control' readonly style="font-weight:bold;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_ica1">RTE ICA</label>
                        <select class="form-control" name="rte_ica1" id="rte_ica1">
                            <option value=""></option>
                            <option value=7>7</option>
                            <option value=8>8</option>
                            <option value=9>9</option>
                            <option value=10>10</option>
                            <option value=0>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_ica2">RTE ICA $</label></strong>
                        <input type='text' name='rte_ica2' id="rte_ica2" class='form-control' readonly style="font-weight:bold;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_iva1">RTE IVA:</label>
                        <select class="form-control" name="rte_iva1" id="rte_iva1" required>
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_iva2">RTE IVA $</label></strong>
                        <input type='text' name='rte_iva2' id="rte_iva2" class='form-control' readonly style="font-weight:bold;" />
                    </div>
                </div>
            </div>

            <h4><strong>Impuestos Inmobiliaria:</strong></h4>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <strong><label for="comision_pago">COMISIÓN</label>
                            <input type='text' name='comision_pago' id="comision_pago" class='form-control comision-pago' readonly /></strong>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="iva3"> IVA:</label>
                        <select onchange="updateIvaInmobi()" class="form-control" name="iva3" id="iva3" required>
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="iva4">IVA $</label></strong>
                        <input type='text' name='iva4' id="iva4" class='form-control' readonly style="font-weight:bold;" />
                    </div>

                    <div class="col-12 col-sm-2">
                        <label for="rte_fte3">RTE FTE %</label>
                        <select class="form-control" name="rte_fte3" id="rte_fte3">
                            <option value=""></option>
                            <option value=3.5>3.5%</option>
                            <option value=4>4%</option>
                            <option value=10>10%</option>
                            <option value=11>11%</option>

                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_fte4">RTE FTE $</label></strong>
                        <input type='text' name='rte_fte4' id="rte_fte4" class='form-control' readonly style="font-weight:bold;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_ica1">RTE ICA</label>
                        <select class="form-control" name="rte_ica3" id="rte_ica3">
                            <option value=""></option>
                            <option value=7>7</option>
                            <option value=8>8</option>
                            <option value=9>9</option>
                            <option value=10>10</option>
                            <option value=0>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_ica2">RTE ICA $</label></strong>
                        <input type='text' name='rte_ica4' id="rte_ica4" class='form-control' readonly style="font-weight:bold;" />
                    </div>

                    <div class="col-12 col-sm-2">
                        <label for="rte_iva3">RTE IVA:</label>
                        <select onchange="updateRteIvaInmobi()" class="form-control" name="rte_iva3" id="rte_iva3" required onchange="updateRteIvaInmobi()" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <strong><label for="rte_iva4">RTE IVA $</label></strong>
                        <input type='text' name='rte_iva4' id="rte_iva4" class='form-control' readonly style="font-weight:bold;" />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                GENERAR PAGOS INMUEBLE
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>

</html>
<script>
    // Agregar un event listener para cuando se cambie la opción en "F.E. ARREND."
    document.getElementById('factura_electronica0').addEventListener('change', function() {
        var feArrend = this.value;

        // Obtener los otros dos selects
        var factVideco = document.getElementById('factura_electronica1');
        var factPropietario = document.getElementById('factura_electronica2');

        // Si "F.E. ARREND." es "NO"
        if (feArrend === 'NO') {
            factVideco.value = 'NO'; // Cambiar "FACT. VIDECO" a "NO"
            factPropietario.value = 'Factura Propietario'; // Cambiar "FACT. PROPIETARIO" a "Factura Propietario"
            factPropietario.removeAttribute('readonly'); // Quitar readonly si está
            factPropietario.removeAttribute('disabled'); // Habilitar el campo si estaba deshabilitado
        } else if (feArrend === 'SI') {
            factVideco.value = 'Factura Electrónica'; // Limpiar "FACT. VIDECO"
            factPropietario.value = 'N/A'; // Limpiar "FACT. PROPIETARIO"
            factPropietario.setAttribute('disabled', 'disabled'); // Deshabilitar el campo para que no se pueda interactuar
        } else if (feArrend === '') {
            factVideco.value = ''; // Limpiar "FACT. VIDECO"
            factPropietario.value = ''; // Limpiar "FACT. PROPIETARIO"
            factPropietario.removeAttribute('disabled'); // Habilitar el campo si estaba deshabilitado
        }
    });
    //inicio rte iva propietario
    document.getElementById('rte_iva1').addEventListener('change', function() {
        // Obtener el valor seleccionado del select (1 para Sí, 0 para No)
        var rteIvaOption = parseInt(this.value);
        var iva = <?= $row['iva_con']; ?>;
        console.log(rteIvaOption);
        // Verificar si se seleccionó "Sí" (valor 1)
        if (rteIvaOption === 1) {
            // Calcular el 15% de rete IVA
            var rteIvaAmount = iva * (15 / 100);

            // Mostrar el resultado en el campo de texto
            document.getElementById('rte_iva2').value = rteIvaAmount.toFixed(2);
        } else {
            // Si se selecciona "No" o no se selecciona nada, limpiar el campo de resultado
            document.getElementById('rte_iva2').value = '';
        }
    });
    //end rte iva propietario

    //inicio reteica propietario
    document.getElementById('rte_ica1').addEventListener('change', function() {
        // Obtener el valor seleccionado del select (el porcentaje)
        var rteIcaPercent = parseFloat(this.value);

        // El valor de canon_con que viene de PHP (puedes ajustar la variable según tu caso)
        var canonCon = <?= $row['canon_con']; ?>;

        // Verificar si se seleccionó un valor válido y que no sea N/A (valor 0)
        if (!isNaN(rteIcaPercent) && rteIcaPercent > 0) {
            // Calcular la retención ICA
            var rteIcaAmount = canonCon * (rteIcaPercent / 1000);

            // Mostrar el resultado en el campo de texto
            document.getElementById('rte_ica2').value = rteIcaAmount.toFixed(2);
        } else {
            // Si no se selecciona ningún valor válido, limpiar el campo de resultado
            document.getElementById('rte_ica2').value = '';
        }
    });
    //end reteica propietario

    //inicio rte fuentepropietario
    document.getElementById('rte_fte1').addEventListener('change', function() {
        // Obtener el valor seleccionado del select (el porcentaje)
        var rteFtePercent = parseFloat(this.value);

        // El valor de canon_con que viene de PHP
        var canonCon = <?= $row['canon_con']; ?>;
        // Verificar si se seleccionó un valor válido
        if (!isNaN(rteFtePercent)) {
            // Calcular la retención en la fuente
            var rteFteAmount = canonCon * (rteFtePercent / 100);

            // Mostrar el resultado en el campo de texto
            document.getElementById('rte_fte2').value = rteFteAmount.toFixed(2);
        } else {
            // Si no se selecciona ningún valor, limpiar el campo de resultado
            document.getElementById('rte_fte2').value = '';
        }
    });
    //end retefuente propietario


    $(document).ready(function() {
        // Deshabilitar campos "acuerdo" y "comision2" al inicio
        $('#acuerdo').prop('disabled', true);
        $('#comision2').prop('disabled', true);

        // Deshabilitar campo pago_a_inmobiliaria al inicio
        $('select[name="pago_a_inmobiliaria"]').prop('disabled', true);

        // Deshabilitar campo factura_electronica1 si iva_con > 0
        var ivaCon = parseFloat($('#iva_con').val());
        if (ivaCon > 0) {
            $('select[name="factura_electronica1"] option[value="Orden de Pago"]').prop('disabled', true);
        }

        // Habilitar campo pago_a_inmobiliaria si pago_propietario es Inmobiliaria
        $('select[name="pago_propietario"]').change(function() {
            var pagoPropietario = $(this).val();
            if (pagoPropietario === 'Inmobiliaria') {
                $('select[name="pago_a_inmobiliaria"]').prop('disabled', false);
            } else {
                $('select[name="pago_a_inmobiliaria"]').prop('disabled', true).val('');
            }
        });

        // Manejar activación de campos "acuerdo" y "comision2" basado en la selección de "comision1"
        $('select[name="comision1"]').change(function() {
            var comision1 = $(this).val();

            if (comision1 == 1) {
                $('#acuerdo').prop('disabled', false);
                $('#comision2').prop('disabled', true).val('');
            } else if (comision1 == 0) {
                $('#comision2').prop('disabled', false);
                $('#acuerdo').prop('disabled', true).val('');
            } else {
                $('#acuerdo, #comision2').prop('disabled', true).val('');
            }

            calcularComision();
        });

        // Calcular comision_pago en función de comision_aplica_a
        $('select[name="comision_aplica_a"], select[name="comision1"], #comision2, #acuerdo, #canon_con, #renta_con').change(function() {
            calcularComision();
        });

        function calcularComision() {
            var canonCon = parseFloat($('#canon_con').val());
            var rentaCon = parseFloat($('#renta_con').val());
            var admon_con = parseFloat($('#admon_con').val());
            var comision1 = parseFloat($('select[name="comision1"]').val());
            var comision2 = parseFloat($('#comision2').val());
            var acuerdo = parseFloat($('#acuerdo').val());
            var comisionAplicaA = $('select[name="comision_aplica_a"]').val();
            var comisionPago = 0;

            if (comision1 == 1 && !isNaN(acuerdo)) {
                // Caso: comision1 = 1
                comisionPago = acuerdo;
            } else if (comision1 == 0 && !isNaN(comision2)) {
                // Caso: comision1 = 0
                if (comisionAplicaA == 1 && !isNaN(canonCon)) {
                    comisionPago = canonCon * (comision2 / 100);
                } else if (comisionAplicaA == 2 && !isNaN(rentaCon)) {
                    comisionPago = rentaCon * (comision2 / 100);
                } else if (comisionAplicaA == 3 && !isNaN(canonCon)) {
                    comisionPago = (canonCon + admon_con) * (comision2 / 100);
                }
            } else if (comision1 != 0 && comision1 != 1) {
                // Caso: comision1 diferente de 0 y 1
                if (comisionAplicaA == 1 && !isNaN(canonCon)) {
                    comisionPago = canonCon * (comision1 / 100);
                } else if (comisionAplicaA == 2 && !isNaN(rentaCon) && !isNaN(comision1)) {
                    comisionPago = rentaCon * (comision1 / 100);
                } else if (comisionAplicaA == 3 && !isNaN(canonCon) && !isNaN(comision1)) {
                    comisionPago = (canonCon + admon_con) * (comision1 / 100);
                }
            }

            $('#comision_pago').val('$' + comisionPago.toLocaleString('es-CO', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }

        calcularComision(); // Calcular comisión al cargar la página
    });

    // Mostrar u ocultar campo "Cuenta de Cobro" basado en la selección de "factura_electronica1"
    document.getElementById('pago_a_inmobiliaria').addEventListener('change', function() {
        var inmobiliaria = this.value;

        // Obtener los selects que necesitas deshabilitar
        var factVideco = document.getElementById('factura_electronica1'); // FACT. VIDECO
        var factPropietario = document.getElementById('factura_electronica2'); // FACT. PROPIETARIO
        var feArrend = document.getElementById('factura_electronica0'); // F.E. ARREND.

        // Ocultar el contenedor de cuenta de cobro
        document.getElementById('cuentaCobroContainer').style.display = 'none';

        // Mostrar/ocultar según la opción seleccionada
        if (inmobiliaria === 'Raíces') {
            // Deshabilitar los selects
            factVideco.setAttribute('disabled', 'disabled');
            factPropietario.setAttribute('disabled', 'disabled');
            feArrend.setAttribute('disabled', 'disabled'); // Deshabilitar también F.E. ARREND.

            // Mostrar el campo "Cuenta de Cobro" y establecer su valor a "SI"
            var cuentaCobro = document.getElementById('cuenta_cobro');
            cuentaCobro.value = 'SI'; // Establecer el valor a "SI"
            cuentaCobro.setAttribute('readonly', 'readonly'); // Asegurarse que sea readonly
            document.getElementById('cuentaCobroContainer').style.display = 'block';

            // Ocultar el select de factura Colbodegas
            document.getElementById('facturaColbodegasContainer').style.display = 'none';

        } else if (inmobiliaria === 'Colbodegas') {
            // Habilitar los selects si es Colbodegas
            factVideco.removeAttribute('disabled');
            factPropietario.removeAttribute('disabled');
            feArrend.removeAttribute('disabled'); // Habilitar F.E. ARREND.

            // Mostrar el campo de Factura Colbodegas
            document.getElementById('facturaColbodegasContainer').style.display = 'block';

            // Cambiar el valor por defecto a "SI"
            var facturaColbodegas = document.getElementById('factura_colbodegas');
            facturaColbodegas.value = 'SI'; // Establecer valor a "SI"

        } else {
            // Habilitar los selects si no es Raíces o Colbodegas
            factVideco.removeAttribute('disabled');
            factPropietario.removeAttribute('disabled');
            feArrend.removeAttribute('disabled'); // Habilitar F.E. ARREND.

            // Restablecer el valor de "Cuenta de Cobro" a "NO" y ocultar el campo
            var cuentaCobro = document.getElementById('cuenta_cobro');
            cuentaCobro.value = 'NO'; // Restablecer a "NO"
            cuentaCobro.removeAttribute('readonly'); // Quitar readonly
            document.getElementById('cuentaCobroContainer').style.display = 'none';

            // Ocultar el campo de Factura Colbodegas
            document.getElementById('facturaColbodegasContainer').style.display = 'none';
        }
    });

    //rte fuente inmobiliaria
    document.getElementById('rte_fte3').addEventListener('change', function() {
        // Obtener el valor de la comisión
        let comisionRaw = document.getElementById('comision_pago').value;
        // Limpiar el formato de moneda (quitar $, puntos y comas)
        let comision = comisionRaw.replace(/[.$]/g, '').replace(',', '.').replace('$', '');
        // Convertir la comisión a un número
        comision = parseFloat(comision);
        // Obtener el porcentaje seleccionado en RTE FTE
        const rtePorcentaje = parseFloat(this.value);

        // Si hay un valor válido seleccionado
        if (!isNaN(rtePorcentaje) && !isNaN(comision)) {
            // Calcular la retención en la fuente (RTE FTE $)
            const rteFte = comision * (rtePorcentaje / 100);
            console.log(rteFte);
            // Colocar el resultado en el campo de RTE FTE $
            document.getElementById('rte_fte4').value = rteFte.toFixed(2); // Formato con 2 decimales
        } else {
            // Limpiar el campo si no hay un valor seleccionado
            document.getElementById('rte_fte4').value = '';
            console.log("no entro");
        }
    });
    //end rte fuente inmobiliaria

    //rte ica inmobiliaria
    document.getElementById('rte_ica3').addEventListener('change', function() {
        // Obtener el valor de la comisión y limpiarlo
        let comisionRaw = document.getElementById('comision_pago').value;

        // Limpiar el formato de moneda (quitar $, puntos y comas)
        let comision = comisionRaw.replace(/[.$]/g, '').replace(',', '.').replace('$', '');

        // Convertir la comisión a un número
        comision = parseFloat(comision);

        // Obtener el porcentaje seleccionado en RTE ICA
        const rteIca = parseFloat(this.value);

        // Si hay un valor válido seleccionado
        if (!isNaN(rteIca) && !isNaN(comision)) {
            // Calcular la retención en la fuente (RTE ICA $)
            const rteIcaValor = (comision * rteIca) / 1000;
            // Colocar el resultado en el campo de RTE ICA $
            document.getElementById('rte_ica4').value = rteIcaValor.toFixed(2); // Formato con 2 decimales
        } else {
            // Limpiar el campo si no hay un valor seleccionado
            document.getElementById('rte_ica4').value = '';
        }
    });
    //end rte ica inmobiliaria
    function updateIvaInmobi(){
        // Obtener el valor de la comisión
        let comisionRaw = document.getElementById('comision_pago').value;
        let iva = document.getElementById('iva3').value;
        // Limpiar el formato de moneda (quitar $, puntos y comas)
        let comision = comisionRaw.replace(/[.$]/g, '').replace(',', '.').replace('$', '');
        // Convertir la comisión a un número
        comision = parseFloat(comision);
        // Obtener el porcentaje seleccionado en IVA
        // Si hay un valor válido seleccionado
        if ( !isNaN(comision) && iva == 1) {
            // Calcular el IVA
            const ivaValor = comision * (19 / 100);
            // Colocar el resultado en el campo de IVA $
            document.getElementById('iva4').value = ivaValor.toFixed(2); // Formato con 2 decimales
        } else {

            // Limpiar el campo si no hay un valor seleccionado
            document.getElementById('iva4').value = '';
        }
    }
    function updateRteIvaInmobi(){
        // Obtener el valor de la comisión
        let comision = document.getElementById('iva4').value;
        let rteIva = document.getElementById('rte_iva3').value;
        // Si hay un valor válido seleccionado
        if ( !isNaN(comision) && rteIva == 1) {
            // Calcular el RTE IVA
            const rteIvaValor = comision * (15 / 100);
            // Colocar el resultado en el campo de RTE IVA $
            document.getElementById('rte_iva4').value = rteIvaValor.toFixed(2); // Formato con 2 decimales
        } else {
            // Limpiar el campo si no hay un valor seleccionado
            document.getElementById('rte_iva4').value = '';
        }
    }


</script>
