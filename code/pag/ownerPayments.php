<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usu'];

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_pago = $_POST['id_pago'];
    $propietarios = $_POST['propietarios'] ?? [];
    $propietarios_monto = $_POST['propietarios_monto'] ?? [];
    $fecha_pago_realizado = $_POST['fecha_pago_realizado'];

    $sql_id_pago_realizado = "SELECT id_pago_realizado FROM pagos_realizados WHERE id_pago = $id_pago";
    $result_id_pago_realizado = $mysqli->query($sql_id_pago_realizado);
    $row_id_pago_realizado = $result_id_pago_realizado->fetch_assoc();
    $id_pago_realizado = $row_id_pago_realizado['id_pago_realizado'];

    // Crear un array para almacenar los valores de los propietarios y montos
    $values = [];
    foreach ($propietarios as $index => $propietario) {
        $monto = $propietarios_monto[$index];
        // Escapar valores para evitar inyecciones SQL
        $propietarioEscapado = $mysqli->real_escape_string($propietario);
        $montoEscapado = $mysqli->real_escape_string($monto);

        // Agregar la fila a los valores
        $values[] = "( $id_pago_realizado, '$fecha_pago_realizado', $propietarioEscapado, '$montoEscapado')";
    }

    // Unir todos los valores en una cadena
    $valuesString = implode(", ", $values);
    // Crear la consulta SQL
    $sql = "INSERT INTO pagos_propietarios (id_pago_realizado, fecha_pago, nit_cc_pro, monto) VALUES $valuesString";

    // Ejecutar la consulta
    if ($mysqli->query($sql)) {
        // Si todo sale bien, redirige
        header("Location: pago_satisfactorio.htm");
    } else {
        echo "Error al insertar registros: " . $mysqli->error;
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
$iva_inmobiliaria = $row['comision_pago'] * 0.19;
$sql_num_con = "SELECT num_con FROM pagos WHERE id_pago = $id_pago";
$result_num_con = $mysqli->query($sql_num_con);
$row_num_con = $result_num_con->fetch_assoc();
$num_con = $row_num_con['num_con'];


$sql_saldo = "SELECT sum(pr.diferencia) FROM pagos_realizados as pr
    JOIN pagos p ON pr.id_pago = p.id_pago
    WHERE p.num_con = '$num_con' ";
$result_saldo = $mysqli->query($sql_saldo);
$row_saldo = $result_saldo->fetch_assoc();
$saldo = $row_saldo['sum(pr.diferencia)'];
//la cambio a negativo si es positivo y al reves ya que la diferencia se calcula al reves
$saldo = $saldo * -1;

if ($saldo == null) {
    $saldo = 0;
}

//consulta de pagos a los propietarios
$sql_pagos_propietarios = "SELECT * FROM pagos_propietarios as pp
    JOIN pagos_realizados pr ON pp.id_pago_realizado = pr.id_pago_realizado
    JOIN pagos p ON pr.id_pago = p.id_pago
    WHERE p.num_con = '$num_con' AND p.id_pago = $id_pago";
$result_pagos_propietarios = $mysqli->query($sql_pagos_propietarios);

function nombrePropietario($nit_cc_pro)
{
    include("../../conexion.php");
    $sql = "SELECT nom_ape_pro FROM propietarios WHERE nit_cc_pro = '$nit_cc_pro'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['nom_ape_pro'];
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

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class='fa-solid fa-money-check-dollar'></i> APLICAR PAGO PROPIETARIOS</b></h1>

    <div class="container">
        <form id="payment-form" action="ownerPayments.php" method="post">
            <input type="hidden" name="id_pago" value="<?php echo $id_pago; ?>">
            <div class="form-group">
                <hr style="border: 4px solid #FA8B07; border-radius: 4px;">
                <label for="propietarios"><strong>Distribución entre Propietarios:</strong></label>
                <?php foreach ($result_pagos_propietarios as $pago) :   ?>
                    <div class="row">

                        <div class="col-12 col-sm-3">
                            <label for="propietario">Propietario</label>
                            <input type="text" class="form-control form-control-bold" name="propietario" value='<?= nombrePropietario($pago['nit_cc_pro']); ?>' readonly>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="pago_anterior">Pago</label>
                            <input type="text" name="pago_anterior" class="form-control form-control-bold" value="<?= $pago['monto'] ?>">
                        </div>
                        <div class="col-12 col-sm-4">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr style="border: 4px solid #FA8B07; border-radius: 4px;">

            <div class="form-group">
                <div class="col-12 col-sm-2">
                    <label for="fecha_pago_realizado">Fecha de Pago:</label>
                    <input type="date" class="form-control" id="fecha_pago_realizado" name="fecha_pago_realizado" required>
                </div>
            </div>

            <div class="form-group">
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
                        <div class="col-12 col-sm-12">
                            <div id="monto_error" class="highlight-message" style="display: none;">Por favor verifique el monto a pagar por cada propietario, dado que, alguno es superior al valor a consignar.</div>
                        </div>
                    </div>
                </div>
                <hr style="border: 4px solid #FA8B07; border-radius: 4px;">
                <button type="submit" class="btn btn-primary" onclick="validateForm()">Registrar Pago Propietarios</button>
                <a href="showpay1.php?num_con=<?= urlencode($row['num_con']); ?>" class="btn btn-outline-dark">Regresar</a>

            </div>
        </form>
        <script>
            const opcionesPropietarios = `<?php foreach ($propietarios as $propietario) : ?>
        <option value="<?php echo $propietario['nit_cc_pro']; ?>"><?php echo $propietario['nom_ape_pro']; ?></option>
    <?php endforeach; ?>`;
            document.getElementById('add-propietario').addEventListener('click', function() {
                var propietariosDiv = document.getElementById('propietarios');
                var newPropietarioIndex = propietariosDiv.children.length; // Controla el índice

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
        <div class="col-12 col-sm-3">
            <label for="monto_${newPropietarioIndex}">Monto $</label>
            <input type="number" step="0.01" class="form-control propietario-monto" id="monto_${newPropietarioIndex}" name="propietarios_monto[]" required>
        </div>
        <div class="col-12 col-sm-2">
            <button type="button" class="btn btn-danger remove-propietario mt-4">Eliminar</button>
        </div>
    `;

                propietariosDiv.appendChild(newPropietarioDiv);

                // Event listener para el botón de eliminar
                newPropietarioDiv.querySelector('.remove-propietario').addEventListener('click', function() {
                    this.closest('.propietario-row').remove();
                });
            });
        </script>

</body>

</html>
