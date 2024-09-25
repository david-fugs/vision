<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VISION | SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <center>
        <img src='../../img/logo.png' width="300" height="212" class="responsive">
    </center>
    <br />

    <div class="container">
        <h1><b><i class="fa-solid fa-user-group"></i> REGISTRO DE ARRENDATARIOS</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>

        <form id="registroForm" action='addarr1.php' enctype="multipart/form-data" method="POST">
         
                <div class="row">
                    <div class="col">
                        <div id="result-nit_cc_arr"></div>
                    </div>  
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="nit_cc_arr">* CC:</label>
                            <input type='number' name='nit_cc_arr' class='form-control' id="nit_cc_arr" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="nom_ape_arr">* NOMBRES APELLIDOS y/o RAZÓN SOCIAL:</label>
                            <input type='text' name='nom_ape_arr' id="nom_ape_arr" class='form-control' required style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="dir_arr">* DIRECCIÓN:</label>
                            <input type='text' name='dir_arr' id="dir_arr" class='form-control' style="text-transform:uppercase;" required/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <label for="mun_arr">* MUNICIPIO:</label>
                            <select class="form-control" name="mun_arr" required>
                                <option value=""></option>   
                                <option value="PEREIRA">PEREIRA</option>
                                <option value="DOSQUEBRADAS">DOSQUEBRADAS</option>
                                <option value="SANTA ROSA DE CABAL">SANTA ROSA DE CABAL</option>
                                <option value="APIA">APIA</option>
                                <option value="BALBOA">BALBOA</option>
                                <option value="BELEN DE UMBRIA">BELEN DE UMBRIA</option>
                                <option value="GUATICA">GUATICA</option>
                                <option value="LA CELIA">LA CELIA</option>
                                <option value="LA VIRGINIA">LA VIRGINIA</option>
                                <option value="MARSELLA">MARSELLA</option>
                                <option value="MISTRATO">MISTRATO</option>
                                <option value="PUEBLO RICO">PUEBLO RICO</option>
                                <option value="QUINCHIA">QUINCHIA</option>
                                <option value="SANTUARIO">SANTUARIO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tel1_arr">* CEL:</label>
                            <input type='text' name='tel1_arr' class='form-control' style="text-transform:uppercase;" required/>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="tel2_arr">TEL:</label>
                            <input type='text' name='tel2_arr' class='form-control' style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-5">
                            <label for="email_arr">EMAIL:</label>
                            <input type='email' name='email_arr' class='form-control' style="text-transform:lowercase;" />
                        </div>
                    </div>
                </div>
                
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="tipo_reg_iva_arr">* TIPO REGIMEN:</label>
                        <select class="form-control" name="tipo_reg_iva_arr" id="tipo_reg_iva_arr" required>
                            <option value=""></option>   
                            <option value="1">No responsable de IVA</option>
                            <option value="2">Responsable de IVA</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">No responsable de IVA:</label>
                        <input type="hidden" name="no_responsable_iva_arr" value="0">
                        <input type="checkbox" name="no_responsable_iva_arr" value="1" disabled>
                        <br>
                        <label class="containerCheck">Régimen simple de tributación - SIM:</label>
                        <input type="hidden" name="reg_simple_trib_arr" value="0">
                        <input type="checkbox" name="reg_simple_trib_arr" value="1" disabled>
                        <br>
                        <label class="containerCheck">Impto. sobre las ventas - IVA:</label>
                        <input type="hidden" name="impto_ventas_iva_arr" value="0">
                        <input type="checkbox" name="impto_ventas_iva_arr" value="1" disabled>
                        <br>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label class="containerCheck">Retención en la fuente a título de renta:</label>
                        <input type="hidden" name="rete_fte_arr" value="0">
                        <input type="checkbox" name="rete_fte_arr" value="1" disabled>
                        <br>
                        <label class="containerCheck">Retención en la fuente en el impuesto:</label>
                        <input type="hidden" name="rete_iva_arr" value="0">
                        <input type="checkbox" name="rete_iva_arr" value="1" disabled>
                        <br>
                        <label class="containerCheck">Retención de Industria y Comercio:</label>
                        <input type="hidden" name="rete_ica_arr" value="0">
                        <input type="checkbox" name="rete_ica_arr" value="1" disabled>
                        <br>
                    </div>
                </div>
            </div>

            <!-- Botones para enviar o resetear -->
            <button type="submit" class="btn btn-outline-warning">
                <span class="spinner-border spinner-border-sm"></span>
                INGRESAR REGISTRO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'>
                <img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>

    <!-- Script para manejar el envío del formulario -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Inicializamos el comportamiento del formulario
            $('#registroForm').on('submit', function() {
                // Aseguramos que los checkboxes deshabilitados seleccionados sean enviados con valor 1
                $('input[type=checkbox]:disabled').each(function() {
                    if (this.checked) {
                        $(this).prop('disabled', false);
                    }
                });

                // Verificamos todos los checkboxes y establecemos su valor a 0 si no están seleccionados
                $('input[type=checkbox]').each(function() {
                    if (!this.checked) {
                        $(this).after('<input type="hidden" name="' + this.name + '" value="0">');
                    }
                });
            });

            // Maneja la lógica de los checkboxes según el valor del select
            $('#tipo_reg_iva_arr').change(function() {
                var tipoRegimen = $(this).val();

                // Reiniciamos los checkboxes a su estado inicial
                $('input[type=checkbox]').prop('checked', false).prop('disabled', true);

                if (tipoRegimen == "1") {
                    $('input[name="no_responsable_iva_arr"]').prop('checked', true).prop('disabled', true);
                } else if (tipoRegimen == "2") {
                    $('input[name="impto_ventas_iva_arr"]').prop('checked', true).prop('disabled', true);
                    $('input[name="reg_simple_trib_arr"]').prop('disabled', false);
                    $('input[name="rete_fte_arr"]').prop('disabled', false);
                    $('input[name="rete_iva_arr"]').prop('disabled', false);
                    $('input[name="rete_ica_arr"]').prop('disabled', false);
                }
            });

            // Activamos la lógica de habilitación de checkboxes al cargar la página
            $('#tipo_reg_iva_arr').trigger('change');
        });
    </script>
</body>
</html>