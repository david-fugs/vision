<?php

session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

// Obtener el nit_cc_ase y el nombre del usuario relacionado desde las tablas asesores y usuarios
$stmt = $mysqli->prepare("
        SELECT a.nit_cc_ase, u.nombre
        FROM asesores a
        INNER JOIN usuarios u ON a.id_usu = u.id_usu
        WHERE a.id_usu = ?");
$stmt->bind_param('i', $_SESSION['id_usu']);
$stmt->execute();
$stmt->bind_result($nit_cc_ase, $nombre_usu);
$stmt->fetch();
$stmt->close();

if (!$nombre_usu || !$nit_cc_ase) {
    die("Error: El usuario no está registrado correctamente en las tablas.");
}

header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");

// Convertir la cadena de niveles educativos en un array
$internet_telefonia_seleccionados = explode(',', $row['niveles_educativos'] ?? '');

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        /* Reducir el tamaño de la fuente en los labels y añadir color gris claro */
        label {
            font-size: 10px;
            /* Ajuste entre 9 y 10px */
            font-weight: bold;
            color: #000000;
            /* Color gris muy claro */
            transition: color 0.3s ease;
            /* Transición suave para el cambio de color */
        }

        /* Ajustar tamaño de las cajas de texto y select para que sean iguales */
        input.form-control,
        select.form-control {
            font-size: 10px;
            /* Ajuste del tamaño de la fuente dentro de las cajas de texto */
            padding: 0.3rem 0.6rem;
            /* Ajusta el relleno para hacer las cajas más compactas */
            color: black;
            /* Texto en negro */
            box-sizing: border-box;
            /* Asegura que el padding se incluya dentro de la altura */
            height: 32px;
            /* Fija la altura de input y select para que sean iguales */
        }

        textarea.form-control {
            font-size: 10px;
            /* Ajuste del tamaño de la fuente dentro de las cajas de texto */
            padding: 0.3rem 0.6rem;
            /* Ajusta el relleno para hacer las cajas más compactas */
            color: black;
            /* Texto en negro */
            box-sizing: border-box;
            /* Asegura que el padding se incluya dentro de la altura */
        }

        /* Aplicar fondo pastel cuando el input o select está en foco */
        input.form-control:focus,
        select.form-control:focus,
        textarea.form-control:focus {
            background-color: #f0e68c;
            /* Fondo color pastel */
            outline: none;
            /* Eliminar borde azul de enfoque en navegadores */
        }

        /* Resaltar el label cuando el input o select está en foco */
        .form-group:focus-within label {
            color: #c68615;
            /* Cambia el color del label cuando el input o select está en foco */
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

        /* Efecto de enfoque para el fieldset */
        fieldset:focus-within {
            background-color: #e6f7ff;
            /* Azul muy claro */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            /* Sombreado azul claro */
        }

        /* Aseguramos que el modal se abra al cargar la página */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.8) !important; /* Más opaco */
        }
        body.modal-open .modal {
            display: block !important;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.select2').select2(); // Inicializar Select2 en todos los selectores con clase 'select2'
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDYjR0V-srAzEF_73RWUgPxvJFOkV1Lnk&callback=openMap"></script>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="consentModalLabel">CONSENTIMIENTO INFORMADO</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label style="font-size: 15px; font:message-box">
                                Como parte de los procesos necesarios para la gestión del servicio, se podrán realizar fotografías, grabaciones o recolección de firmas relacionadas con el inmueble objeto de este contrato. <br><br>
                                Estas acciones tienen como propósito exclusivo documentar, verificar o garantizar el cumplimiento de los acuerdos establecidos.<br><br>
                                Se asegura al usuario que la información y el material recolectado serán tratados con estricta confidencialidad y utilizados únicamente para los fines antes mencionados, de conformidad con la normativa aplicable en materia de privacidad y protección de datos.
                                <br><br>¿Está de acuerdo?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="acceptButton">Acepto</button>
                    <button type="button" class="btn btn-danger" id="declineButton">No acepto</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h1><img src='../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-building-circle-check"></i> PRE-REGISTRO FICHA TECNICA INMUEBLES COMERCIALES</b></h1>
        <p><i><b>
                    <font size=3 color=#c68615>*Datos obligatorios</i></b></font>
        </p>

        <form action='addcap1.php' enctype="multipart/form-data" method="POST">

            <div class="form-group">
                <input type="hidden" name="consentimiento" value="si">
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>MEDIDAS</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cod_cap">COD.</label>
                            <input type='number' name='cod_cap' class='form-control' id="cod_cap" autofocus />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_total_cap">AREA TOTAL:</label>
                            <input type='number' name='area_total_cap' class='form-control' id="area_total_cap" required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_piso1_cap">AREA PISO 1º:</label>
                            <input type='number' name='area_piso1_cap' class='form-control' id="area_piso1_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_piso2_cap">AREA PISO 2º:</label>
                            <input type='number' name='area_piso2_cap' class='form-control' id="area_piso2_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_sotano_cap">AREA SOTANO:</label>
                            <input type='number' name='area_sotano_cap' class='form-control' id="area_sotano_cap" />
                        </div>

                        <div class="col-12 col-sm-2">
                            <label for="malacate_cap">¿MALACATE?</label>
                            <select class="form-control" name="malacate_cap" id="malacate_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="malacate_num_cap">¿CUANTOS MALACATE?</label>
                            <input type='number' name='malacate_num_cap' class='form-control' id="malacate_num_cap" value=0 />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="malacate_ton_cap">MALACATE CAPAC. TONE.</label>
                            <input type='number' name='malacate_ton_cap' class='form-control' id="malacate_ton_cap" value=0 />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_patio_maniobra_cap">AREA PATIO - MANIOBRA:</label>
                            <input type='number' name='area_patio_maniobra_cap' class='form-control' id="area_patio_maniobra_cap" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="otras_areas_cap">OTRAS AREAS:</label>
                            <input type='text' name='otras_areas_cap' class='form-control' id="otras_areas_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="forma_bodega_cap">FORMA BODEGA:</label>
                            <select class="form-control" name="forma_bodega_cap" id="forma_bodega_cap">
                                <option value=""></option>
                                <option value="Rectangular">Rectangular</option>
                                <option value="Cuadrada">Cuadrada</option>
                                <option value="Polígono">Polígono</option>
                                <option value="Triángulo">Triángulo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="frente_mesanine_cap">FRENTE MESANINE:</label>
                            <input type='number' name='frente_mesanine_cap' class='form-control' id="frente_mesanine_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_mesanine_cap">FONDO MESANINE.</label>
                            <input type='number' name='fondo_mesanine_cap' class='form-control' id="fondo_mesanine_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="frente_lote_cap">FRENTE LOTE:</label>
                            <input type='number' name='frente_lote_cap' class='form-control' id="frente_lote_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_lote_cap">FONDO LOTE:</label>
                            <input type='number' name='fondo_lote_cap' class='form-control' id="fondo_lote_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="frente_nivel1_int_cap">FRENTE NIVEL 1:</label>
                            <input type='number' name='frente_nivel1_int_cap' class='form-control' id="frente_nivel1_int_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_nivel1_int_cap">FONDO NIVEL 1:</label>
                            <input type='number' name='fondo_nivel1_int_cap' class='form-control' id="fondo_nivel1_int_cap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="frente_sotano_cap">FRENTE SOTANO:</label>
                            <input type='number' name='frente_sotano_cap' class='form-control' id="frente_sotano_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_sotano_cap">FONDO SOTANO:</label>
                            <input type='number' name='fondo_sotano_cap' class='form-control' id="fondo_sotano_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_min_bodega_cap">ALTURA BODEGA MIN:</label>
                            <input type='number' name='altura_min_bodega_cap' class='form-control' id="altura_min_bodega_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_max_bodega_cap">ALTURA BODEGA MAX:</label>
                            <input type='number' name='altura_max_bodega_cap' class='form-control' id="altura_max_bodega_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_nivel_2_cap">ALTURA NIVEL 2:</label>
                            <input type='number' name='altura_nivel_2_cap' class='form-control' id="altura_nivel_2_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_nivel_1_2_cap">ALTURA NIVEL 1 A 2:</label>
                            <input type='number' name='altura_nivel_1_2_cap' class='form-control' id="altura_nivel_1_2_cap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="altura_sotano_cap">ALTURA SOTANO:</label>
                            <input type='number' name='altura_sotano_cap' class='form-control' id="altura_sotano_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_sotano_cap">FONDO SOTANO:</label>
                            <input type='number' name='fondo_sotano_cap' class='form-control' id="fondo_sotano_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_min_bodega_cap">ALTURA BODEGA MIN:</label>
                            <input type='number' name='altura_min_bodega_cap' class='form-control' id="altura_min_bodega_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_max_bodega_cap">ALTURA BODEGA MAX:</label>
                            <input type='number' name='altura_max_bodega_cap' class='form-control' id="altura_max_bodega_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_nivel_2_cap">ALTURA NIVEL 2:</label>
                            <input type='number' name='altura_nivel_2_cap' class='form-control' id="altura_nivel_2_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_nivel_1_2_cap">ALTURA NIVEL 1 A 2:</label>
                            <input type='number' name='altura_nivel_1_2_cap' class='form-control' id="altura_nivel_1_2_cap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="altura_sotano_cap">ALTURA SOTANO:</label>
                            <input type='number' name='altura_sotano_cap' class='form-control' id="altura_sotano_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="altura_puerta_veh_cap">ALTURA PUERTA VEHI.</label>
                            <input type='number' name='altura_puerta_veh_cap' class='form-control' id="altura_puerta_veh_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="ancho_puerta_veh_cap">ANCHURA PUERTA VEHI.</label>
                            <input type='number' name='ancho_puerta_veh_cap' class='form-control' id="ancho_puerta_veh_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_puerta_cap">TIPO PUERTA:</label>
                            <div class="form-control" id="tipo_puerta_cap" style="height: auto;">
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                        <select class="form-control" name="tipo_puerta_cap" id="tipo_puerta_cap">
                                            <option value=""></option>
                                            <option value="Mecánica">Mecánica</option>
                                            <option value="Eléctrica">Eléctrica</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>GENERALES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="edad_cap">EDAD:</label>
                            <input type='number' name='edad_cap' class='form-control' id="edad_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estado_bod_cap">ESTADO:</label>
                            <select class="form-control" name="estado_bod_cap" id="estado_bod_cap">
                                <option value=""></option>
                                <option value="Excelente">Excelente</option>
                                <option value="Buena">Buena</option>
                                <option value="Regular">Regular</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="niveles_internos_cap">NIVELES INTERNOS:</label>
                            <select class="form-control" name="niveles_internos_cap" id="niveles_internos_cap">
                                <option value=""></option>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>+3</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-2">
                            <label for="esquinera_medianera_cap">ESQUINERA | MEDIANERA:</label>
                            <select class="form-control" name="esquinera_medianera_cap" id="esquinera_medianera_cap">
                                <option value=""></option>
                                <option value="Esquinera">Esquinera</option>
                                <option value="Medianera">Medianera</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="parqueaderos_cap">PARQUEADEROS:</label>
                            <select class="form-control" name="parqueaderos_cap" id="parqueaderos_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="oficinas_cap">OFICINAS:</label>
                            <select class="form-control" name="oficinas_cap" id="oficinas_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-12 col-sm-2">
                            <label for="oficinas_tama_cap">OFICINA TAMAÑO (m2):</label>
                            <input type='number' name='oficinas_tama_cap' class='form-control' id="oficinas_tama_cap" min='0' step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="duchas_cap">DUCHAS:</label>
                            <input type='number' name='duchas_cap' class='form-control' id="duchas_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="lavamanos_cap">LAVAMANOS:</label>
                            <input type='number' name='lavamanos_cap' class='form-control' id="lavamanos_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sanitarios_cap">SANITARIOS:</label>
                            <input type='number' name='sanitarios_cap' class='form-control' id="sanitarios_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="poceta_cap">POCETA:</label>
                            <input type='number' name='poceta_cap' class='form-control' id="poceta_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cocineta_cap">COCINETA:</label>
                            <input type='number' name='cocineta_cap' class='form-control' id="cocineta_cap" />
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12 col-sm-2">
                            <label for="desagues_bodega_cap">DESAGUES EN BODEGA:</label>
                            <input type='number' name='desagues_bodega_cap' class='form-control' id="desagues_bodega_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_piso_cap">TIPOS PISOS:</label>
                            <select class="form-control" name="tipo_piso_cap" id="tipo_piso_cap" />
                            <option value=""></option>
                            <option value="Estándar">Estándar</option>
                            <option value="Alizado">Alizado</option>
                            <option value="Tierra">Tierra</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="capacidad_piso_2_cap">CAPAC. PISO 2º (kilos*m2):</label>
                            <input type='number' name='capacidad_piso_2_cap' class='form-control' id="capacidad_piso_2_cap" min='0' step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="capacidad_piso_1_psi_cap">CAPAC. PISO 1º PSI (ton):</label>
                            <input type='number' name='capacidad_piso_1_psi_cap' class='form-control' id="capacidad_piso_1_psi_cap" min='0' step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="capacidad_piso_1_tone_cap">CAPAC. PISO 1º (ton*m2):</label>
                            <input type='number' name='capacidad_piso_1_tone_cap' class='form-control' id="capacidad_piso_1_tone_cap" min='0' step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="capacidad_piso_1_mr_cap">CAPAC. PISO 1º MR:</label>
                            <input type='number' name='capacidad_piso_1_mr_cap' class='form-control' id="capacidad_piso_1_mr_cap" />
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12 col-sm-2">
                            <label for="capacidad_piso_1_fc_cap">CAPAC. PISO 1º F'C':</label>
                            <input type='number' name='capacidad_piso_1_fc_cap' class='form-control' id="capacidad_piso_1_fc_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="material_piso_2_cap">MATERIAL PISO 2º:</label>
                            <select class="form-control" name="material_piso_2_cap" id="material_piso_2_cap">
                                <option value=""></option>
                                <option value="Baldosa">Baldosa</option>
                                <option value="Cemento">Cemento</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="material_piso_1_cap">MATERIAL PISO 1º:</label>
                            <select class="form-control" name="material_piso_1_cap" id="material_piso_1_cap">
                                <option value=""></option>
                                <option value="Epoxico">Epoxico</option>
                                <option value="Alizado">Alizado</option>
                                <option value="Concreto">Concreto</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="material_sotano_cap">MATERIAL PISO SOTANO:</label>
                            <select class="form-control" name="material_sotano_cap" id="material_sotano_cap">
                                <option value=""></option>
                                <option value="Epoxico">Epoxico</option>
                                <option value="Alizado">Alizado</option>
                                <option value="Concreto">Concreto</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="acabados_muro_bode_cap">ACABADOS MURO:</label>
                            <select class="form-control" name="acabados_muro_bode_cap" id="acabados_muro_bode_cap">
                                <option value=""></option>
                                <option value="Estucado">Estucado</option>
                                <option value="Ladrillo">Ladrillo</option>
                                <option value="Pintado">Pintado</option>
                                <option value="Epoxico">Epoxico</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="material_muros_porc_cap">MATERIAL MUROS %</label>
                            <input type='number' name='material_muros_porc_cap' class='form-control' id="material_muros_porc_cap" min='1.0' max='100.0' step='0.1' />
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12 col-sm-2">
                            <label for="tipo_techo_cap">TIPO TECHO:</label>
                            <select class="form-control" name="tipo_techo_cap" id="tipo_techo_cap">
                                <option value=""></option>
                                <option value="Una caída">Una caída</option>
                                <option value="Dos caídas">Dos caídas</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="material_techo_cap">MATERIAL TECHO:</label>
                            <select class="form-control" name="material_techo_cap" id="material_techo_cap">
                                <option value=""></option>
                                <option value="Asbesto">Asbesto</option>
                                <option value="Metal (zinc)">Metal (zinc)</option>
                                <option value="Standing Seam">Standing Seam</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_bodega_cap">TIPO DE BODEGA:</label> <br>
                            <input type="checkbox" name="tipo_bodega_cap[]" value="Industriales"
                                <?php echo in_array('Industriales', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Industriales<br>
                            <input type="checkbox" name="tipo_bodega_cap[]" value="Comerciales"
                                <?php echo in_array('Comerciales', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Comerciales<br>
                            <input type="checkbox" name="tipo_bodega_cap[]" value="Logísticas"
                                <?php echo in_array('Logísticas', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Logísticas<br>
                            <input type="checkbox" name="tipo_bodega_cap[]" value="Usos Mixtos"
                                <?php echo in_array('Usos Mixtos', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Usos Mixtos<br>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>UBICACION</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cod_dane_dep">* DEPARTAMENTO:</label>
                            <select id="cod_dane_dep" class="form-control" name="cod_dane_dep" required="required">
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
                            <label for="id_mun">* MUNICIPIOS:</label>
                            <select id="id_mun" name="id_mun" class="form-control" disabled="disabled" required="required">
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
                            <label for="estrato_cap">ESTRATO:</label>
                            <select class="form-control" name="estrato_cap" id="estrato_cap">
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
                            <label for="posición_cap">POSICIÓN:</label>
                            <select class="form-control" name="posición_cap" id="posición_cap">
                                <option value=""></option>
                                <option value="Vista al sur">Vista al sur</option>
                                <option value="Vista al norte">Vista al norte</option>
                                <option value="Vista al oriente">Vista al oriente</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                    </div>
                    <script>
                        //$('#doc_acud').select2();
                        $("#id_mun").select2({
                            tags: true
                        });
                    </script>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="conjunto_cerrado_cap">CONJUNTO CERRADO:</label>
                            <select class="form-control" name="conjunto_cerrado_cap" id="conjunto_cerrado_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="conjunto_vigilado_cap">CONJUNTO VIGILADO:</label>
                            <select class="form-control" name="conjunto_vigilado_cap" id="conjunto_vigilado_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="porteria_recpecion_cap">PORTERIA | RECEPCION:</label>
                            <select class="form-control" name="porteria_recpecion_cap" id="porteria_recpecion_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>SERVICIOS PUBLICOS</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="energia_precio_kv_cap">ENERGIA PRECIO (kVA) $</label>
                            <input type='number' name='energia_precio_kv_cap' class='form-control' id="energia_precio_kv_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="agua_precio_m3_cap">AGUA PRECIO (m3) $</label>
                            <input type='number' name='agua_precio_m3_cap' class='form-control' id="agua_precio_m3_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="empresa_energia_cap">EMPRESA DE ENERGIA:</label>
                            <select class="form-control" name="empresa_energia_cap" id="empresa_energia_cap">
                                <option value=""></option>
                                <option value="Energía de Pereira">Energía de Pereira</option>
                                <option value="CHEC">CHEC</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_energia_cap">SIST. ELECTRICO:</label>
                            <select class="form-control" name="tipo_energia_cap" id="tipo_energia_cap">
                                <option value=""></option>
                                <option value="Monofásico">Monofásico</option>
                                <option value="Bifásico">Bifásico</option>
                                <option value="Trifásico">Trifásico</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="kva_transformador_cap">kVA TRANSFORMADOR:</label>
                            <input type='number' name='kva_transformador_cap' class='form-control' id="kva_transformador_cap" min='1.0' max='25000' step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="calibre_acometida_cap">CALIBRE ACOMETIDA:</label>
                            <input type='number' name='calibre_acometida_cap' class='form-control' id="calibre_acometida_cap" min='1.0' max='100' step='0.1' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tomas_220_cap">TOMAS 220:</label>
                            <input type='number' name='tomas_220_cap' class='form-control' id="tomas_220_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="redes_inde_cap">REDES INDEP. (DAT/ENTER)</label>
                            <select class="form-control" name="redes_inde_cap" id="redes_inde_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="planta_electrica_cap">PLANTA ELECTRICA:</label>
                            <select class="form-control" name="planta_electrica_cap" id="planta_electrica_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="empresa_agua_cap">EMPRESA ACUEDUCTO:</label>
                            <select class="form-control" name="empresa_agua_cap" id="empresa_agua_cap">
                                <option value=""></option>
                                <option value="Aguas y Aguas de Pereira">Aguas y Aguas de Pereira</option>
                                <option value="Serviciudad">Serviciudad</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tanques_agua_reserva_cap">TANQUES AGUA RESERVA:</label>
                            <select class="form-control" name="tanques_agua_reserva_cap" id="tanques_agua_reserva_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tanques_capacidad_cap">CAPACIDAD (litros):</label>
                            <input type='number' name='tanques_capacidad_cap' class='form-control' id="tanques_capacidad_cap" min='0' step='0.1' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="hidrante_cap">HIDRANTE:</label>
                            <select class="form-control" name="hidrante_cap" id="hidrante_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="gabinete_cont_incendio_cap">GABINETE CONTRA INCENDIO:</label>
                            <select class="form-control" name="gabinete_cont_incendio_cap" id="gabinete_cont_incendio_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="red_contra_incendios_cap">RED CONTRA INCENDIO:</label>
                            <select class="form-control" name="red_contra_incendios_cap" id="red_contra_incendios_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="gas_cap">GAS:</label>
                            <select class="form-control" name="gas_cap" id="gas_cap">
                                <option value=""></option>
                                <option value=3>Viable</option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label for="internet_telefonia_cap">INTERNET | TELEFONIA:</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-sm-2">
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Claro" <?php echo in_array('Claro', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Claro<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Tigo" <?php echo in_array('Tigo', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Tigo<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Movistar" <?php echo in_array('Movistar', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Movistar<br>
                        </div>
                        <div class="col-6 col-sm-2">
                            <input type="checkbox" name="internet_telefonia_cap[]" value="ETB" <?php echo in_array('ETB', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> ETB<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Legón" <?php echo in_array('Legón', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Legón<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Edatel" <?php echo in_array('Edatel', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Edatel<br>
                        </div>
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" name="internet_telefonia_cap[]" value="TuCable" <?php echo in_array('TuCable', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> TuCable<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Súper Redes" <?php echo in_array('Súper Redes', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Súper Redes<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Azteca Comunicaciones" <?php echo in_array('Azteca Comunicaciones', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Azteca Comunicaciones<br>
                        </div>
                        <div class="col-6 col-sm-3">
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Media Commerce" <?php echo in_array('Media Commerce', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Media Commerce<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Wireless Communications" <?php echo in_array('Wireless Communications', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Wireless Communications<br>
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Unitel Colombia" <?php echo in_array('Unitel Colombia', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Unitel Colombia<br>
                        </div>
                        <div class="col-6 col-sm-2">
                            <input type="checkbox" name="internet_telefonia_cap[]" value="Otras" <?php echo in_array('Otras', $internet_telefonia_seleccionados) ? 'checked' : ''; ?>> Otras<br>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>VALORES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="venta_neta_cap">VENTA NETA $</label>
                            <input type='number' name='venta_neta_cap' class='form-control' id="venta_neta_cap" step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="venta_m2_cap">VALOR x m2:</label>
                            <input type='number' name='venta_m2_cap' class='form-control' id="venta_m2_cap" step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="canon_neto_cap">CANON NETO $</label>
                            <input type='number' name='canon_neto_cap' class='form-control' id="canon_neto_cap" step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="canon_m2_cap">CANON x m2:</label>
                            <input type='number' name='canon_m2_cap' class='form-control' id="canon_m2_cap" step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="porcentaje_iva_cap">% IVA:</label>
                            <input type='number' name='porcentaje_iva_cap' class='form-control' id="porcentaje_iva_cap" min='0.0' max='100' step='0.1' value=19.0 />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_iva_cap">VALOR IVA $</label>
                            <input type='text' name='valor_iva_cap' class='form-control' id="valor_iva_cap" readonly style="font-weight: bold; font-size: 14px;" />
                            <input type='hidden' name='valor_iva_cap_hidden' id='valor_iva_cap_hidden' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="admon_cap">ADMINISTRACION $</label>
                            <input type='number' name='admon_cap' class='form-control' id="admon_cap" step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="renta_total_cap">* RENTA TOTAL $</label>
                            <input type='text' name='renta_total_cap' class='form-control' id="renta_total_cap" readonly style="font-weight: bold; font-size: 14px;" required />
                            <input type='hidden' name='renta_total_cap_hidden' id='renta_total_cap_hidden' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="rte_fte_cap">RTE FTE $</label>
                            <select class="form-control" name="rte_fte_cap" id="rte_fte_cap">
                                <option value=""></option>
                                <option value=2.5>2.5</option>
                                <option value=3.5>3.5</option>
                                <option value=0>0</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>INFORMACION ADICIONAL</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tractomulas_cap">ACCESO TRACTOMULAS:</label>
                            <select class="form-control" name="tractomulas_cap" id="tractomulas_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tractomulas_ctd_cap">¿CUANTOS ACCESOS?</label>
                            <input type='number' name='tractomulas_ctd_cap' class='form-control' id="tractomulas_ctd_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="entrada_veh_directo_cap">ENTRADA VEH. DIRECTA:</label>
                            <select class="form-control" name="entrada_veh_directo_cap" id="entrada_veh_directo_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="entrada_veh_ctd_cap">¿CUANTAS ENTRADAS?</label>
                            <input type='number' name='entrada_veh_ctd_cap' class='form-control' id="entrada_veh_ctd_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="ampliacion_viable_cap">AMPLIACION VIABLE:</label>
                            <select class="form-control" name="ampliacion_viable_cap" id="ampliacion_viable_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="frentes_inmueble_cap">FRENTES INMUEBLE:</label>
                            <select class="form-control" name="frentes_inmueble_cap" id="frentes_inmueble_cap">
                                <option value=""></option>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="puertas_vehiculares_cap">PUERTAS VEHICULARES:</label>
                            <input type='number' name='puertas_vehiculares_cap' class='form-control' id="puertas_vehiculares_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="empresas_vecinas_cap">EMPRESAS VECINAS:</label>
                            <select class="form-control" name="empresas_vecinas_cap" id="empresas_vecinas_cap">
                                <option value=""></option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                                <option value="2">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="transporte_publico_cap">TRANS. PUBLICO:</label>
                            <select class="form-control" name="transporte_publico_cap" id="transporte_publico_cap">
                                <option value=""></option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                                <option value="2">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="ctd_muelle_graduable_cap">CANTIDAD MUELLES:</label>
                            <input type='number' name='ctd_muelle_graduable_cap' class='form-control' id="ctd_muelle_graduable_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="ctd_muelle_tractomula_cap">CANT. MUELLES TRACT.:</label>
                            <input type='number' name='ctd_muelle_tractomula_cap' class='form-control' id="ctd_muelle_tractomula_cap" />
                        </div>
                    </div>

                    <!-- Campos dinámicos generados por JavaScript -->
                    <div id="dynamic_fields">
                        <!-- Campos adicionales aparecerán aquí -->
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>MATERIAL DISPONIBLE</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="fotos_cap">EVIDENCIA FOTOGRAFICA:</label>
                            <select class="form-control" name="fotos_cap" id="fotos_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="videos_cap">GRABACIONES:</label>
                            <select class="form-control" name="videos_cap" id="videos_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="planos_cap">PLANOS:</label>
                            <select class="form-control" name="planos_cap" id="planos_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="uso_suelos_cap">USO DE SUELOS:</label>
                            <select class="form-control" name="uso_suelos_cap" id="uso_suelos_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="mapas_cap">MAPAS:</label>
                            <select class="form-control" name="mapas_cap" id="mapas_cap">
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>PROPIETARIO(S)</legend>
                    <div class="row">
                        <div class="col-12 col-sm-5">
                            <label for="direccion_inm_cap">* DIRECCIÓN EXACTA:</label>
                            <input type='text' name='direccion_inm_cap' class='form-control' id="direccion_inm_cap" required style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="num_matricula_inm_cap">MATRÍCULA INMOB.</label>
                            <input type='text' name='num_matricula_inm_cap' class='form-control' id="num_matricula_inm_cap" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="num_matricula_agua_cap">MATRIC. AGUA:</label>
                            <input type='number' value=0 name='num_matricula_agua_cap' id="num_matricula_agua_cap" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="num_matricula_energia_cap">MATRIC. ENERGIA:</label>
                            <input type='number' value=0 name='num_matricula_energia_cap' id="num_matricula_energia_cap" class='form-control' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="num_matricula_gas_cap">MATRIC. GAS:</label>
                            <input type='number' value=0 name='num_matricula_gas_cap' id="num_matricula_gas_cap" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-5">
                            <label for="nombre_razon_social_cap">* NOMBRE y/o RAZON SOCIAL:</label>
                            <input type='text' name='nombre_razon_social_cap' class='form-control' id="nombre_razon_social_cap" required style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="representante_legal_cap">REPRESENTANTE LEGAL:</label>
                            <input type='text' name='representante_legal_cap' class='form-control' id="representante_legal_cap" style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cc_nit_repre_legal_cap">CC REP. LEGAL:</label>
                            <input type='text' name='cc_nit_repre_legal_cap' class='form-control' id="cc_nit_repre_legal_cap" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cel_repre_legal_cap">* CELULAR:</label>
                            <input type='number' value=0 name='cel_repre_legal_cap' id="cel_repre_legal_cap" class='form-control' required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tel_repre_legal_cap">TELEFONO:</label>
                            <input type='number' value=0 name='tel_repre_legal_cap' id="tel_repre_legal_cap" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="email_repre_legal_cap">EMAIL:</label>
                            <input type='email' name='email_repre_legal_cap' class='form-control' id="email_repre_legal_cap" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="dir_repre_legal_cap">DIRECCION:</label>
                            <input type='text' name='dir_repre_legal_cap' class='form-control' id="dir_repre_legal_cap" style="text-transform:uppercase;" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="remuneracion_vta_cap">REMUNER. VTA $</label>
                            <input type='number' value=0 name='remuneracion_vta_cap' id="remuneracion_vta_cap" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="remuneracion_renta_cap">REMUNER. RENTA $</label>
                            <input type='number' value=0 name='remuneracion_renta_cap' id="remuneracion_renta_cap" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-8">
                            <label for="nombre_usu">* ASESOR COMERCIAL:</label>
                            <input type="text" name="nombre_usu" id="nombre_usu" class="form-control" readonly value="<?php echo htmlspecialchars($nombre_usu, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="nit_cc_ase" id="nit_cc_ase" value="<?php echo htmlspecialchars($nit_cc_ase, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>COMENTARIOS ADICIONALES y/o OBSERVACIONES SOBRE LA ADMINISTRACIÓN</legend>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="obs1_cap">COMENTARIOS GENERALES:</label>
                            <textarea class="form-control" id="obs1_cap" rows="3" name="obs1_cap" style="text-transform:uppercase;"></textarea>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="obs2_cap">OBSERVACIONES SOBRE LA ADMINISTRACIÓN (NEGOCIACIÓN):</label>
                            <textarea class="form-control" id="obs2_cap" rows="3" name="obs2_cap" style="text-transform:uppercase;"></textarea>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>ARCHIVOS ADJUNTOAS</legend>
                    <div class="row">
                        <div class="col-12">
                            <label for="archivo"><strong><i class="fa-regular fa-image"></i> ADJUNTAR EVIDENCIAS:</strong></label>
                            <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="image/jpeg,image/gif,image/png,image/jpg,image/bmp,image/webp,application/pdf,image/x-eps">
                            <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;">Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
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
</body>
<script src="../../js/jquery-3.1.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#cod_dane_dep').on('change', function() {
            if ($('#cod_dane_dep').val() == "") {
                $('#id_mun').empty();
                $('<option value = "">Seleccione un municipio</option>').appendTo('#id_mun');
                $('#id_mun').attr('disabled', 'disabled');
            } else {
                $('#id_mun').removeAttr('disabled', 'disabled');
                $('#id_mun').load('modules_get.php?cod_dane_dep=' + $('#cod_dane_dep').val());
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        function formatCOP(value) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP'
            }).format(value);
        }

        function calcularValores() {
            var canon_neto = parseFloat($('#canon_neto_cap').val()) || 0;
            var porcentaje_iva = parseFloat($('#porcentaje_iva_cap').val()) || 0;
            var admon = parseFloat($('#admon_cap').val()) || 0;

            var valor_iva = canon_neto * (porcentaje_iva / 100);
            var renta_total = canon_neto + valor_iva + admon;

            $('#valor_iva_cap').val(formatCOP(valor_iva));
            $('#renta_total_cap').val(formatCOP(renta_total));

            // Actualizar los campos ocultos con los valores numéricos para enviar al servidor
            $('#valor_iva_cap_hidden').val(valor_iva);
            $('#renta_total_cap_hidden').val(renta_total);
        }

        $('#canon_neto_cap, #porcentaje_iva_cap, #admon_cap').on('input', function() {
            calcularValores();
        });
    });
</script>
<script>
    // Mostrar el modal al cargar la página
    window.addEventListener('load', function() {
        const consentModal = new bootstrap.Modal(document.getElementById('consentModal'));
        consentModal.show();

        // Botón de "Acepto"
        document.getElementById('acceptButton').addEventListener('click', function() {
            consentModal.hide(); // Cierra el modal
            alert('Gracias por aceptar el consentimiento informado.');
            // Puedes agregar aquí lógica adicional
        });

        // Botón de "No acepto"
        document.getElementById('declineButton').addEventListener('click', function() {
            window.history.back(); // Regresa a la página anterior
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const ctdMuelleGraduable = document.getElementById('ctd_muelle_graduable_cap');
        const ctdMuelleTractomula = document.getElementById('ctd_muelle_tractomula_cap');
        const dynamicFieldsContainer = document.getElementById('dynamic_fields');

        // Generar campos dinámicos para muelles graduables
        function generateFieldsForGraduable() {
            // Limpiar campos existentes
            dynamicFieldsContainer.innerHTML = '';
            const numGraduable = parseInt(ctdMuelleGraduable.value) || 0;

            for (let i = 0; i < numGraduable; i++) {
                const fieldGroup = document.createElement('div');
                fieldGroup.className = 'col-12 col-sm-2';

                // Campo de altura de muelle graduable
                const alturaInput = document.createElement('input');
                alturaInput.type = 'number';
                alturaInput.name = 'altura_muelle_graduable_cap[]'; // Nombre de array
                alturaInput.className = 'form-control';
                alturaInput.placeholder = `Altura Muelle Graduable #${i + 1}`;
                alturaInput.step = '0.1';

                fieldGroup.appendChild(alturaInput);
                dynamicFieldsContainer.appendChild(fieldGroup);
            }

            // Agrega el console.log aquí para verificar la generación de campos
            console.log('Campos generados para muelles graduables:', document.querySelectorAll('input[name="altura_muelle_graduable_cap[]"]'));
        }

        // Generar campos dinámicos para muelles de tractomula
        function generateFieldsForTractomula() {
            // Limpiar campos existentes
            const existingFields = document.querySelectorAll('[name^="tipo_muelle_tractomula_cap"], [name^="altura_muelle_tractomula_cap"]');
            existingFields.forEach(field => field.parentElement.remove());

            const numTractomula = parseInt(ctdMuelleTractomula.value) || 0;

            for (let i = 0; i < numTractomula; i++) {
                const fieldGroup = document.createElement('div');
                fieldGroup.className = 'col-12 col-sm-2';

                // Campo de tipo de muelle
                const tipoMuelleSelect = document.createElement('select');
                tipoMuelleSelect.name = 'tipo_muelle_tractomula_cap[]'; // Nombre de array
                tipoMuelleSelect.className = 'form-control';
                tipoMuelleSelect.innerHTML = `
                        <option value="">Tipo Muelle #${i + 1}</option>
                        <option value="fijo">Fijo</option>
                        <option value="graduable">Graduable</option>
                    `;

                // Campo de altura de muelle tractomula
                const alturaInput = document.createElement('input');
                alturaInput.type = 'number';
                alturaInput.name = 'altura_muelle_tractomula_cap[]'; // Nombre de array
                alturaInput.className = 'form-control';
                alturaInput.placeholder = `Altura Muelle Tractomula #${i + 1}`;
                alturaInput.step = '0.1';

                fieldGroup.appendChild(tipoMuelleSelect);
                fieldGroup.appendChild(alturaInput);
                dynamicFieldsContainer.appendChild(fieldGroup);
            }
            // Agrega el console.log aquí para verificar la generación de campos
            console.log('Campos generados para muelles tractomula:', document.querySelectorAll('input[name="altura_muelle_tractomula_cap[]"]'));
        }
        // Eventos de cambio para los campos de entrada
        ctdMuelleGraduable.addEventListener('input', function() {
            generateFieldsForGraduable();
        });

        ctdMuelleTractomula.addEventListener('input', function() {
            generateFieldsForTractomula();
        });
    });
</script>

</html>
