<?php
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");
include("functions.php");

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
    $sql_pago = "SELECT * FROM pagos WHERE id_pago = " . $_GET['id_pago'];
    $res_pago = $mysqli->query($sql_pago);
    $pago = $res_pago->fetch_assoc();

    print_r($pago);
    ?>

    <div class="container">
        <h1><b><i class="fa-solid fa-file-signature"></i> PRORRATEO</b></h1>



        <form action='processProrrateo.php' enctype="multipart/form-data" method="POST" id="prorrateo_form">
            <div class="row">
                <div class="col">
                    <div id="result-num_con"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="num_con">* CONTRATO No.</label>
                        <input value="<?= $pago['num_con'] ?>" type='number' name='num_con' class='form-control' id="num_con" readonly />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="fec_con">* CANON </label>
                        <input value="<?= $pago['canon_con'] ?>" type='number' name='fec_con' id="fec_con" class='form-control' readonly />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="fec_con">* FECHA PAGO</label>
                        <input value="<?= $pago['fecha_pago'] ?>" type='date' name='fec_con' id="fec_con" class='form-control' readonly />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-4">
                        <label for="prorrateo_fecha">* FECHA A LA CUAL MODIFICAR PAGO:</label>
                        <input type='date' name='prorrateo_fecha' id="prorrateo_fecha" class='form-control' required />

                    </div>
                </div>
            </div>
            <input type="hidden" name="id_pago" value="<?= $pago['id_pago'] ?>">
            <input type="hidden" name="num_con" value="<?= $pago['num_con'] ?>">
            <div class="form-group mt-4" >
                <div class="row">
                    <div class="col-12 col">
                        <button type="submit" class="btn btn-primary">Registrar Pago Arrendamiento</button>
                        <a href="showpay1.php?num_con=<?= $pago['num_con'] ?>" class="btn btn-outline-dark">Regresar</a>
                    </div>
                </div>
        </form>