<?php
    session_start();

    if (!isset($_SESSION['id_usu'])) {
        header("Location: ../../index.php");
        exit();
    }

    // Incluir una función para manejo de errores en base de datos
    function handleError($message) {
        die("Error: " . $message);
    }

    include("../../conexion.php");

    if ($mysqli->connect_errno) {
        handleError("No se pudo conectar a la base de datos.");
    }

    // Obtener el nit_cc_ase y el nombre del usuario relacionado
    $stmt = $mysqli->prepare("
        SELECT a.nit_cc_ase, u.nombre 
        FROM asesores a
        INNER JOIN usuarios u ON a.id_usu = u.id_usu
        WHERE a.id_usu = ?");

    if (!$stmt) {
        handleError("Error al preparar la consulta: " . $mysqli->error);
    }

    $stmt->bind_param('i', $_SESSION['id_usu']);
    $stmt->execute();
    $stmt->bind_result($nit_cc_ase, $nombre_usu);
    $stmt->fetch();
    $stmt->close();

    if (!$nombre_usu || !$nit_cc_ase) {
        handleError("El usuario no está registrado correctamente en las tablas.");
    }

    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set("America/Bogota");
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
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        label {
            font-size: 10px;
            font-weight: bold;
            color: #000000;
            transition: color 0.3s ease;
        }

        input.form-control,
        select.form-control {
            font-size: 12px;
            padding: 0.3rem 0.6rem;
            color: black;
            box-sizing: border-box;
            height: 32px;
        }

        textarea.form-control {
            font-size: 12px;
            padding: 0.3rem 0.6rem;
            color: black;
            box-sizing: border-box;
        }

        input.form-control:focus,
        select.form-control:focus,
        textarea.form-control:focus {
            background-color: #f0e68c;
            outline: none;
        }

        .form-group:focus-within label {
            color: #c68615;
        }

        .form-container {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
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

        fieldset:focus-within {
            background-color: #e6f7ff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        }

        #calculadora button {
            font-size: 18px;
            width: 100%;
            padding: 10px;
        }

        #resultado {
            height: 50px;
            font-size: 24px;
            text-align: right;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        function ordenarSelect(id_componente) {
            var selectToSort = jQuery('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function(a, b) {
                return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
        }

        $(document).ready(function() {
            ordenarSelect('cod_dane_dep');
            ordenarSelect('id_mun');
        });
    </script>
    <script>
        function obtenerUbicacionActual() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    document.getElementById("ubicacion_gps_cap").value = lat + "," + lng;
                }, function(error) {
                    alert("No se pudo obtener la ubicación actual. Asegúrese de haber permitido el acceso a la ubicación.");
                });
            } else {
                alert("La geolocalización no es soportada por este navegador.");
            }
        }

        // Asignar la función al botón después de cargar el DOM
        $(document).ready(function() {
            document.getElementById("botonUbicacionActual").addEventListener("click", obtenerUbicacionActual);
        });
    </script>
    <script>
        // Función para agregar separadores de miles
        function formatNumber(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Función para limpiar el formato y devolver solo el número
        function unformatNumber(value) {
            return value.replace(/\./g, ""); // Remover los puntos
        }

        // Función para convertir un valor a número flotante para cálculos
        function toFloat(value) {
            return parseFloat(unformatNumber(value));
        }

        // Función para formatear en moneda colombiana (COP)
        function formatCOP(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }

        $(document).ready(function() {
            // Aplicar el formato al escribir en los campos
            $('#canon_neto_cap, #admon_cap, #venta_neta_cap, #venta_m2_cap').on('input', function() {
                var unformatted = unformatNumber($(this).val()); // Remover el formato actual
                if (!isNaN(unformatted) && unformatted !== '') {
                    $(this).val(formatNumber(unformatted)); // Volver a aplicar el formato de miles
                }
            });

            // Función para calcular los valores y aplicar el formato COP
            function calcularValores() {
                var canon_neto = toFloat($('#canon_neto_cap').val()) || 0;
                var porcentaje_iva = parseFloat($('#porcentaje_iva_cap').val()) || 0;
                var admon = toFloat($('#admon_cap').val()) || 0;

                // Cálculo correcto del IVA y la renta total
                var valor_iva = canon_neto * (porcentaje_iva / 100);
                var renta_total = canon_neto + valor_iva + admon;

                // Aplicar el formato de moneda (COP) al mostrar los resultados
                $('#valor_iva_cap').val(formatCOP(Math.round(valor_iva)));
                $('#renta_total_cap').val(formatCOP(Math.round(renta_total)));

                // Actualizar los campos ocultos con los valores numéricos para enviar al servidor
                $('#valor_iva_cap_hidden').val(Math.round(valor_iva));
                $('#renta_total_cap_hidden').val(Math.round(renta_total));
            }

            // Ejecutar el cálculo cada vez que cambien los valores
            $('#canon_neto_cap, #porcentaje_iva_cap, #admon_cap').on('input', function() {
                calcularValores();
            });

            // Cálculo y formato para venta_total
            function calcularVentaTotal() {
                var venta_m2 = toFloat($('#venta_m2_cap').val()) || 0;
                var area_total = toFloat($('#area_total_cap').val()) || 0;

                // Calcular el total de la venta
                var venta_total = venta_m2 * area_total;

                // Mostrar el valor formateado en COP
                $('#venta_total').val(formatCOP(Math.round(venta_total)));

                // Actualizar el campo oculto con el valor numérico para el backend
                $('#venta_total_hidden').val(Math.round(venta_total));
            }

            // Ejecutar el cálculo cada vez que cambien los valores de venta_m2_cap o area_total_cap
            $('#venta_m2_cap, #area_total_cap').on('input', function() {
                calcularVentaTotal();
            });

            // Limpiar el formato de miles antes de enviar el formulario
            $('form').on('submit', function() {
                $('#canon_neto_cap, #admon_cap, #venta_neta_cap, #venta_m2_cap').each(function() {
                    var unformatted = unformatNumber($(this).val()); // Remover los puntos
                    $(this).val(unformatted); // Asignar el valor sin puntos para el envío
                });
            });
        });
    </script>
</head>

<body>

    <div class="container">
        <h1><img src='../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-building-circle-check"></i> FICHA TECNICA INMUEBLES COMERCIALES</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

        <form action='addcap1.php' enctype="multipart/form-data" method="POST">

            <div class="form-group">
                <fieldset>
                    <legend>UBICACION - MEDIDAS</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cod_dane_dep">DEPARTAMENTO:</label>
                            <select id="cod_dane_dep" class="form-control" name="cod_dane_dep">
                                <option value=""></option>
                                <?php
                                $sql = $mysqli->prepare("SELECT * FROM departamentos");
                                if ($sql->execute()) {
                                    $g_result = $sql->get_result();
                                }
                                while ($row = $g_result->fetch_array()) {
                                ?>
                                    <option value="<?php echo $row['cod_dane_dep'] ?>"><?php echo $row['nom_dep'] ?></option>
                                <?php
                                }
                                $mysqli->close();
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="id_mun">MUNICIPIOS:</label>
                            <select id="id_mun" name="id_mun" class="form-control" disabled="disabled">
                                <option value="">* SELECCIONE EL MUNICIPIO:</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sector_cap">SECTOR:</label>
                            <input type='text' name='sector_cap' class='form-control' id="sector_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="ubicacion_gps_cap">UBICACION GPS:</label>
                            <input type='text' name='ubicacion_gps_cap' class='form-control' id="ubicacion_gps_cap" readonly />
                            <button type="button" class="btn btn-sm btn-outline-info" id="botonUbicacionActual">Obtener ubicación actual</button>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estrato_cap">* ESTRATO:</label>
                            <select class="form-control" name="estrato_cap" id="estrato_cap" required>
                                <option value=""></option>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                                <option value=6>6</option>
                                <option value=7>7</option>
                                <option value=8>8</option>
                                <option value=9>9</option>
                                <option value=10>10</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_total_cap">AREA TOTAL:</label>
                            <input type='number' name='area_total_cap' class='form-control' id="area_total_cap" />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>DATOS DE CONTACTO</legend>
                    <div class="row">
                        <div class="col-12 col-sm-5">
                            <label for="nombre_razon_social_cap">* NOMBRE y/o RAZON SOCIAL:</label>
                            <input type='text' name='nombre_razon_social_cap' class='form-control' id="nombre_razon_social_cap" required style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cel_repre_legal_cap">* CELULAR:</label>
                            <input type='number' value=0 name='cel_repre_legal_cap' id="cel_repre_legal_cap" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tel_repre_legal_cap">TELEFONO:</label>
                            <input type='number' value=0 name='tel_repre_legal_cap' id="tel_repre_legal_cap" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="nombre_usu">* ASESOR COMERCIAL:</label>
                            <input type="text" name="nombre_usu" id="nombre_usu" class="form-control" readonly value="<?php echo htmlspecialchars($nombre_usu, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="nit_cc_ase" id="nit_cc_ase" value="<?php echo htmlspecialchars($nit_cc_ase, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>Calculadora</legend>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="abrirCalculadora()">Abrir Calculadora</button>
                        </div>
                    </div>
                    <div id="calculadora" style="display:none; max-width: 250px;">
                        <div class="row mb-2">
                            <div class="col-12">
                                <input type="text" id="resultado" readonly class="form-control" style="font-size: 20px; text-align: right;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-9">
                                <!-- Botones numéricos -->
                                <div class="row">
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('1')">1</button></div>
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('2')">2</button></div>
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('3')">3</button></div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('4')">4</button></div>
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('5')">5</button></div>
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('6')">6</button></div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('7')">7</button></div>
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('8')">8</button></div>
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('9')">9</button></div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4"><button class="btn btn-secondary btn-block" onclick="agregarValor('0')">0</button></div>
                                    <div class="col-8"><button class="btn btn-secondary btn-block" onclick="calcular()">=</button></div>
                                </div>
                            </div>

                            <!-- Botones de operaciones -->
                            <div class="col-3">
                                <div class="row mb-2"><button class="btn btn-info btn-block" onclick="operacion('+')">+</button></div>
                                <div class="row mb-2"><button class="btn btn-info btn-block" onclick="operacion('-')">-</button></div>
                                <div class="row mb-2"><button class="btn btn-info btn-block" onclick="operacion('*')">*</button></div>
                                <div class="row mb-2"><button class="btn btn-info btn-block" onclick="operacion('/')">/</button></div>
                                <div class="row"><button class="btn btn-danger btn-block" onclick="borrar()">C</button></div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-danger btn-block" onclick="cerrarCalculadora()">Cerrar Calculadora</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>


            <div class="form-group">
                <fieldset>
                    <legend>VALORES RENTA y/o VENTA</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="canon_neto_cap">CANON NETO $</label>
                            <input type='text' name='canon_neto_cap' class='form-control' id="canon_neto_cap" step='0.1' value="0" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="porcentaje_iva_cap">% IVA:</label>
                            <input type='number' name='porcentaje_iva_cap' class='form-control' id="porcentaje_iva_cap" min='0.0' max='100' step='0.1' value=19.0 />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="admon_cap">* ADMINISTRACION $</label>
                            <input type='text' name='admon_cap' class='form-control' id="admon_cap" step='0.1' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_iva_cap">* VALOR IVA $</label>
                            <input type='text' name='valor_iva_cap' class='form-control' id="valor_iva_cap" readonly style="font-weight: bold; font-size: 14px;" />
                            <input type='hidden' name='valor_iva_cap_hidden' id='valor_iva_cap_hidden' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="renta_total_cap">* RENTA TOTAL $</label>
                            <input type='text' name='renta_total_cap' class='form-control' id="renta_total_cap" readonly style="font-weight: bold; font-size: 14px;" />
                            <input type='hidden' name='renta_total_cap_hidden' id='renta_total_cap_hidden' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="venta_neta_cap">VENTA NETA $</label>
                            <input type='text' name='venta_neta_cap' class='form-control' id="venta_neta_cap" step='0.1' value="0"/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="venta_m2_cap">VALOR x m2 $</label>
                            <input type='text' name='venta_m2_cap' class='form-control' id="venta_m2_cap" step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="venta_total">VALOR TOTAL $</label>
                            <input type='text' name='venta_total' class='form-control' id="venta_total" readonly style="font-weight: bold; font-size: 14px;" />
                            <input type='hidden' name='venta_total_hidden' id='venta_total_hidden' />
                        </div>
                    </div>
                </fieldset>
            </div>

            <button type="submit" class="btn btn-outline-warning">
                    <span class="spinner-border spinner-border-sm"></span>
                    INGRESAR REGISTRO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
    <script src = "../../js/jquery-3.1.1.js"></script>
    <script type = "text/javascript">
        $(document).ready(function(){
            $('#cod_dane_dep').on('change', function(){
                    if($('#cod_dane_dep').val() == ""){
                        $('#id_mun').empty();
                        $('<option value = "">Seleccione un municipio</option>').appendTo('#id_mun');
                        $('#id_mun').attr('disabled', 'disabled');
                    }else{
                        $('#id_mun').removeAttr('disabled', 'disabled');
                        $('#id_mun').load('modules_get.php?cod_dane_dep=' + $('#cod_dane_dep').val());
                    }
            });
        });
    </script>
    <script>
        var operacionActual = "";
        var valorActual = "";
        var resultado = 0;

        // Función para agregar el valor al campo de entrada con formato de millares
        function agregarValor(valor) {
            valorActual += valor;
            document.getElementById("resultado").value = formatNumber(valorActual);
        }

        // Función para realizar la operación
        function operacion(operador) {
            if (operacionActual !== "") {
                calcular();
            }
            resultado = parseFloat(unformatNumber(valorActual));
            operacionActual = operador;
            valorActual = "";
            document.getElementById("resultado").value = "";
        }

        // Función para calcular el resultado
        function calcular() {
            if (operacionActual === "+") {
                resultado += parseFloat(unformatNumber(valorActual));
            } else if (operacionActual === "-") {
                resultado -= parseFloat(unformatNumber(valorActual));
            } else if (operacionActual === "*") {
                resultado *= parseFloat(unformatNumber(valorActual));
            } else if (operacionActual === "/") {
                if (parseFloat(unformatNumber(valorActual)) === 0) {
                    alert("No se puede dividir por cero");
                    return;
                }
                resultado /= parseFloat(unformatNumber(valorActual));
            }
            document.getElementById("resultado").value = formatNumber(resultado.toString());
            valorActual = resultado.toString();
            operacionActual = "";
        }

        // Función para limpiar la pantalla de la calculadora
        function borrar() {
            operacionActual = "";
            valorActual = "";
            resultado = 0;
            document.getElementById("resultado").value = "";
        }

        // Función para abrir la calculadora
        function abrirCalculadora() {
            document.getElementById("calculadora").style.display = "block";
        }

        // Función para cerrar la calculadora
        function cerrarCalculadora() {
            document.getElementById("calculadora").style.display = "none";
        }

        // Función para formatear con separadores de miles
        function formatNumber(value) {
            if (value === "") return "";
            return parseFloat(value.replace(/,/g, '')).toLocaleString('es-CO');
        }

        // Función para quitar los separadores de miles y devolver solo el número
        function unformatNumber(value) {
            return value.replace(/\./g, "").replace(/,/g, ""); // Remover los separadores de miles
        }
    </script>
</body>
</html>
