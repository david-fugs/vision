<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../../index.php");
    exit();  // Asegúrate de salir del script después de redirigir
}

$id_usu     = $_SESSION['id_usu'];
$usuario    = $_SESSION['usuario'];
$nombre     = $_SESSION['nombre'];
$tipo_usu   = $_SESSION['tipo_usu'];

require_once('../../../conexion.php');

header("Content-Type: text/html;charset=utf-8");
$sql_asesores = "SELECT nit_cc_ase,nom_ape_ase FROM asesores ORDER BY nom_ape_ase";
$result = $mysqli->query($sql_asesores);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VISION | SOFT</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script>
        // Función para ordenar un select
        function ordenarSelect(id_componente) {
            var selectToSort = $('#' + id_componente);
            var optionActual = selectToSort.val();
            selectToSort.html(selectToSort.children('option').sort(function(a, b) {
                return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
            })).val(optionActual);
        }

        $(document).ready(function() {
            // Llamadas a la función de ordenar para distintos selects
            ordenarSelect('selectDigitador');
        });
    </script>
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        .selector-for-some-widget {
            box-sizing: content-box;
        }
    </style>
</head>

<body>

    <center>
        <h1><img src='../../../img/logo.png' width="80" height="56" class="responsive"><b><i class="fa-solid fa-print"></i> REPORTES - INFORMES EXHIBICIONES</b></h1>
    </center>
    <BR />

    <div class="container">
        <form method="POST" action="report1.php">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="de">FECHA INICIAL</label>
                        <i class="fas fa-hand-point-down"></i>
                        <input type='date' name='de' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="hasta">FECHA FINAL</label>
                        <i class="far fa-hand-point-down"></i>
                        <input type='date' name='hasta' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="tipo_inm_exh">* TIPO INMUEBLE:</label>
                        <i class="fas fa-hand-point-down"></i>
                        <select class="form-control" name="tipo_inm_exh" id="tipo_inm_exh" required>
                            <option value=""></option>
                            <option value="Residencial">Residencial</option>
                            <option value="Comercial">Comercial</option>
                        </select>
                        <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
                    </div>
                    <div class="col-12 col-sm-3">
                        <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger">
                <span class="spinner-border spinner-border-sm"></span> EXPORTAR INFORME POR TIPO DE INMUEBLE Y RANGO DE FECHAS
            </button>
        </form>
    </div>

    <br><br>
<?php
    if($tipo_usu == 1):
        ?>
    <div class="container">
        <form method="POST" action="report2.php">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="de">FECHA INICIAL</label>
                        <i class="fas fa-hand-point-down"></i>
                        <input type='date' name='de' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="hasta">FECHA FINAL</label>
                        <i class="far fa-hand-point-down"></i>
                        <input type='date' name='hasta' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="asesor">* ASESOR:</label>
                        <i class="fas fa-hand-point-down"></i>
                        <select class="form-control" name="asesor" id="asesor" required>
                            <option value=""></option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['nit_cc_ase'] . "'>" . $row['nom_ape_ase'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-dark">
                <span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS POR ASESOR
            </button>
        </form>
    </div>
    <?php
    endif;
    ?>

    <br><br>
<!--
    <div class="container">
        <form method="POST" action="report3.php">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="de">FECHA INICIAL</label>
                        <i class="fas fa-hand-point-down"></i>
                        <input type='date' name='de' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="hasta">FECHA FINAL</label>
                        <i class="far fa-hand-point-down"></i>
                        <input type='date' name='hasta' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary ">
                <span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS DE CAMPO POR FECHA
            </button>
        </form>
    </div>

    <br><br>

    <div class="container">
        <form method="POST" action="report4.php">
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="de">FECHA INICIAL</label>
                        <i class="fas fa-hand-point-down"></i>
                        <input type='date' name='de' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="hasta">FECHA FINAL</label>
                        <i class="far fa-hand-point-down"></i>
                        <input type='date' name='hasta' class='form-control' required />
                    </div>
                    <div class="col-12 col-sm-3">
                        <input type='hidden' name='id_usu' value='<?php echo $_SESSION['id_usu']; ?>' />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">
                <span class="spinner-border spinner-border-sm"></span> EXPORTAR ENCUESTAS CAMPO POR FECHA - GRUPO FAMILIAR
            </button>
        </form>
    </div> -->

    <center>
        <br /><a href="../../../access.php"><img src='../../../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

</body>

</html>
