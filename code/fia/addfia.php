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
        <script src="https://stackpath.amazonaws.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
        <style>
            .responsive {
                max-width: 100%;
                height: auto;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#con_fia').on('blur', function() {
                    $('#result-con_fia').html('<img src="../../img/loader.gif" />').fadeOut(1000);
                    var con_fia = $(this).val();   
                    var dataString = 'con_fia=' + con_fia;

                    $.ajax({
                        type: "POST",
                        url: "chkfia.php",
                        data: dataString,
                        success: function(data) {
                            $('#result-con_fia').fadeIn(1000).html(data);
                        }
                    });
                });

                $('#nom_concepto_fia').prop('disabled', true); // Deshabilitar campo inicialmente
                
                $('#otro_concepto_fia').on('input', function() {
                    if ($(this).val() > 0) {
                        $('#nom_concepto_fia').prop('disabled', false); // Habilitar campo si el valor es mayor que 0
                    } else {
                        $('#nom_concepto_fia').prop('disabled', true); // Mantener campo deshabilitado si el valor es 0 o menor
                    }
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
            <h1><b><i class="fa-solid fa-money-bill-transfer"></i> REGISTRO CONTRATO DE FIANZA</b></h1>
            <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

            <form action='addfia1.php' enctype="multipart/form-data" method="POST" id="addarr1_form">
                <div class="row">
                    <div class="col">
                        <div id="result-con_fia"></div>
                    </div>  
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="con_fia">* FIANZA No.</label>
                            <input type='number' name='con_fia' class='form-control' id="con_fia" autofocus required />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="fec_fia">* FECHA:</label>
                            <input type='date' name='fec_fia' id="fec_fia" class='form-control' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="can_arr_fia">* CANON $</label>
                            <input type='number' value=0 name='can_arr_fia' id="can_arr_fia" class='form-control' required/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="cuo_adm_fia">* ADMINISTRACION $</label>
                            <input type='number' value=0 name='cuo_adm_fia' id="cuo_adm_fia" class='form-control' required/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="iva_arr_fia">* IVA $</label>
                            <input type='number' value=0 name='iva_arr_fia' id="iva_arr_fia" class='form-control' required/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="otro_concepto_fia">* OTROS $</label>
                            <input type='number' value=0 name='otro_concepto_fia' id="otro_concepto_fia" class='form-control' required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="nom_concepto_fia">OTRO CONCEPTO:</label>
                            <input type='text' name='nom_concepto_fia' id="nom_concepto_fia" class='form-control' style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-5">
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
                                        <?php echo utf8_encode($row['nom_ape_arr']. ' - '.$row['nit_cc_arr']); ?>
                                </option>
                                        <?php
                                        }
                                        ?>    
                            </select>
                        </div>
                        <div class="col-12 col-sm-5">
                            <label for="mat_inm">* INMUEBLE:</label>
                            <select name='mat_inm' class='form-control' required id="mat_inm"/>
                                <option value=''></option>
                                    <?php
                                        header('Content-Type: text/html;charset=utf-8');
                                        $consulta='SELECT * FROM inmuebles';
                                        $res = mysqli_query($mysqli,$consulta);
                                        $num_reg = mysqli_num_rows($res);
                                        while($row = $res->fetch_array())
                                        {
                                        ?>
                                <option value='<?php echo $row['mat_inm']; ?>'>
                                        <?php echo utf8_encode($row['nom_inm']. ' - '.$row['mat_inm']); ?>
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
                            <label for="obs_fia">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs_fia" style="text-transform:uppercase;"></textarea>
                        </div>
                    </div>
                </div>

                <hr style="border: 4px solid #24E924; border-radius: 5px;">
          
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
</html>
