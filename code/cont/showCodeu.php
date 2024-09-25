<?php
    session_start();
    
    if(!isset($_SESSION['id_usu'])){
        header("Location: ../../index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $tipo_usu = $_SESSION['tipo_usu'];

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>VISION | SOFT</title>
        <script src="js/64d58efce2.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
        <link href="../../fontawesome/css/all.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm">
    
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

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"></script>

        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>

        <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-people-arrows"></i> CODEUDORES CONTRATO</b></h1>


   	<?php
        include("../../conexion.php");
        date_default_timezone_set("America/Bogota");
        $time = time();
	    $num_con  = $_GET['num_con'];
	    if(isset($_GET['num_con']))
	    { 
            $query = "SELECT * FROM contratos INNER JOIN contratos_codeudores ON contratos.num_con=contratos_codeudores.num_con INNER JOIN codeudor ON codeudor.nit_cc_cod=contratos_codeudores.nit_cc_cod WHERE contratos_codeudores.num_con = '$num_con'";
            $res = $mysqli->query($query);
            $num_registros = mysqli_num_rows($res);

            echo "<section class='content'>
            <div class='card-body'>
                <div class='table-responsive'>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>DOCUMENTO</th>
                                <th>NOMBRES Y APELLIDOS</th>
                                <th>TELEFONO</th>
                            </tr>
                        </thead>
                        <tbody>";

            $consulta = "SELECT * FROM contratos INNER JOIN contratos_codeudores ON contratos.num_con=contratos_codeudores.num_con INNER JOIN codeudor ON codeudor.nit_cc_cod=contratos_codeudores.nit_cc_cod WHERE contratos_codeudores.num_con = '$num_con'";
            $result = $mysqli->query($consulta);
            $i = 1;
            while($row = mysqli_fetch_array($result))
            {
                echo '
                        <tr>
                            <td data-label="No.">'.$i++.'</td>
                            <td data-label="DOCUMENTO">'.$row['nit_cc_cod'].'</td>
                            <td data-label="NOMBRES Y APELLIDOS">'.$row['nom_ape_cod'].'</td>
                            <td data-label="TELEFONO">'.$row['tel1_cod'].'</td>
                        </tr>';
            }
 
                echo '</table>
                        </div>
                ';
        }
    ?>
            <center>
            <br/><a href="showcont.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
            </center>
        </<section>
    </body>
</html>