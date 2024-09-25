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
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VISION | SOFT</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- Using Select2 from a CDN-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body >
   	<?php
        include("../../conexion.php");
	    $id_prop  = $_GET['id_prop'];
	    if(isset($_GET['id_prop']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM propiedades WHERE id_prop = '$id_prop'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fa-solid fa-address-card"></i> ACTUALIZAR INFORMACIÓN DE LAS PROPIEDADES Y PROPIETARIOS</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='editprop1.php' enctype="multipart/form-data" method="POST">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <input type='number' name='id_prop' class='form-control' id="id_prop" value='<?php echo $row['id_prop']; ?>' hidden />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <label for="mat_inm">* MATRICULA:</label>
                        <select name='mat_inm' class='form-control' required />
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta='SELECT * FROM inmuebles i INNER JOIN propiedades prop ON i.mat_inm=prop.mat_inm';
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row1 = $res->fetch_array())
                                    {
                                    ?>
                            <option value='<?php echo $row1['mat_inm']; ?>'<?php if($row['mat_inm']==$row1['mat_inm']){echo 'selected';} ?>>
                                <?php echo $row1['nom_inm']; ?>
                            </option>
                                    <?php
                                    }
                                    ?>    
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="nit_cc_pro">* PROPIETARIO:</label>
                        <select id='nit_cc_pro' name='nit_cc_pro' class='form-control' required />
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta='SELECT * FROM propietarios pro INNER JOIN propiedades prop ON pro.nit_cc_pro=prop.nit_cc_pro';
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row2 = $res->fetch_array())
                                    {
                                    ?>
                                        <option value='<?php echo $row2['nit_cc_pro']; ?>'<?php if($row['nit_cc_pro']==$row2['nit_cc_pro']){echo 'selected';} ?>>
                                            <?php echo $row2['nit_cc_pro'].' '.$row2['nom_ape_pro']; ?>
                                        </option>
                                    <?php
                                    }
                                ?>    
                        </select>
                    </div>
                </div>
            </div>
           
            <hr style="border: 4px solid #24E924; border-radius: 5px;">

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="obs_prop">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="obs_prop" style="text-transform:uppercase;" /><?php echo $row['obs_prop']; ?></textarea>
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #24E924; border-radius: 5px;">
            
            <button type="submit" class="btn btn-outline-warning" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                ACTUALIZAR INFORMACIÓN 
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
</html>