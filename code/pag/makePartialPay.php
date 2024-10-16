<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}
ini_set('display_errors', 1);  // Habilita la visualización de errores
ini_set('display_startup_errors', 1);  // Habilita la visualización de errores de inicio
error_reporting(E_ALL);  // Reporta todos los tipos de errores

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];

include("../../conexion.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tipos_gasto = $_POST['tipo_gasto'];
    $valores_gasto = $_POST['valor_gasto'];
    $observaciones_gasto = $_POST['observaciones_gasto'];
    $id_pago = $_POST['id_pago'];
    $valor_anterior_pagado = isset($_POST['valor_anterior_pagado']) ? $_POST['valor_anterior_pagado'] : 0;
    $fecha_pago_realizado = $_POST['fecha_pago_realizado'];
    $valor_pagado = $_POST['valor_pagado'];
    // $afianzamiento = isset($_POST['afianzamiento']) ? str_replace('.', '', $_POST['afianzamiento']) : 0;
    // $adecuaciones = isset($_POST['adecuaciones']) ? str_replace('.', '', $_POST['adecuaciones']) : 0;
    //  $deposito = isset($_POST['deposito']) ? str_replace('.', '', $_POST['deposito']) : 0;
    $rte_fte1_prop = isset($_POST['rte_fte1']) && $_POST['rte_fte1'] !== '' ? $_POST['rte_fte1'] : 0;
    $rte_fte2_prop = isset($_POST['rte_fte2']) && $_POST['rte_fte2'] !== '' ? $_POST['rte_fte2'] : 0;
    $rte_ica1_prop = isset($_POST['rte_ica1']) && $_POST['rte_ica1'] !== '' ? $_POST['rte_ica1'] : 0;
    $rte_ica2_prop = isset($_POST['rte_ica2']) && $_POST['rte_ica2'] !== '' ? $_POST['rte_ica2'] : 0;
    $rte_iva1_prop = isset($_POST['rte_iva1']) && $_POST['rte_iva1'] !== '' ? $_POST['rte_iva1'] : 0;
    $rte_iva2_prop = isset($_POST['rte_iva2']) && $_POST['rte_iva2'] !== '' ? $_POST['rte_iva2'] : 0;
    $rte_fte3_inmobi = isset($_POST['rte_fte3']) && $_POST['rte_fte3'] !== '' ? $_POST['rte_fte3'] : 0;
    $rte_fte4_inmobi = isset($_POST['rte_fte4']) && $_POST['rte_fte4'] !== '' ? $_POST['rte_fte4'] : 0;
    $rte_ica3_inmobi = isset($_POST['rte_ica3']) && $_POST['rte_ica3'] !== '' ? $_POST['rte_ica3'] : 0;
    $rte_ica4_inmobi = isset($_POST['rte_ica4']) && $_POST['rte_ica4'] !== '' ? $_POST['rte_ica4'] : 0;
    $iva_valor = isset($_POST['iva_con']) && $_POST['iva_con'] !== '' ? $_POST['iva_con'] : 0;
    $rte_iva_aplica_inmobi = isset($_POST['rte_iva_aplica_inmobi']) && $_POST['rte_iva_aplica_inmobi'] !== '' ? $_POST['rte_iva_aplica_inmobi'] : 0;
    $rte_iva_inmobi = isset($_POST['rte_iva_inmobi']) && $_POST['rte_iva_inmobi'] !== '' ? $_POST['rte_iva_inmobi'] : 0;
    $pagado_a = $_POST['pagado_a'];
    $observaciones_diferencia = isset($_POST['observaciones_diferencia']) ? $_POST['observaciones_diferencia'] : '';
    $propietarios = $_POST['propietarios'];
    $propietarios_monto = $_POST['propietarios_monto'];
    $pago_comision = $_POST['pago_comision'];
    $id_usu = $_SESSION['id_usu'];
    $diferencia = (int)str_replace(['.', ',', 'COP', ' '], '', $_POST['diferencia']) / 100;


    if ($valor_anterior_pagado > 0) {
        $valor_pagado = $valor_pagado + $valor_anterior_pagado;
        $sql_update = "UPDATE pagos_realizados SET valor_pagado = $valor_pagado, fecha_pago_parcial  = $fecha_pago_realizado, diferencia = $diferencia WHERE id_pago = $id_pago";
          // Ejecutar la consulta y verificar errores
          if (!$mysqli->query($sql_update)) {
            echo "Error en la consulta: " . $mysqli->error;
            die;
        }
     else {
        header("Location: pago_satisfactorio.htm");
    }

    } else {
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
            $insert_query = "INSERT INTO pagos_realizados (
            id_pago, fecha_pago_realizado, valor_pagado, diferencia, adecuaciones, deposito, afianzamiento,
            observaciones_diferencia, comision_pago, comision_pendiente,pago_comision,
            rte_fte1_prop, rte_fte2_prop, rte_ica1_prop, rte_ica2_prop, rte_iva1_prop, rte_iva2_prop,
            rte_fte3_inmobi, rte_fte4_inmobi, rte_ica3_inmobi, rte_ica4_inmobi, pagado_a
        )
      VALUES (
        $id_pago,
        '$fecha_pago_realizado',
        $valor_pagado,
        $diferencia,
        0,
        0,
        0,
        '$observaciones_diferencia',
        " . ($pago_comision == '1' ? $comision_pago : 0) . ",
        " . ($pago_comision == '0' ? $comision_pago : 0) . ",
        $pago_comision,
        " . (isset($rte_fte1_prop) ? $rte_fte1_prop : 'NULL') . ",
        " . (isset($rte_fte2_prop) ? $rte_fte2_prop : 'NULL') . ",
        $rte_ica1_prop,
        $rte_ica2_prop,
        $rte_iva1_prop,
        $rte_iva2_prop,
        $rte_fte3_inmobi,
        $rte_fte4_inmobi,
        $rte_ica3_inmobi,
        $rte_ica4_inmobi,
        '$pagado_a'
      )";
            if ($mysqli->query($insert_query)) {
                $id_pago_realizado = $mysqli->insert_id;
                // Insertar los gastos en la tabla gastos
                // Inicializar un array para almacenar los gastos
                $gastos_array = [];

                // Recorre cada tipo de gasto
                foreach ($tipos_gasto as $index => $tipo_gasto) {
                    $valor_gasto = isset($valores_gasto[$index]) ? str_replace('.', '', $valores_gasto[$index]) : 0;
                    $observacion_gasto = isset($observaciones_gasto[$index]) ? $observaciones_gasto[$index] : '';
                    // Concatenar el tipo de gasto, valor y observación
                    $gastos_array[] = "$tipo_gasto: $$valor_gasto  ($observacion_gasto)";
                }
                // Asegúrate de que $id_pago_realizado sea válido
                if (isset($id_pago_realizado)) {
                    // Convertir el array en una cadena separada por comas
                    $gastos_string = implode(', ', $gastos_array);

                    // Actualizar la tabla pagos_realizados una sola vez
                    $insert_gasto_query = "UPDATE pagos_realizados SET
                    gastos = '$gastos_string'
                    WHERE id_pago_realizado = $id_pago_realizado";

                    // Ejecutar la consulta y verificar errores
                    if (!$mysqli->query($insert_gasto_query)) {
                        echo "Error en la consulta: " . $mysqli->error;
                        die;
                    }
                } else {
                    echo "Error: id_pago_realizado no está definido." . $id_pago_realizado;
                }
                foreach ($propietarios as $index => $propietario_id) {
                    $monto = $propietarios_monto[$index];
                    // Corregir la consulta para que sea un UPDATE correcto
                    $insert_propietario_query = "INSERT INTO pagos_propietarios (id_pago_realizado, nit_cc_pro, monto)
                                              VALUES ($id_pago_realizado, $propietario_id, $monto)";
                    // Ejecutar la consulta y verificar si se insertó correctamente
                    if ($mysqli->query($insert_propietario_query) === TRUE) {
                        // Puedes manejar el caso de éxito si es necesario
                        echo "Detalles del propietario insertados correctamente para el propietario ID: $propietario_id.<br>";
                    } else {
                        // Manejo de error si la inserción falla
                        echo "Error al insertar detalles del propietario ID: $propietario_id - " . $mysqli->error . "<br>";
                    }
                }
                $sql_pip = "INSERT INTO pagos_impuestos_propietario( id_pago,ret_fte_porc_pip, ret_fte_valor_pip,ret_ica_porc_pip ,ret_ica_valor_pip, ret_iva_valor_pip, obs_pip, estado_pip,fecha_alta_pip,id_usu_alta_pip , id_usu )
            VALUES( $id_pago, $rte_fte1_prop, $rte_fte2_prop, $rte_ica1_prop, $rte_ica2_prop, $rte_iva2_prop, '$observaciones_diferencia', 1, now(),$id_usu , $id_usu )";             // Ejecutar la consulta y verificar si hay error
                if ($mysqli->query($sql_pip) === TRUE) {
                    header("Location: pago_satisfactorio.htm");
                } else {
                    // Mostrar el error
                    echo "Error en la consulta: " . $mysqli->error;
                }
                $sql_pii = "INSERT INTO pagos_impuestos_inmobiliaria( id_pago,iva_valor_pii ,ret_iva_aplica_pii,ret_iva_valor_pii,comision_valor_pii, ret_fte_porc_pii, ret_fte_valor_pii, ret_ica_porc_pii, ret_ica_valor_pii, obs_pii, estado_pii, fecha_alta_pii, id_usu_alta_pii, id_usu )
            VALUES( $id_pago,$iva_valor, $rte_iva_aplica_inmobi, $rte_iva_inmobi ,$comision_pago, $rte_fte3_inmobi, $rte_fte4_inmobi, $rte_ica3_inmobi, $rte_ica4_inmobi, 0, 1, now(), $id_usu, $id_usu )";
                //verificar si hay error
                if ($mysqli->query($sql_pii) === TRUE) {
                    header("Location: pago_satisfactorio.htm");
                } else {
                    // Mostrar el error
                    echo "Error en la consulta: " . $mysqli->error;
                }

                header("Location: pago_satisfactorio.htm");
                exit();
            } else {
                echo "Error al registrar el pago: " . $mysqli->error;
            }
        } else {
            echo "Pago no encontrado.";
        }
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

$sql_pago = "SELECT pagos_realizados.*, pagos.renta_con FROM pagos_realizados
JOIN pagos ON pagos.id_pago = pagos_realizados.id_pago
 WHERE pagos_realizados.id_pago = $id_pago";
$result_pago = $mysqli->query($sql_pago);
$pago_data = [];
if ($result_pago && $result_pago->num_rows > 0) {
    if ($result_pago && $result_pago->num_rows > 0) {
        $pago_data = $result_pago->fetch_assoc();
    }
}
if ($pago_data != [])  $consignar = $pago_data['renta_con'] -  $pago_data['valor_pagado'];
else $consignar = $row['renta_con'];
print_r($pago_data);
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

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class='fa-solid fa-money-check-dollar'></i> APLICAR PAGO PARCIAL</b></h1>

    <div class="container">
        <form id="payment-form" action="makePartialPay.php" method="post">
            <input type="hidden" name="id_pago" value="<?php echo $id_pago; ?>">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="renta_con"><strong>Valor de Renta $</strong></label>
                        <input type="text" class="form-control form-control-bold" id="renta_con" value="<?php echo number_format($row['renta_con'], 2, ',', '.'); ?> COP" readonly>
                    </div>
                    <div class="col-12 col-sm-3">
                        <?php $acuerdo = intval($row['acuerdo']); ?>
                        <label for="comision_pago"><strong>Comisión $</strong></label>
                        <input type="text" class="form-control form-control-bold" id="comision_pago" value="
                        <?php
                        if ($acuerdo > 0) $row['comision_pago'] = $acuerdo;
                        else echo number_format($row['comision_pago'], 2, ',', '.'); ?> COP" readonly>
                    </div>
                    <div class="col-12 col-sm-3 radio-group">
                        <label><strong>¿Pagó comisión?</strong></label>
                        <div style="display:flex; align-items:center; justify-content: space-around;" class="form-check radio-green">
                            <input class="form-check-input" type="radio" name="pago_comision" id="pago_comision_si" value="1"
                                <?php if (isset($pago_data['pago_comision']) && $pago_data['pago_comision'] == 1) echo "checked"; ?>
                                <?php if ($pago_data != []) echo "disabled"; ?> required>
                            <label class="form-check-label" for="pago_comision_si">Sí</label>
                        </div>
                        <div style="display:flex; align-items:center; justify-content: space-around;" class="form-check radio-red">
                            <input class="form-check-input" type="radio" name="pago_comision" id="pago_comision_no" value="0"
                                <?php if (isset($pago_data['pago_comision']) && $pago_data['pago_comision'] == 0) echo "checked"; ?>
                                <?php if ($pago_data != []) echo "disabled"; ?> required>
                            <label style="padding-left: 35px;" class="form-check-label" for="pago_comision_no">No</label>
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
                    <div class="col-12 col-sm-4">
                        <label for="pagado_a">Pagado a:</label>
                        <select class="form-control" name="pagado_a" required>
                            <option value=""></option>
                            <option <?php if ($row['pagado_a'] == "Inmobiliaria")  echo "selected";  ?> value="Inmobiliaria">Inmobiliaria</option>
                            <option <?php if ($row['pagado_a'] == "Propietario")  echo "selected";  ?> value="Propietario">Propietario</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-4">
                        <label for="valor_pagado">Valor que ha sido pagado $</label>
                        <input type="number" step="0.01" class="form-control form-control-bold" id="valor_anterior_pagado" name="valor_anterior_pagado" value="<?php echo isset($pago_data['valor_pagado']) ? $pago_data['valor_pagado'] : ''; ?>"
                            readonly required>
                        <div id="valor_pagado_error" class="text-red font-weight-bold" style="display: none;">Valor superior a Valor Renta, por favor corrija.</div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="valor_pagado">Valor Pagado $</label>
                        <input type="number" step="0.01" class="form-control form-control-bold" id="valor_pagado" name="valor_pagado" required>
                        <div id="valor_pagado_error" class="text-red font-weight-bold" style="display: none;">Valor superior a Valor Renta, por favor corrija.</div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="diferencia"><strong>Diferencia $</strong></label>
                        <input type="text" class="form-control" id="diferencia" name="diferencia" readonly>

                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <?php
                        if ($row['num_pago'] == 1) {
                        ?>
                            <div class="col-12 col-sm-3">
                                <label for="afianzamiento">Afianzamiento $</label>
                                <input type="text" class="form-control" id="afianzamiento" name="afianzamiento" value="0">
                            </div>
                        <?php } ?>
                        <input type="hidden" step="0.01" class="form-control" id="adecuaciones" name="adecuaciones" value="0">
                        <input type="hidden" step="0.01" class="form-control" id="deposito" name="deposito" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <input type="hidden" class="form-control" id="observaciones_diferencia" name="observaciones_diferencia" disabled>
                        <div class="col-12 col-sm-2">
                            <label for="fecha_pago_realizado">Fecha de Pago:</label>
                            <input type="date" class="form-control" id="fecha_pago_realizado" name="fecha_pago_realizado" required>
                        </div>
                    </div>
                </div>
                <hr style="border: 4px solid #FA8B07; border-radius: 4px;">
                <h4><strong>Impuestos Propietario:</strong></h4>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="rte_fte1">RTE FTE %</label>
                            <select <?php if ($pago_data != []) echo "disabled" ?> class="form-control" name="rte_fte1" id="rte_fte1" onchange="updateRteFte()">
                                <option value=""></option>
                                <option value="3.5" <?php if ($row['rte_fte1'] == 3.5) echo "selected"; ?>>3.5%</option>
                                <option value="20" <?php if ($row['rte_fte1'] == 20) echo "selected"; ?>>20%</option>
                                <option value="0" <?php if ($row['rte_fte1'] == "0") echo "selected"; ?>>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="rte_fte2">RTE FTE $</label></strong>
                            <input type='text' name='rte_fte2' id="rte_fte2" class='form-control' value="<?= $row['rte_fte2'] ?>" readonly style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="rte_ica1">RTE ICA</label>
                            <select <?php if ($pago_data != []) echo "disabled" ?> class="form-control" name="rte_ica1" id="rte_ica1" onchange="updateRteIca()">
                                <option value=""></option>
                                <option <?php if ($row['rte_ica1'] == 7) echo "selected";  ?> value=7>7</option>
                                <option <?php if ($row['rte_ica1'] == 8) echo "selected"; ?> value=8>8</option>
                                <option <?php if ($row['rte_ica1'] == 9) echo "selected"; ?> value=9>9</option>
                                <option <?php if ($row['rte_ica1'] == 10) echo "selected"; ?> value=10>10</option>
                                <option <?php if ($row['rte_ica1'] == "N/A") echo "selected"; ?> value=0>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="rte_ica2">RTE ICA $</label></strong>
                            <input type='text' name='rte_ica2' id="rte_ica2" class='form-control' value="<?= $row['rte_ica2'] ?>" readonly style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="rte_iva1">RTE IVA:</label>
                            <select <?php if ($pago_data != []) echo "disabled" ?> class="form-control" name="rte_iva1" id="rte_iva1" onchange="updateRteIva()" required>
                                <option value=""></option>
                                <option <?php if ($row['rte_iva1'] == 1) echo "selected"; ?> value=1>Sí</option>
                                <option <?php if ($row['rte_iva1'] == 0) echo "selected"; ?> value=0>No</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="rte_iva2">RTE IVA $</label></strong>
                            <input type='text' name='rte_iva2' id="rte_iva2" class='form-control' value="<?= $row['rte_iva2'] ?>" readonly style="font-weight:bold;" />
                        </div>
                    </div>
                </div>

                <h4><strong>Impuestos Inmobiliaria:</strong></h4>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="rte_fte3">RTE FTE %</label>
                            <select <?php if ($pago_data != []) echo "disabled" ?> class="form-control" name="rte_fte3" id="rte_fte3" onchange="updateRteFteInmobi()">
                                <option value=""></option>
                                <option <?php if ($row['rte_fte3'] == 3.5) echo "selected"; ?> value=3.5>3.5%</option>
                                <option <?php if ($row['rte_fte3'] == 20) echo "selected"; ?> value=20>20%</option>
                                <option <?php if ($row['rte_fte3'] == 0) echo "selected"; ?> value=0>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="rte_fte4">RTE FTE $</label></strong>
                            <input type='text' value="<?= $row['rte_fte4'] ?>" name='rte_fte4' id="rte_fte4" class='form-control' readonly style="font-weight:bold;" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="rte_ica1">RTE ICA</label>
                            <select <?php if ($pago_data != []) echo "disabled" ?> class="form-control" name="rte_ica3" id="rte_ica3" onchange="updateRteIcaInmobi()">
                                <option value=""></option>
                                <option <?php if ($row['rte_ica3'] == 7) echo "selected"; ?> value=7>7</option>
                                <option <?php if ($row['rte_ica3'] == 8) echo "selected"; ?> value=8>8</option>
                                <option <?php if ($row['rte_ica3'] == 9) echo "selected"; ?> value=9>9</option>
                                <option <?php if ($row['rte_ica3'] == 10) echo "selected"; ?> value=10>10</option>
                                <option <?php if ($row['rte_ica3'] == "N/A") echo "selected"; ?> value=0>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="rte_ica2">RTE ICA $</label></strong>
                            <input type='text' value="<?= $row['rte_ica4'] ?>" name='rte_ica4' id="rte_ica4" class='form-control' readonly style="font-weight:bold;" />
                        </div>
                        <!-- rete iva -->
                        <div class="col-12 col-sm-2">
                            <label for="rte_iva3">RTE IVA:</label>
                            <select <?php if ($pago_data != []) echo "disabled" ?> class="form-control" name="rte_iva_aplica_inmobi" id="rte_iva_aplica_inmobi" onchange="updateRteIvaInmobi()" required>
                                <option value=""></option>
                                <option <?php if ($row['rte_iva_aplica_inmobi'] == 1) echo "selected"; ?> value=1>Sí</option>
                                <option <?php if ($row['rte_iva_aplica_inmobi'] == 0) echo "selected"; ?> value=0>No</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="rte_iva_inmobi">RTE IVA $</label></strong>
                            <input type='text' name='rte_iva_inmobi' id="rte_iva_inmobi" class='form-control' value="<?= $row['rte_iva_inmobi'] ?>" readonly style="font-weight:bold;" />
                        </div>
                        <input type="hidden" name="iva_con" value="<?= $row['iva_con'] ?>">

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
                            <!-- <label type="hidden"  for="total_monto"><strong>Total Monto Distribuido $</strong></label> -->
                            <input type="hidden" class="form-control highlight-total" id="total_monto" name="total_monto" readonly>
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

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="Agregar Gastos"><strong>Agregar Gastos:</strong></label>
                        </div>
                    </div>
                    <button type="button" id="add-gastos" class="btn btn-secondary mt-2">Agregar Gastos</button>
                </div>

                <div id="gastos-container" class="mt-3"></div>

                <hr style="border: 4px solid #FA8B07; border-radius: 4px;">

                <button type="submit" class="btn btn-primary" onclick="validateForm()">Registrar Pago Arrendamiento</button>
                <a href="showpay1.php?num_con=<?= urlencode($row['num_con']); ?>" class="btn btn-outline-dark">Regresar</a>

            </div>
        </form>
        <script>
            document.getElementById('add-gastos').addEventListener('click', function() {
                const container = document.getElementById('gastos-container');

                // Crear el contenedor para un nuevo gasto
                const gastoDiv = document.createElement('div');
                gastoDiv.classList.add('row', 'mb-3', 'gasto-item', 'p-2', 'border', 'rounded');

                // Crear el campo select con opciones
                const selectDiv = document.createElement('div');
                selectDiv.classList.add('col-12', 'col-sm-3');
                const selectLabel = document.createElement('label');
                selectLabel.textContent = 'Tipo de Gasto:';
                const select = document.createElement('select');
                select.classList.add('form-control');
                select.name = 'tipo_gasto[]';

                // Agregar opciones al select
                const opciones = ['Afianzamiento', 'Adecuaciones', 'Deposito', 'Otros'];
                opciones.forEach(opcion => {
                    const option = document.createElement('option');
                    option.value = opcion;
                    option.textContent = opcion;
                    select.appendChild(option);
                });

                selectDiv.appendChild(selectLabel);
                selectDiv.appendChild(select);

                // Crear el campo de valor $
                const valorDiv = document.createElement('div');
                valorDiv.classList.add('col-12', 'col-sm-3');
                const valorLabel = document.createElement('label');
                valorLabel.textContent = 'Valor $:';
                const valorInput = document.createElement('input');
                valorInput.type = 'number';
                valorInput.step = '0.01';
                valorInput.classList.add('form-control');
                valorInput.name = 'valor_gasto[]';
                valorInput.value = '0';

                valorDiv.appendChild(valorLabel);
                valorDiv.appendChild(valorInput);

                // Crear el campo de observaciones
                const obsDiv = document.createElement('div');
                obsDiv.classList.add('col-12', 'col-sm-3');
                const observacionesLabel = document.createElement('label');
                observacionesLabel.textContent = 'Observaciones:';
                const observacionesInput = document.createElement('input');
                observacionesInput.type = 'text';
                observacionesInput.classList.add('form-control');
                observacionesInput.name = 'observaciones_gasto[]';
                observacionesInput.placeholder = 'Añadir observaciones';

                obsDiv.appendChild(observacionesLabel);
                obsDiv.appendChild(observacionesInput);

                // Crear el botón de eliminación
                const deleteDiv = document.createElement('div');
                deleteDiv.classList.add('col-6', 'col-sm-1', 'd-flex', 'align-items-end');
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.classList.add('btn', 'btn-danger', 'w-60');
                deleteButton.textContent = 'Eliminar';

                // Añadir evento para eliminar el gasto actual
                deleteButton.addEventListener('click', function() {
                    container.removeChild(gastoDiv);
                });

                deleteDiv.appendChild(deleteButton);

                // Agregar los campos y el botón de eliminación al contenedor del gasto
                gastoDiv.appendChild(selectDiv);
                gastoDiv.appendChild(valorDiv);
                gastoDiv.appendChild(obsDiv);
                gastoDiv.appendChild(deleteDiv);

                // Agregar el nuevo conjunto de campos de gasto al contenedor principal
                container.appendChild(gastoDiv);
            });

            function formatCurrency(amount) {
                return new Intl.NumberFormat('es-ES', {
                    style: 'currency',
                    currency: 'COP'
                }).format(amount);
            }

            function updateDiferencia() {
                var valorRenta = parseFloat(document.getElementById('renta_con').value.replace(/\./g, '').replace(',', '.'));
                //aqui cambio la renta por el valor de la consignacion por el pago parcial
                <?php if ($pago_data != []) { ?>
                    var valorRenta = parseInt(document.getElementById('total_consignar_pago').value.replace(/[.,\s]/g, '').replace('COP', ''), 10) / 100;
                <?php } ?>
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

            var originalConsignar = <?php if ($pago_data != []) echo $row['renta_con'] - $pago_data['valor_pagado'];
                                    else echo $row['total_consignar_pago']; ?>; // Almacena la comisión
            var originalComision = <?= $row['comision_pago']; ?>; // Almacena la comisión original en una variable
            //RTEFUENTE PROPIETARIO

            function updateRteFte() {
                var rteFte1 = document.getElementById('rte_fte1').value;
                var rteFte2 = document.getElementById('rte_fte2');
                var canon = <?= $row['canon_con'] ?>;
                if (rteFte1 === "") {
                    rteFte2.value = "";
                } else if (rteFte1 === "3.5" || rteFte1 === "20") {
                    var result = (parseFloat(rteFte1) / 100) * canon;
                    rteFte2.value = result.toFixed(2); // Mostrar el valor calculado con dos decimales
                }
                updateConsignar();
            }

            function updateRteIca() {
                var rteIca1 = document.getElementById('rte_ica1').value;
                var rteIca2 = document.getElementById('rte_ica2');
                var canon = <?= $row['canon_con'] ?>;
                if (rteIca1 === "" || rteIca1 == 0) {
                    rteIca2.value = "";
                } else if (rteIca1 === "7" || rteIca1 === "8" || rteIca1 === "9" || rteIca1 === "10") {
                    var result = (parseFloat(rteIca1) / 1000) * canon;
                    rteIca2.value = result.toFixed(2);
                }
                updateConsignar();
            }

            function updateRteIva() {
                var rteIva1 = document.getElementById('rte_iva1').value;
                var rteIva2 = document.getElementById('rte_iva2');
                var iva = <?= $row['iva_con'] ?>;
                if (rteIva1 === "" || rteIva1 == 0) {
                    rteIva2.value = "";
                } else if (rteIva1 === "1") {
                    var result = iva * 0.15;
                    rteIva2.value = result.toFixed(2);

                }
                updateConsignar();

            }

            function updateRteFteInmobi() {
                var rte_fte3 = document.getElementById('rte_fte3').value;
                var rte_fte4 = document.getElementById('rte_fte4');
                var comision = <?= $row['comision_pago'] ?>;
                if (rte_fte3 === "") {
                    rte_fte4.value = "";
                } else if (rte_fte3 === "3.5" || rte_fte3 === "20") {
                    var result = (parseFloat(rte_fte3) / 100) * comision;
                    rte_fte4.value = result.toFixed(2); // Mostrar el valor calculado con dos decimales
                }

                updateComision()

            }

            function updateRteIcaInmobi() {
                var rte_ica3 = document.getElementById('rte_ica3').value;
                var rte_ica4 = document.getElementById('rte_ica4');
                var comision = <?= $row['comision_pago'] ?>;
                if (rte_ica3 === "" || rte_ica3 == 0) {
                    rte_ica4.value = "";
                } else if (rte_ica3 === "7" || rte_ica3 === "8" || rte_ica3 === "9" || rte_ica3 === "10") {
                    var result = (parseFloat(rte_ica3) / 1000) * comision;
                    rte_ica4.value = result.toFixed(2);

                }
                updateComision()
            }

            //restar al propietario
            function updateConsignar() {
                var rteFte2 = parseFloat(document.getElementById('rte_fte2').value) || 0;
                var rteIca2 = parseFloat(document.getElementById('rte_ica2').value) || 0;
                var rteIva2 = parseFloat(document.getElementById('rte_iva2').value) || 0;

                // Calcular la nueva comisión restando los valores de las retenciones
                var nuevaComision = originalConsignar - rteFte2 - rteIca2 - rteIva2;

                // Actualizar el valor en el campo de comisión
                document.getElementById('total_consignar_pago').value = nuevaComision.toFixed(2) + " COP";
            }
            // Llamamos a las funciones de actualización al cargar la página para que se actualice las restas
            window.onload = function() {
                updateRteFte();
                updateRteIca();
                updateRteIva();
                updateRteFteInmobi();
                updateRteIcaInmobi();
            };

            // Función para actualizar la comisión neta después de restar retenciones
            function updateComision() {
                var rteFte4 = parseFloat(document.getElementById('rte_fte4').value) || 0;
                var rteIca4 = parseFloat(document.getElementById('rte_ica4').value) || 0;
                var rteIvaInmobi = parseFloat(document.getElementById('rte_iva_inmobi').value) || 0;

                // Calcular la comisión neta restando las retenciones
                var nuevaComision = originalComision - rteFte4 - rteIca4 -
                    rteIvaInmobi;

                // Actualizar el valor en el campo de comisión
                document.getElementById('comision_pago').value = nuevaComision.toFixed(2) + " COP";
            }

            function updateRteIvaInmobi() {
                var rte_iva_aplica_inmobi = document.getElementById('rte_iva_aplica_inmobi').value;
                var rte_iva_inmobi = document.getElementById('rte_iva_inmobi');
                var iva = <?= $row['iva_con'] ?>;
                if (rte_iva_aplica_inmobi === "" || rte_iva_aplica_inmobi == 0) {
                    rte_iva_inmobi.value = "";
                } else if (rte_iva_aplica_inmobi === "1") {
                    var result = iva * 0.15;
                    rte_iva_inmobi.value = result.toFixed(2);

                }
                updateComision();
            }
            const afianzamientoInput = document.getElementById('afianzamiento');

            afianzamientoInput.addEventListener('input', function(e) {
                // Remueve cualquier caracter que no sea un número
                let value = e.target.value.replace(/\./g, '');

                // Convertir a número y formatear con puntos de miles
                if (value) {
                    value = parseInt(value).toLocaleString('es-ES');
                }

                // Actualizar el valor del input con el formato
                e.target.value = value;
            });

            const adecuacionesInput = document.getElementById('adecuaciones');

            adecuacionesInput.addEventListener('input', function(e) {
                // Remueve cualquier caracter que no sea un número
                let value = e.target.value.replace(/\./g, '');

                // Convertir a número y formatear con puntos de miles
                if (value) {
                    value = parseInt(value).toLocaleString('es-ES');
                }

                // Actualizar el valor del input con el formato
                e.target.value = value;
            });

            const depositoInput = document.getElementById('deposito');

            depositoInput.addEventListener('input', function(e) {
                // Remueve cualquier caracter que no sea un número
                let value = e.target.value.replace(/\./g, '');

                // Convertir a número y formatear con puntos de miles
                if (value) {
                    value = parseInt(value).toLocaleString('es-ES');
                }

                // Actualizar el valor del input con el formato
                e.target.value = value;
            });
        </script>

</body>

</html>
