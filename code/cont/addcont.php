<?php
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }

    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];
    header("Content-Type: text/html;charset=utf-8");
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
        <style>
            .responsive {
                max-width: 100%;
                height: auto;
            }
            .error-message {
                color: red;
                display: none;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#num_con').on('blur', function() {
                    $('#result-num_con').html('<img src="../../img/loader.gif" />').fadeOut(1000);
                    var num_con = $(this).val();   
                    var dataString = 'num_con=' + num_con;

                    $.ajax({
                        type: "POST",
                        url: "chkcont.php",
                        data: dataString,
                        success: function(data) {
                            $('#result-num_con').fadeIn(1000).html(data);
                        }
                    });
                });

                $('#nit_cc_arr').on('change', function() {
                    var nit_cc_arr = $(this).val();
                    if (nit_cc_arr) {
                        $.ajax({
                            type: 'POST',
                            url: 'fetch_codeudores.php',
                            data: {nit_cc_arr: nit_cc_arr},
                            success: function(data) {
                                var codeudores = JSON.parse(data);
                                $('#nit_cc_cod').empty();
                                codeudores.forEach(function(codeudor) {
                                    $('#nit_cc_cod').append('<option value="' + codeudor.nit_cc_cod + '">' + codeudor.nom_ape_cod + ' (' + codeudor.nit_cc_cod + ')</option>');
                                });
                            }
                        });
                    } else {
                        $('#nit_cc_cod').empty();
                    }
                });

                $('#add_codeudor_btn').on('click', function() {
                    var nit_cc_cod = $('#nit_cc_cod').val();
                    var nom_ape_cod = $('#nit_cc_cod option:selected').text();

                    if (nit_cc_cod && nom_ape_cod) {
                        $('#codeudores_list').append('<div class="codeudor-item" data-nit_cc_cod="' + nit_cc_cod + '"><p>' + nom_ape_cod + ' <button type="button" class="btn btn-danger btn-sm remove-codeudor">Eliminar</button></p></div>');
                        $('#nit_cc_cod option:selected').remove(); // Remove the added codeudor from the select
                    }
                });

                $(document).on('click', '.remove-codeudor', function() {
                    var nit_cc_cod = $(this).closest('.codeudor-item').data('nit_cc_cod');
                    var nom_ape_cod = $(this).closest('.codeudor-item').text().replace(' Eliminar', '');
                    $('#nit_cc_cod').append('<option value="' + nit_cc_cod + '">' + nom_ape_cod + '</option>');
                    $(this).closest('.codeudor-item').remove(); // Remove the codeudor from the list
                });

                $('#addarr1_form').on('submit', function() {
                    $('.codeudor-item').each(function() {
                        var nit_cc_cod = $(this).data('nit_cc_cod');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'codeudores[]',
                            value: nit_cc_cod
                        }).appendTo('#addarr1_form');
                    });
                });

                function updateRentaCon() {
                    var canon = parseFloat($('#canon_con').val()) || 0;
                    var iva = parseFloat($('#iva_con').val()) || 0;
                    var admon = parseFloat($('#admon_con').val()) || 0;
                    var renta = canon + iva + admon;
                    $('#renta_con').val(renta.toFixed(2));
                }

                $('#canon_con, #iva_con, #admon_con').on('input', updateRentaCon);

                function validateDates() {
                    var fec_con = new Date($('#fec_con').val());
                    var fec_inicio_con = new Date($('#fec_inicio_con').val());

                    if (fec_inicio_con < fec_con) {
                        $('#date-error').show();
                        $('#submit_btn').prop('disabled', true);
                    } else {
                        $('#date-error').hide();
                        $('#submit_btn').prop('disabled', false);
                    }
                }

                $('#fec_con, #fec_inicio_con').on('change', validateDates);
            });
            $(document).ready(function() {
            $('#mat_inm').on('change', function() {
                    var mat_inm = $(this).val();
                    
                    if (mat_inm) {
                        $.ajax({
                            type: 'POST',
                            url: 'fetch_propietario.php',
                            data: {mat_inm: mat_inm},
                            success: function(data) {
                                var propietarios = JSON.parse(data);
                                $('#nit_cc_pro').prop('readonly', false); // Habilitar temporalmente el select de propietarios
                                $('#nit_cc_pro').empty(); // Limpiar el select de propietarios

                                if (propietarios.length > 0) {
                                    propietarios.forEach(function(propietario) {
                                        $('#nit_cc_pro').append('<option value="' + propietario.nit_cc_pro + '">' + propietario.nom_ape_pro + '</option>');
                                    });

                                    // Seleccionar automáticamente el primer propietario
                                    $('#nit_cc_pro').val(propietarios[0].nit_cc_pro);
                                    $('#nit_cc_pro_hidden').val(propietarios[0].nit_cc_pro); // Actualizar el campo oculto
                                } else {
                                    $('#nit_cc_pro').append('<option value="">No hay propietarios disponibles</option>');
                                    $('#nit_cc_pro_hidden').val('');
                                }

                                $('#nit_cc_pro').prop('readonly', true); // Deshabilitar nuevamente el select después de actualizar
                            }
                        });
                    } else {
                        $('#nit_cc_pro').empty(); // Limpiar el select de propietarios si no hay matrícula seleccionada
                        $('#nit_cc_pro_hidden').val('');
                        $('#nit_cc_pro').prop('readonly', true); // Asegurarse de que el select permanezca deshabilitado
                    }
                });

                // Mantener actualizado el campo oculto cuando se cambia el select
                $('#nit_cc_pro').on('change', function() {
                    $('#nit_cc_pro_hidden').val($(this).val());
                });
            });
        </script>
    </head>
    <body>
  
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <br />
<?php

    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");
    require_once("../../zebra.php");

?>

        <div class="container">
            <h1><b><i class="fa-solid fa-file-signature"></i> CONTRATO DE ARRENDAMIENTO</b></h1>
            <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

            <form action='addcont1.php' enctype="multipart/form-data" method="POST" id="addarr1_form">
                <div class="row">
                    <div class="col">
                        <div id="result-num_con"></div>
                    </div>  
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="num_con">* CONTRATO No.</label>
                            <input type='number' name='num_con' class='form-control' id="num_con" autofocus required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fec_con">* FECHA CONT.</label>
                            <input type='date' name='fec_con' id="fec_con" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-8">
                            <label for="mat_inm">* INMUEBLE - DIRECCIÓN - MATRICULA No.</label>
                            <select name='mat_inm' class='form-control' required id="mat_inm"/>
                                <option value=''></option>
                                    <?php
                                        header('Content-Type: text/html;charset=utf-8');
                                        $consulta='SELECT * FROM propiedades INNER JOIN inmuebles ON propiedades.mat_inm=inmuebles.mat_inm';
                                        $res = mysqli_query($mysqli,$consulta);
                                        $num_reg = mysqli_num_rows($res);
                                        while($row = $res->fetch_array())
                                        {
                                        ?>
                                <option value='<?php echo $row['mat_inm']; ?>'>
                                    <?php echo mb_convert_encoding($row['nom_inm']. ' - '.$row['dir_inm']. ' - '.$row['mat_inm'], 'UTF-8', 'ISO-8859-1'); ?>
                                </option>
                                        <?php
                                        }
                                        ?>    
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="nit_cc_pro">* PROPIETARIOS:</label>
                            <select name='nit_cc_pro' class='form-control' required id="nit_cc_pro" readonly>
                                <option value=''></option>
                                    <?php
                                        header('Content-Type: text/html;charset=utf-8');
                                        $consulta='SELECT * FROM propiedades INNER JOIN propietarios ON propiedades.nit_cc_pro=propietarios.nit_cc_pro';
                                        $res = mysqli_query($mysqli,$consulta);
                                        $num_reg = mysqli_num_rows($res);
                                        while($row = $res->fetch_array())
                                        {
                                        ?>
                                <option value='<?php echo $row['nit_cc_pro']; ?>'>
                                        <?php echo mb_convert_encoding($row['nom_ape_pro']. ' - '.$row['nit_cc_pro'], 'UTF-8', 'ISO-8859-1'); ?>
                                </option>
                                        <?php
                                        }
                                        ?>    
                            </select>
                            <input type="hidden" name="nit_cc_pro_hidden" id="nit_cc_pro_hidden">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="arrendador_con">* ARRENDADOR:</label>
                            <select class="form-control" name="arrendador_con" id="arrendador_con" required>
                                <option value=""></option>   
                                <option value="1">TERESA RAMIREZ SANCHEZ</option>
                                <option value="2">CAROLINA MOLINA MARIN</option>
                                <option value="3">RICARDO ABELLA RAMIREZ</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="iva_arrendador_con">IVA</label>
                            <input type='number' name='iva_arrendador_con' id="iva_arrendador_con" class='form-control' readonly required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-8">
                            <label for="nit_cc_arr">* ARRENDATARIO:</label>
                            <select name='nit_cc_arr' class='form-control' required id="nit_cc_arr"/>
                                <option value=''></option>
                                    <?php
                                        header('Content-Type: text/html;charset=utf-8');
                                        $consulta='SELECT * FROM arrendatarios';
                                        $res = mysqli_query($mysqli,$consulta);
                                        $num_reg = mysqli_num_rows($res);
                                        while($row = $res->fetch_array())
                                        {
                                        ?>
                                <option value='<?php echo $row['nit_cc_arr']; ?>'>
                                        <?php echo mb_convert_encoding($row['nom_ape_arr']. ' - '.$row['nit_cc_arr'], 'UTF-8', 'ISO-8859-1'); ?>
                                </option>
                                        <?php
                                        }
                                        ?>    
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="fec_inicio_con">* FECHA INICIO:</label></strong>
                            <input type='date' name='fec_inicio_con' id="fec_inicio_con" class='form-control' />
                            <div id="date-error" class="error-message">La fecha de inicio no puede ser anterior a la fecha del contrato.</div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <strong><label for="vigencia_duracion_con">* VIGENCIA (meses):</label></strong>
                            <input type='number' value=0 name='vigencia_duracion_con' id="vigencia_duracion_con" class='form-control' required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                    <div class="col-12 col-sm-2">
                            <label for="serv_agua_con">MATRIC. AGUA:</label>
                            <input type='number' value=0 name='serv_agua_con' id="serv_agua_con" class='form-control'/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="serv_ener_con">MATRIC. ENERGIA:</label>
                            <input type='number' value=0 name='serv_ener_con' id="serv_ener_con" class='form-control'/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="serv_gas_con">MATRIC. GAS:</label>
                            <input type='number' value=0 name='serv_gas_con' id="serv_gas_con" class='form-control' />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <strong><label for="canon_con">* CANON $</label></strong>
                            <input type='number' value=0 name='canon_con' id="canon_con" class='form-control' required/>
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="iva_con">* IVA $</label></strong>
                            <input type='number' value=0 name='iva_con' id="iva_con" class='form-control' required/>
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="admon_con">* ADMINISTRACION $</label></strong>
                            <input type='number' value=0 name='admon_con' id="admon_con" class='form-control' required/>
                        </div>
                        <div class="col-12 col-sm-3">
                            <strong><label for="renta_con">* RENTA $</label></strong>
                            <input type='number' value=0 name='renta_con' id="renta_con" class='form-control' readonly required/>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <h5>Codeudores</h5>
                            <div id="codeudores_list"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-8">
                            <label for="nit_cc_cod">NIT/CC CODEUDOR:</label>
                            <select name="nit_cc_cod" id="nit_cc_cod" class="form-control"></select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-primary form-control" id="add_codeudor_btn">Agregar Codeudor</button>
                        </div>
                    </div>
                </div>
                    
                <hr style="border: 4px solid #24E924; border-radius: 5px;">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label for="obs_con">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_con" style="text-transform:uppercase;"></textarea>
                        </div>
                    </div>
                </div>

                <hr style="border: 4px solid #24E924; border-radius: 5px;">
          
                <button type="submit" class="btn btn-outline-warning" id="submit_btn">
                    <span class="spinner-border spinner-border-sm"></span>
                    INGRESAR REGISTRO
                </button>
                <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
                </button>
            </form>
        </div>
    </body>
    <script src = "../../js/jquery-3.1.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Función para actualizar el valor del IVA basado en el arrendador seleccionado
            function updateIvaArrendador() {
                var arrendador = $('#arrendador_con').val(); // Obtener el valor seleccionado como cadena
                if (arrendador === '1') { // Comparar correctamente como cadena
                    $('#iva_arrendador_con').val(19.0); // Asigna 19 al IVA
                } else {
                    $('#iva_arrendador_con').val(0); // Asigna 0 al IVA en cualquier otro caso
                }
                $('#iva_arrendador_con').prop('readonly', true); // Bloquear el campo para evitar edición manual
            }

            // Llama a la función al cargar la página
            updateIvaArrendador();

            // Actualiza el valor del IVA cada vez que cambia el arrendador
            $('#arrendador_con').on('change', function() {
                updateIvaArrendador();
            });

            // Funciones existentes...
            $('#num_con').on('blur', function() {
                $('#result-num_con').html('<img src="../../img/loader.gif" />').fadeOut(1000);
                var num_con = $(this).val();
                var dataString = 'num_con=' + num_con;

                $.ajax({
                    type: "POST",
                    url: "chkcont.php",
                    data: dataString,
                    success: function(data) {
                        $('#result-num_con').fadeIn(1000).html(data);
                    }
                });
            });

            // Más funciones existentes...
        });
    </script>


</html>
