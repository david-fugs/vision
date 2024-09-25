<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //echo "Formulario recibido";
    //var_dump($_POST);
    $id_pago = $_POST['id_pago'];
    $fecha_pago_realizado = $_POST['fecha_pago_realizado'];
    $valor_pagado = $_POST['valor_pagado'];
    $adecuaciones = isset($_POST['adecuaciones']) ? $_POST['adecuaciones'] : 0;
    $deposito = isset($_POST['deposito']) ? $_POST['deposito'] : 0;
    $observaciones_diferencia = isset($_POST['observaciones_diferencia']) ? $_POST['observaciones_diferencia'] : '';
    $propietarios = $_POST['propietarios'];
    $propietarios_monto = $_POST['propietarios_monto'];
    $pago_comision = $_POST['pago_comision'];

    // Validar entrada numérica
    $adecuaciones = is_numeric($adecuaciones) ? $adecuaciones : 0;
    $deposito = is_numeric($deposito) ? $deposito : 0;

    // Obtener la información del pago
    $query = "SELECT renta_con, comision_pago, total_consignar_pago FROM pagos WHERE id_pago = $id_pago";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $renta_con = $row['renta_con'];
        $comision_pago = $row['comision_pago'];
        $total_consignar_pago = $row['total_consignar_pago'];

        // Calcular la diferencia
        $diferencia = $renta_con - $valor_pagado;

        // Insertar el pago realizado en la tabla pagos_realizados
        $insert_query = "INSERT INTO pagos_realizados (id_pago, fecha_pago_realizado, valor_pagado, diferencia, adecuaciones, deposito, observaciones_diferencia, comision_pago, comision_pendiente) 
                         VALUES ($id_pago, '$fecha_pago_realizado', $valor_pagado, $diferencia, $adecuaciones, $deposito, '$observaciones_diferencia', 
                         " . ($pago_comision == '1' ? $comision_pago : 0) . ", " . ($pago_comision == '0' ? $comision_pago : 0) . ")";
        if ($mysqli->query($insert_query)) {
            $id_pago_realizado = $mysqli->insert_id;

            // Insertar los detalles de los propietarios
            foreach ($propietarios as $index => $propietario_id) {
                $monto = $propietarios_monto[$index];
                $insert_propietario_query = "INSERT INTO pagos_propietarios (id_pago_realizado, nit_cc_pro, monto) 
                                             VALUES ($id_pago_realizado, $propietario_id, $monto)";
                $mysqli->query($insert_propietario_query);
            }

            header("Location: pago_satisfactorio.htm");
            exit();
        } else {
            echo "Error al registrar el pago: " . $mysqli->error;
        }
    } else {
        echo "Pago no encontrado.";
    }
} else {
    if (isset($_GET['id_pago'])) {
        $id_pago = $_GET['id_pago'];
        $query = "SELECT * FROM pagos WHERE id_pago = $id_pago";
        $result = $mysqli->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Pago no encontrado.";
            exit();
        }
    } else {
        echo "ID de pago no especificado.";
        exit();
    }
}

// Obtener la lista de propietarios relacionados con la propiedad
$query_propietarios = "SELECT propietarios.nit_cc_pro, propietarios.nom_ape_pro 
                       FROM propiedades 
                       INNER JOIN propietarios ON propiedades.nit_cc_pro = propietarios.nit_cc_pro 
                       INNER JOIN inmuebles ON propiedades.mat_inm = inmuebles.mat_inm 
                       INNER JOIN contratos ON inmuebles.mat_inm = contratos.mat_inm 
                       WHERE contratos.num_con = (SELECT num_con FROM pagos WHERE id_pago = $id_pago)";
$result_propietarios = $mysqli->query($query_propietarios);
$propietarios = [];
while ($propietario = $result_propietarios->fetch_assoc()) {
    $propietarios[] = $propietario;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VISION | SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/popper.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
        .selector-for-some-widget {
            box-sizing: content-box;
        }
        .text-green {
            color: green;
            font-weight: bold;
        }
        .text-red {
            color: red;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-control {
            margin-bottom: .5rem;
        }
        .highlight-message {
            background-color: black;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 1.1em;
        }
        .highlight-total {
            font-size: 1.2em;
            font-weight: bold;
        }
        .form-control-bold {
            font-weight: bold;
        }
        .radio-group {
            display: flex;
            align-items: center;
        }
        .radio-group label {
            margin-right: 10px;
        }
        .radio-group .form-check {
            margin-right: 15px;
        }
    </style>
</head>
<body>

<center>
    <img src='../../img/logo.png' width="300" height="212" class="responsive">
</center>

<h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class='fa-solid fa-money-check-dollar'></i> APLICAR PAGO TOTAL</b></h1>

<div class="container">
    <form id="payment-form" action="makepay2.php" method="post">
        <input type="hidden" name="id_pago" value="<?php echo $id_pago; ?>">

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <label for="renta_con"><strong>Valor de Renta $</strong></label>
                    <input type="text" class="form-control form-control-bold" id="renta_con" value="<?php echo number_format($row['renta_con'], 2, ',', '.'); ?> COP" readonly>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="comision_pago"><strong>Comisión $</strong></label>
                    <input type="text" class="form-control form-control-bold" id="comision_pago" value="<?php echo number_format($row['comision_pago'], 2, ',', '.'); ?> COP" readonly>
                </div>
                <div class="col-12 col-sm-3 radio-group">
                    <label><strong>¿Pagó comisión?</strong></label>
                    <div class="form-check radio-green">
                        <input class="form-check-input" type="radio" name="pago_comision" id="pago_comision_si" value="1" required>
                        <label class="form-check-label" for="pago_comision_si">Sí</label>
                    </div>
                    <div class="form-check radio-red">
                        <input class="form-check-input" type="radio" name="pago_comision" id="pago_comision_no" value="0" required>
                        <label class="form-check-label" for="pago_comision_no">No</label>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="total_consignar_pago"><strong>Total a Consignar $</strong></label>
                    <input type="text" class="form-control form-control-bold" id="total_consignar_pago" value="<?php echo number_format($row['total_consignar_pago'], 2, ',', '.'); ?> COP" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-2">
                    <label for="fecha_pago_realizado">Fecha de Pago:</label>
                    <input type="date" class="form-control" id="fecha_pago_realizado" name="fecha_pago_realizado" required>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="valor_pagado">Valor Pagado $</label>
                    <input type="number" step="0.01" class="form-control form-control-bold" id="valor_pagado" name="valor_pagado" required>
                    <div id="valor_pagado_error" class="text-red font-weight-bold" style="display: none;">Valor superior a Valor Renta, por favor corrija.</div>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="diferencia"><strong>Diferencia $</strong></label>
                    <input type="text" class="form-control" id="diferencia" name="diferencia" readonly>
                </div>
                <div class="col-12 col-sm-2">
                    <label for="adecuaciones">Adecuaciones $</label>
                    <input type="number" step="0.01" class="form-control" id="adecuaciones" name="adecuaciones" value="0">
                </div>
                <div class="col-12 col-sm-2">
                    <label for="deposito">Depósito $</label>
                    <input type="number" step="0.01" class="form-control" id="deposito" name="deposito" value="0">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <label for="observaciones_diferencia">Observaciones Diferencia:</label>
                    <input type="text" class="form-control" id="observaciones_diferencia" name="observaciones_diferencia" disabled>
                </div>
            </div>
        </div>

        <hr style="border: 4px solid #FA8B07; border-radius: 4px;">
        <div class="form-group">
            <label for="propietarios"><strong>Distribución entre Propietarios:</strong></label>
            <div id="propietarios">
                <div class="row propietario-row">
                    <div class="col-12 col-sm-5">
                        <label for="propietario_1">Propietario:</label>
                        <select class="form-control" id="propietario_1" name="propietarios[]" required>
                            <?php foreach ($propietarios as $propietario) : ?>
                                <option value="<?php echo $propietario['nit_cc_pro']; ?>"><?php echo $propietario['nom_ape_pro']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="monto_1">Monto $</label>
                        <input type="number" step="0.01" class="form-control propietario-monto" id="monto_1" name="propietarios_monto[]" required>
                    </div>
                    <div class="col-12 col-sm-2">
                        <button type="button" class="btn btn-danger remove-propietario mt-4">Eliminar</button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-propietario" class="btn btn-secondary mt-2">Agregar Propietario</button>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label for="total_monto"><strong>Total Monto Distribuido $</strong></label>
                    <input type="text" class="form-control highlight-total" id="total_monto" name="total_monto" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div id="monto_error" class="highlight-message" style="display: none;">Por favor verifique el monto a pagar por cada propietario, dado que, alguno es superior al valor a consignar.</div>
                </div>
            </div>
        </div>
        <hr style="border: 4px solid #FA8B07; border-radius: 4px;">

        <button type="submit" class="btn btn-primary" onclick="validateForm()">Registrar Pago Arrendamiento</button>
        <a href="showpay1.php" class="btn btn-outline-dark">Regresar</a>
    </form>
</div>

<script>
    function formatCurrency(amount) {
        return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'COP' }).format(amount);
    }

    function updateDiferencia() {
        var valorRenta = parseFloat(document.getElementById('renta_con').value.replace(/\./g, '').replace(',', '.'));
        var valorPagado = parseFloat(document.getElementById('valor_pagado').value);
        var diferencia = valorRenta - valorPagado;

        var diferenciaInput = document.getElementById('diferencia');
        diferenciaInput.value = formatCurrency(diferencia);

        if (diferencia < 0) {
            diferenciaInput.classList.add('text-red');
            diferenciaInput.classList.remove('text-green');
        } else if (diferencia === 0) {
            diferenciaInput.classList.add('text-green');
            diferenciaInput.classList.remove('text-red');
        } else {
            diferenciaInput.classList.remove('text-green', 'text-red');
        }
    }

    function updateTotalMonto() {
        var totalConsignarPago = parseFloat(document.getElementById('total_consignar_pago').value.replace(/\./g, '').replace(',', '.'));
        var adecuaciones = parseFloat(document.getElementById('adecuaciones').value) || 0;
        var totalMonto = totalConsignarPago - adecuaciones;

        var totalMontoInput = document.getElementById('total_monto');
        totalMontoInput.value = formatCurrency(totalMonto);

        var totalPropietarios = 0;
        document.querySelectorAll('.propietario-monto').forEach(function(input) {
            totalPropietarios += parseFloat(input.value) || 0;
        });

        var montoError = document.getElementById('monto_error');
        if (totalPropietarios > totalMonto) {
            montoError.style.display = 'block';
            totalMontoInput.classList.add('text-red');
            document.querySelectorAll('.propietario-monto').forEach(function(input) {
                if (parseFloat(input.value) > totalMonto) {
                    input.value = 0;
                }
            });
        } else {
            montoError.style.display = 'none';
            totalMontoInput.classList.remove('text-red');
        }
    }

    function validateForm() {
        console.log("Validating form...");
        var valorRenta = parseFloat(document.getElementById('renta_con').value.replace(/\./g, '').replace(',', '.'));
        var valorPagado = parseFloat(document.getElementById('valor_pagado').value);
        var valorPagadoError = document.getElementById('valor_pagado_error');

        if (valorPagado > valorRenta) {
            valorPagadoError.style.display = 'block';
            document.getElementById('valor_pagado').value = 0;
            return false;
        } else {
            valorPagadoError.style.display = 'none';
        }

        return updateTotalMonto();
    }

    document.getElementById('valor_pagado').addEventListener('input', function() {
        updateDiferencia();
        validateForm();
    });

    document.getElementById('add-propietario').addEventListener('click', function() {
        var propietariosDiv = document.getElementById('propietarios');
        var newPropietarioIndex = propietariosDiv.children.length + 1;

        var newPropietarioDiv = document.createElement('div');
        newPropietarioDiv.classList.add('row', 'propietario-row', 'mt-2');
        newPropietarioDiv.innerHTML = `
            <div class="col-12 col-sm-5">
                <label for="propietario_${newPropietarioIndex}">Propietario:</label>
                <select class="form-control" id="propietario_${newPropietarioIndex}" name="propietarios[]" required>
                    <?php foreach ($propietarios as $propietario) : ?>
                        <option value="<?php echo $propietario['nit_cc_pro']; ?>"><?php echo $propietario['nom_ape_pro']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-sm-5">
                <label for="monto_${newPropietarioIndex}">Monto:</label>
                <input type="number" step="0.01" class="form-control propietario-monto" id="monto_${newPropietarioIndex}" name="propietarios_monto[]" required>
            </div>
            <div class="col-12 col-sm-2">
                <button type="button" class="btn btn-danger remove-propietario mt-4">Eliminar</button>
            </div>
        `;

        propietariosDiv.appendChild(newPropietarioDiv);

        // Add event listener for remove button
        newPropietarioDiv.querySelector('.remove-propietario').addEventListener('click', function() {
            this.closest('.propietario-row').remove();
            updateTotalMonto();
        });

        newPropietarioDiv.querySelector('.propietario-monto').addEventListener('input', function() {
            updateTotalMonto();
            validateForm();
        });
    });

    document.querySelectorAll('.propietario-monto').forEach(function(input) {
        input.addEventListener('input', function() {
            updateTotalMonto();
            validateForm();
        });
    });

    document.getElementById('adecuaciones').addEventListener('input', function() {
        updateTotalMonto();
        validateForm();
    });

    document.getElementById('deposito').addEventListener('input', function() {
        var observacionesDiferenciaInput = document.getElementById('observaciones_diferencia');
        if (parseFloat(this.value) > 0) {
            observacionesDiferenciaInput.disabled = false;
        } else {
            observacionesDiferenciaInput.disabled = true;
            observacionesDiferenciaInput.value = '';
        }
    });

    document.querySelectorAll('.remove-propietario').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('.propietario-row').remove();
            updateTotalMonto();
            validateForm();
        });
    });
</script>

</body>
</html>
