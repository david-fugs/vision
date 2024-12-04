<?php

    session_start();

    if(!isset($_SESSION['id_usu'])){
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
        /* Reducir el tamaño de la fuente en los labels y añadir color gris claro */
        label {
            font-size: 10px; /* Ajuste entre 9 y 10px */
            font-weight: bold;
            color: #000000; /* Color gris muy claro */
            transition: color 0.3s ease; /* Transición suave para el cambio de color */
        }
        /* Ajustar tamaño de las cajas de texto y select para que sean iguales */
        input.form-control, select.form-control {
            font-size: 10px; /* Ajuste del tamaño de la fuente dentro de las cajas de texto */
            padding: 0.3rem 0.6rem; /* Ajusta el relleno para hacer las cajas más compactas */
            color: black; /* Texto en negro */
            box-sizing: border-box; /* Asegura que el padding se incluya dentro de la altura */
            height: 32px; /* Fija la altura de input y select para que sean iguales */
        }

        textarea.form-control {
            font-size: 10px; /* Ajuste del tamaño de la fuente dentro de las cajas de texto */
            padding: 0.3rem 0.6rem; /* Ajusta el relleno para hacer las cajas más compactas */
            color: black; /* Texto en negro */
            box-sizing: border-box; /* Asegura que el padding se incluya dentro de la altura */
        }
        /* Aplicar fondo pastel cuando el input o select está en foco */
        input.form-control:focus, select.form-control:focus, textarea.form-control:focus {
            background-color: #f0e68c; /* Fondo color pastel */
            outline: none; /* Eliminar borde azul de enfoque en navegadores */
        }
        /* Resaltar el label cuando el input o select está en foco */
        .form-group:focus-within label {
            color: #c68615; /* Cambia el color del label cuando el input o select está en foco */
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
            background-color: #e6f7ff; /* Azul muy claro */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3); /* Sombreado azul claro */
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.select2').select2(); // Inicializar Select2 en todos los selectores con clase 'select2'
        });
    </script>
    <script>
        function ordenarSelect(id_componente) {
            var selectToSort = jQuery('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function (a, b) {
                return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
        }

        $(document).ready(function () {
            ordenarSelect('cod_dane_dep');
            ordenarSelect('id_mun');
        });
    </script>
</head>
<body>

    <div class="container">
        <h1><img src='../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-house-circle-check"></i> FICHA TECNICA INMUEBLES RESIDENCIALES</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

        <form action='addcap1.php' enctype="multipart/form-data" method="POST">

             <div class="form-group">
                <fieldset>
                    <legend>MEDIDAS</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cod_capr">COD.</label>
                            <input type='number' name='cod_capr' class='form-control' id="cod_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_total_capr">* AREA TOTAL:</label>
                            <input type='number' name='area_total_capr' class='form-control' id="area_total_capr"  />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_lote_capr">AREA LOTE:</label>
                            <input type='number' name='area_lote_capr' class='form-control' id="area_lote_capr"/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_piso1_capr">AREA PISO 1º:</label>
                            <input type='number' name='area_piso1_capr' class='form-control' id="area_piso1_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="area_piso2_capr">AREA PISO 2º:</label>
                            <input type='number' name='area_piso2_capr' class='form-control' id="area_piso2_capr" />
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>HABITACIONES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="frente_habi1_capr">FRENTE HAB. 1:</label>
                            <input type='number' name='frente_habi1_capr' class='form-control' id="frente_habi1_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_habi1_capr">FONDO HAB. 1:</label>
                            <input type='number' name='fondo_habi1_capr' class='form-control' id="fondo_habi1_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="frente_habi2_capr">FRENTE HAB. 2:</label>
                            <input type='number' name='frente_habi2_capr' class='form-control' id="frente_habi2_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_habi2_capr">FONDO HAB. 2:</label>
                            <input type='text' name='fondo_habi2_capr' class='form-control' id="fondo_habi2_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="frente_habi3_capr">FRENTE HAB. 3:</label>
                            <input type='number' name='frente_habi3_capr' class='form-control' id="frente_habi3_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_habi3_capr">FONDO HAB. 3:</label>
                            <input type='text' name='fondo_habi3_capr' class='form-control' id="fondo_habi3_capr" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="frente_sala_capr">FRENTE SALA:</label>
                            <input type='text' name='frente_sala_capr' class='form-control' id="frente_sala_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fondo_sala_capr">FONDO SALA:</label>
                            <input type='number' name='fondo_sala_capr' class='form-control' id="fondo_sala_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="vestidores_capr">VESTIDORES:</label>
                            <input type='number' name='vestidores_capr' class='form-control' id="vestidores_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="closets_capr">CLOSETS:</label>
                            <input type='number' name='closets_capr' class='form-control' id="closets_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="salas_capr">SALAS:</label>
                            <input type='number' name='salas_capr' class='form-control' id="salas_capr" />
                        </div>
                    </div>
                 </fieldset>
            </div>

            <div class="form-group">
                <fieldset>
                    <legend>MIRADORES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="balcon_capr">* BALCON:</label>
                            <select class="form-control" name="balcon_capr" id="balcon_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="terraza_capr">* TERRAZA:</label>
                            <select class="form-control" name="terraza_capr" id="terraza_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="patio_capr">* PATIO:</label>
                            <select class="form-control" name="patio_capr" id="patio_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sotanos_capr">* SOTANO:</label>
                            <select class="form-control" name="sotanos_capr" id="sotanos_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="pisos_capr">* OTROS PISOS:</label>
                            <select class="form-control" name="pisos_capr" id="pisos_capr" >
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
                    <legend>COCINA</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tipo_cocina_capr">* TIPO COCINA INTEG.</label>
                            <select class="form-control" name="tipo_cocina_capr" id="tipo_cocina_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="isla_cocina_capr">* ISLA COCINA INTEG.</label>
                            <select class="form-control" name="isla_cocina_capr" id="isla_cocina_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_lavaplatos_capr">* LAVAPLATOS:</label>
                            <select class="form-control" name="tipo_lavaplatos_capr" id="tipo_lavaplatos_capr" >
                                <option value=""></option>
                                <option value="Doble">Doble</option>
                                <option value="Sencillo">Sencillo</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="espacio_nevecon_capr">* ESPACIO NEVECON:</label>
                            <select class="form-control" name="espacio_nevecon_capr" id="espacio_nevecon_capr" >
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
                    <legend>UBICACION</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cod_dane_dep">* DEPARTAMENTO:</label>
                            <select id = "cod_dane_dep" class = "form-control" name = "cod_dane_dep"  = "" required>
                                <option value = ""></option>
                                <?php
                                    $sql = $mysqli->prepare("SELECT * FROM departamentos");
                                    if($sql->execute()){
                                        $g_result = $sql->get_result();
                                    }
                                    while($row = $g_result->fetch_array()){
                                ?>
                                    <option value = "<?php echo $row['cod_dane_dep']?>"><?php echo $row['nom_dep']?></option>
                                <?php
                                        }
                                    $mysqli->close();
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="id_mun">* MUNICIPIOS:</label>
                            <select  id = "id_mun" name = "id_mun"  class = "form-control" disabled = "disabled"  = "" required>
                                    <option value = "">* SELECCIONE EL MUNICIPIO:</option>
                                </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sector_capr">* SECTOR:</label>
                            <input type='text' name='sector_capr' class='form-control' id="sector_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="ubicacion_gps_capr">* UBICACION GPS:</label>
                            <input type='text' name='ubicacion_gps_capr' class='form-control' id="ubicacion_gps_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="estrato_capr">* ESTRATO:</label>
                            <select class="form-control" name="estrato_capr" id="estrato_capr" >
                                <option value=""></option>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                                <option value=6>6</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="posición_capr">POSICIÓN:</label>
                            <input type='number' name='posición_capr' class='form-control' id="posición_capr"/>
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
                        <label for="conjunto_cerrado_capr">* CONJUNTO CERRADO:</label>
                        <select class="form-control" name="conjunto_cerrado_capr" id="conjunto_cerrado_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="conjunto_vigilado_capr">* CONJUNTO VIGILADO:</label>
                        <select class="form-control" name="conjunto_vigilado_capr" id="conjunto_vigilado_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="porteria_recpecion_capr">* PORTERIA | RECEPCION:</label>
                        <select class="form-control" name="porteria_recpecion_capr" id="porteria_recpecion_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="citofonia_capr">* CITOFONIA:</label>
                        <select class="form-control" name="citofonia_capr" id="citofonia_capr" >
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
                <legend>GENERALES</legend>
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="edad_capr">EDAD:</label>
                        <input type='number' name='edad_capr' class='form-control' id="edad_capr"/>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="estado_inm_capr">* ESTADO:</label>
                        <select class="form-control" name="estado_inm_capr" id="estado_inm_capr" >
                            <option value=""></option>
                            <option value="Excelente">Excelente</option>
                            <option value="Buena">Buena</option>
                            <option value="Regular">Regular</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="niveles_internos_capr">* NIVELES INTERNOS:</label>
                        <select class="form-control" name="niveles_internos_capr" id="niveles_internos_capr" >
                            <option value=""></option>
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                            <option value=4>+3</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tipo_capr">* TIPO:</label>
                        <select class="form-control" name="tipo_capr" id="tipo_capr" >
                            <option value=""></option>
                            <option value="Industrial">Industrial</option>
                            <option value="Comercial">Comercial</option>
                            <option value="Residencial">Residencial</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="esquinera_medianera_capr">* ESQUINERA | MEDIANERA:</label>
                        <select class="form-control" name="esquinera_medianera_capr" id="esquinera_medianera_capr" >
                            <option value=""></option>
                            <option value="Esquinera">Esquinera</option>
                            <option value="Medianera">Medianera</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="oficinas_capr">* OFICINAS:</label>
                        <input type='number' name='oficinas_capr' class='form-control' id="oficinas_capr" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="duchas_capr">* DUCHAS:</label>
                        <input type='number' name='duchas_capr' class='form-control' id="duchas_capr" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="lavamanos_capr">* LAVAMANOS:</label>
                        <input type='number' name='lavamanos_capr' class='form-control' id="lavamanos_capr"  />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="sanitarios_capr">* SANITARIOS:</label>
                        <input type='number' name='sanitarios_capr' class='form-control' id="sanitarios_capr"  />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="poceta_capr">* POCETA:</label>
                        <input type='number' name='poceta_capr' class='form-control' id="poceta_capr" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="cocineta_capr">* COCINETA:</label>
                        <input type='number' name='cocineta_capr' class='form-control' id="cocineta_capr" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tinas_capr">* TINAS:</label>
                        <input type='number' name='tinas_capr' class='form-control' id="tinas_capr" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="transporte_publico_capr">* TRANS. PUBLICO:</label>
                        <select class="form-control" name="transporte_publico_capr" id="transporte_publico_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="aire_acondicionado_capr">* AIRE ACONDICIONADO:</label>
                        <select class="form-control" name="aire_acondicionado_capr" id="aire_acondicionado_capr" >
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
                <legend>GENERALES</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="energia_precio_kv_capr">* ENERGIA PRECIO (kVA) $</label>
                            <input type='number' name='energia_precio_kv_capr' class='form-control' id="energia_precio_kv_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="agua_precio_m3_capr">* AGUA PRECIO (m3) $</label>
                            <input type='number' name='agua_precio_m3_capr' class='form-control' id="agua_precio_m3_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="empresa_energia_capr">* EMPRESA DE ENERGIA:</label>
                            <select class="form-control" name="empresa_energia_capr" id="empresa_energia_capr" >
                                <option value=""></option>
                                <option value="Energía de Pereira">Energía de Pereira</option>
                                <option value="CHEC">CHEC</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tipo_energia_capr">* SIST. ELECTRICO:</label>
                            <select class="form-control" name="tipo_energia_capr" id="tipo_energia_capr" >
                                <option value=""></option>
                                <option value="Monofásico">Monofásico</option>
                                <option value="Bifásico">Bifásico</option>
                                <option value="Trifásico">Trifásico</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="kva_transformador_capr">* kVA TRANSFORMADOR:</label>
                            <input type='number' name='kva_transformador_capr' class='form-control' id="kva_transformador_capr" min='1.0' max='25000' step='0.1' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="calibre_acometida_capr">* CALIBRE ACOMETIDA:</label>
                            <input type='number' name='calibre_acometida_capr' class='form-control' id="calibre_acometida_capr" min='1.0' max='100' step='0.1' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="tomas_220_capr">* TOMAS 220:</label>
                            <input type='number' name='tomas_220_capr' class='form-control' id="tomas_220_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="redes_inde_capr">* REDES INDEP. (DAT/ENTER)</label>
                            <input type='number' name='redes_inde_capr' class='form-control' id="redes_inde_capr" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="planta_electrica_capr">* PLANTA ELECTRICA:</label>
                            <select class="form-control" name="planta_electrica_capr" id="planta_electrica_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="empresa_agua_capr">* EMPRESA ACUEDUCTO:</label>
                            <select class="form-control" name="empresa_agua_capr" id="empresa_agua_capr" >
                                <option value=""></option>
                                <option value="Aguas y Aguas de Pereira">Aguas y Aguas de Pereira</option>
                                <option value="Serviciudad">Serviciudad</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tanques_agua_reserva_capr">* TANQUES AGUA RESERVA:</label>
                            <select class="form-control" name="tanques_agua_reserva_capr" id="tanques_agua_reserva_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="hidrante_capr">* HIDRANTE:</label>
                            <select class="form-control" name="hidrante_capr" id="hidrante_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="gabinete_cont_incendio_capr">* GABINETE CONTRA INCENDIO:</label>
                            <select class="form-control" name="gabinete_cont_incendio_capr" id="gabinete_cont_incendio_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="red_contra_incendios_capr">* RED CONTRA INCENDIO:</label>
                            <select class="form-control" name="red_contra_incendios_capr" id="red_contra_incendios_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="gas_capr">* GAS:</label>
                            <select class="form-control" name="gas_capr" id="gas_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="agua_caliente_capr">* AGUA CALIENTE:</label>
                            <select class="form-control" name="agua_caliente_capr" id="agua_caliente_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="internet_telefonia_capr">* INTERNET | TELEFONIA:</label>
                            <select class="form-control" name="internet_telefonia_capr" id="internet_telefonia_capr" >
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
                    <legend>COMERCIO CERCANO</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="restaurantes_capr">* RESTAURANTES:</label>
                            <select class="form-control" name="restaurantes_capr" id="restaurantes_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="supermercados_capr">* SUPERMERCADOS:</label>
                            <select class="form-control" name="supermercados_capr" id="supermercados_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="droguerias_capr">* DROGUERIAS:</label>
                            <select class="form-control" name="droguerias_capr" id="droguerias_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="centro_comer_capr">* CENTRO COMERCIAL:</label>
                            <select class="form-control" name="centro_comer_capr" id="centro_comer_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="universidades_capr">* UNIVERSIDADES:</label>
                            <select class="form-control" name="universidades_capr" id="universidades_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="colegios_capr">* COLEGIOS:</label>
                            <select class="form-control" name="colegios_capr" id="colegios_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="jardines_infantiles_capr">* JARDINES INFANTILES:</label>
                            <select class="form-control" name="jardines_infantiles_capr" id="jardines_infantiles_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="otros_capr">* OTROS:</label>
                            <select class="form-control" name="otros_capr" id="otros_capr" >
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
                    <legend>ZONAS SOCIALES - JUEGOS</legend>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="jardines_capr">* JARDINES:</label>
                            <select class="form-control" name="jardines_capr" id="jardines_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="turcos_capr">* TURCO:</label>
                            <select class="form-control" name="turcos_capr" id="turcos_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="jacuzzi_capr">* JACUZZI:</label>
                            <select class="form-control" name="jacuzzi_capr" id="jacuzzi_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="sauna_capr">* SAUNA:</label>
                            <select class="form-control" name="sauna_capr" id="sauna_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cancha_tenis_capr">* CANCHA TENIS:</label>
                            <select class="form-control" name="cancha_tenis_capr" id="cancha_tenis_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cancha_futbol_capr">* CANCHA FUTBOL:</label>
                            <select class="form-control" name="cancha_futbol_capr" id="cancha_futbol_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="cancha_micro_fut_capr">* CANCHA MICRO FUT.</label>
                            <select class="form-control" name="cancha_micro_fut_capr" id="cancha_micro_fut_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cancha_basquet_capr">* CANCHA BALONCESTO:</label>
                            <select class="form-control" name="cancha_basquet_capr" id="cancha_basquet_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="piscina_adultos_capr">* PISCINA ADULTOS:</label>
                            <select class="form-control" name="piscina_adultos_capr" id="piscina_adultos_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="piscina_ninos_capr">* PISCINA NIÑOS:</label>
                            <select class="form-control" name="piscina_ninos_capr" id="piscina_ninos_capr" >
                                <option value=""></option>
                                <option value=1>Sí</option>
                                <option value=0>No</option>
                                <option value=2>N/A</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                        <label for="sendero_ecol_capr">* SENDERO ECOLOGICO:</label>
                        <select class="form-control" name="sendero_ecol_capr" id="sendero_ecol_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="mascotas_capr">* PERMITEN MASCOTAS:</label>
                        <select class="form-control" name="mascotas_capr" id="mascotas_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="zona_mascotas_capr">* ZONA MASCOTAS:</label>
                        <select class="form-control" name="zona_mascotas_capr" id="zona_mascotas_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="gym_capr">* GIMNASIO:</label>
                        <select class="form-control" name="gym_capr" id="gym_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="ascensor_capr">* CON ASCENSOR:</label>
                        <select class="form-control" name="ascensor_capr" id="ascensor_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="juegos_ninos_capr">* JUEGOS INFANTILES:</label>
                        <select class="form-control" name="juegos_ninos_capr" id="juegos_ninos_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="lago_pesca_capr">* LAGO PESCA:</label>
                        <select class="form-control" name="lago_pesca_capr" id="lago_pesca_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="cancha_squash_capr  ">* CANCHA SQUASH:</label>
                        <select class="form-control" name="cancha_squash_capr   " id="cancha_squash_capr    " >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="otros_juegos_capr">* OTROS JUEGOS:</label>
                        <select class="form-control" name="otros_juegos_capr" id="otros_juegos_capr" >
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
                <legend>ACABADOS</legend>
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="acabados_pisos_capr">* ACABADOS PISO:</label>
                        <select class="form-control" name="acabados_pisos_capr" id="acabados_pisos_capr" >
                            <option value=""></option>
                            <option value="Epoxico">Epoxico</option>
                            <option value="Alizado">Alizado</option>
                            <option value="Concreto">Concreto</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="acabados_muro_capr">* ACABADOS MURO:</label>
                        <select class="form-control" name="acabados_muro_capr" id="acabados_muro_capr" >
                            <option value=""></option>
                            <option value="Concreto">Concreto</option>
                            <option value="Ladrillo a la vista">Ladrillo a la vista</option>
                            <option value="Revestimiento con pintura epóxica">Revestuimiento con pintura epóxica</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="material_muro_por_capr">* MATERIAL MUROS %</label>
                        <input type='number' name='material_muro_por_capr' class='form-control' id="material_muro_por_capr" min='1.0' max='100.0' step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tipo_techo_capr">* TIPO TECHO:</label>
                        <select class="form-control" name="tipo_techo_capr" id="tipo_techo_capr" >
                            <option value=""></option>
                            <option value="Una caída">Una caída</option>
                            <option value="Dos caídas">Dos caídas</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="material_techo_capr">* MATERIAL TECHO:</label>
                        <select class="form-control" name="material_techo_capr" id="material_techo_capr" >
                            <option value=""></option>
                            <option value="AAAA">AAAA</option>
                            <option value="BBBB">BBBB</option>
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="form-group">
            <fieldset>
                <legend>ACCESO VEHICULAR</legend>
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="parquead_cubi_capr">* PARQUEADERO CUBIERTO:</label>
                        <select class="form-control" name="parquead_cubi_capr" id="parquead_cubi_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="parquead_descubi_capr">* PARQUEADERO DESCUBIERTO:</label>
                        <select class="form-control" name="parquead_descubi_capr" id="parquead_descubi_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="entrada_veh_directo_cap">* ENTRADA VEH. DIRECTA:</label>
                        <select class="form-control" name="entrada_veh_directo_cap" id="entrada_veh_directo_cap" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="puertas_vehic_capr">* PUERTAS VEHICULARES:</label>
                        <input type='number' name='puertas_vehic_capr' class='form-control' id="puertas_vehic_capr" min='1' max='100' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="puertas_peaton_capr">* PUERTAS PEATONALES:</label>
                        <input type='number' name='puertas_peaton_capr' class='form-control' id="puertas_peaton_capr" min='1' max='100' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="frentes_inmu_capr">* FRENTES INMUEBLE:</label>
                        <input type='number' name='frentes_inmu_capr' class='form-control' id="frentes_inmu_capr" min='1' max='100' />
                    </div>
                </div>
            </fieldset>
        </div>

     <div class="form-group">
            <fieldset>
                <legend>VALORES $$$</legend>
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="venta_neta_capr">* VENTA NETAS $</label>
                        <input type='number' name='venta_neta_capr' class='form-control' id="venta_neta_capr" step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="venta_m2_capr">* VENTA x m2:</label>
                        <input type='number' name='venta_m2_capr' class='form-control' id="venta_m2_capr" step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="canon_neto_capr">* CANON NETO $</label>
                        <input type='number' name='canon_neto_capr' class='form-control' id="canon_neto_capr" step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="canon_m2_capr">* CANON x m2:</label>
                        <input type='number' name='canon_m2_capr' class='form-control' id="canon_m2_capr" step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="porcentaje_iva_capr">* % IVA:</label>
                        <input type='number' name='porcentaje_iva_capr' class='form-control' id="porcentaje_iva_capr" min='1.0' max='100' step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="valor_iva_capr">* VALOR IVA $</label>
                        <input type='number' name='valor_iva_capr' class='form-control' id="valor_iva_capr" step='0.1' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="admon_capr">* ADMINISTRACION $</label>
                        <input type='number' name='admon_capr' class='form-control' id="admon_capr" step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="renta_total_capr">* RENTA TOTAL $</label>
                        <input type='number' name='renta_total_capr' class='form-control' id="renta_total_capr" step='0.1' />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="rte_fte_capr">* RTE FTE $</label>
                        <input type='number' name='rte_fte_capr' class='form-control' id="rte_fte_capr" step='0.1' />
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="form-group">
            <fieldset>
                <legend>MATERIAL DISPONIBLE</legend>
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="fotos_capr">* EVIDENCIA FOTOGRAFICA:</label>
                        <select class="form-control" name="fotos_capr" id="fotos_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="videos_capr">* GRABACIONES:</label>
                        <select class="form-control" name="videos_capr" id="videos_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="planos_capr">* PLANOS:</label>
                        <select class="form-control" name="planos_capr" id="planos_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="uso_suelos_capr">* USO DE SUELOS:</label>
                        <select class="form-control" name="uso_suelos_capr" id="uso_suelos_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="mapas_capr">* MAPAS:</label>
                        <select class="form-control" name="mapas_capr" id="mapas_capr" >
                            <option value=""></option>
                            <option value=1>Sí</option>
                            <option value=0>No</option>
                            <option value=2>N/A</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="empresas_vecinas_capr">* EMPRESAS VECINAS:</label>
                        <select class="form-control" name="empresas_vecinas_capr" id="empresas_vecinas_capr" >
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
                <legend>PROPIETARIOS(S)</legend>
                <div class="row">
                    <div class="col-12 col-sm-5">
                        <label for="direccion_inm_capr">* DIRECCIÓN EXACTA:</label>
                        <input type='text' name='direccion_inm_capr' class='form-control' id="direccion_inm_capr"  style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-3">
                            <label for="num_matricula_inm_capr">MATRÍCULA INMOB.</label>
                            <input type='text' name='num_matricula_inm_capr' class='form-control' id="num_matricula_inm_capr" />
                        </div>
                    <div class="col-12 col-sm-2">
                        <label for="num_matricula_agua_capr">MATRIC. AGUA:</label>
                        <input type='number' value=0 name='num_matricula_agua_capr' id="num_matricula_agua_capr" class='form-control'/>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="num_matricula_energia_capr">MATRIC. ENERGIA:</label>
                        <input type='number' value=0 name='num_matricula_energia_capr' id="num_matricula_energia_capr" class='form-control' />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="num_matricula_gas_capr">MATRIC. GAS:</label>
                        <input type='number' value=0 name='num_matricula_gas_capr' id="num_matricula_gas_capr" class='form-control' />
                    </div>
                    <div class="col-12 col-sm-5">
                        <label for="nombre_razon_social_capr">* NOMBRE y/o RAZON SOCIAL:</label>
                        <input type='text' name='nombre_razon_social_capr' class='form-control' id="nombre_razon_social_capr"  style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="representante_legal_capr">REPRESENTANTE LEGAL:</label>
                        <input type='text' name='representante_legal_capr' class='form-control' id="representante_legal_capr" style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="cc_nit_repre_legal_capr">CC REP. LEGAL:</label>
                        <input type='text' name='cc_nit_repre_legal_capr' class='form-control' id="cc_nit_repre_legal_capr" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="cel_repre_legal_capr">* CELULAR:</label>
                        <input type='number' value=0 name='cel_repre_legal_capr' id="cel_repre_legal_capr" class='form-control'  />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tel_repre_legal_capr">TELEFONO:</label>
                        <input type='number' value=0 name='tel_repre_legal_capr' id="tel_repre_legal_capr" class='form-control' />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="email_repre_legal_capr">EMAIL:</label>
                        <input type='email' name='email_repre_legal_capr' class='form-control' id="email_repre_legal_capr" />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="dir_repre_legal_capr">DIRECCION REPRESENTANTE:</label>
                        <input type='text' name='dir_repre_legal_capr' class='form-control' id="dir_repre_legal_capr" style="text-transform:uppercase;" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="remuneracion_vta_capr">* REMUNER. VTA $</label>
                        <input type='number' value=0 name='remuneracion_vta_capr' id="remuneracion_vta_capr" class='form-control'  />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="remuneracion_renta_capr">* REMUNER. RENTA $</label>
                        <input type='number' value=0 name='remuneracion_renta_capr' id="remuneracion_renta_capr" class='form-control'  />
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
                <legend>OBSERVACIONES y/o COMENTARIOS ADICIONALES</legend>
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <textarea class="form-control" id="obs1_capr1" rows="3" name="obs1_capr1" style="text-transform:uppercase;" ></textarea>
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
</html>
