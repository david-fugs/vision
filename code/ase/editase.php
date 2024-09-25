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
	    $nit_cc_ase  = $_GET['nit_cc_ase'];
	    if(isset($_GET['nit_cc_ase']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM asesores WHERE nit_cc_ase = '$nit_cc_ase'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fa-solid fa-people-roof"></i> ACTUALIZAR INFORMACIÓN DEL ASESOR</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='editase1.php' enctype="multipart/form-data" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="nit_cc_ase">* CC:</label>
                        <input type='text' name='nit_cc_ase' class='form-control' id="nit_cc_ase" value='<?php echo $row['nit_cc_ase']; ?>' readonly />
                    </div>
                    <div class="col-12 col-sm-7">
                        <label for="nom_ape_ase">* NOMBRES APELLIDOS:</label>
                        <input type='text' name='nom_ape_ase' id="nom_ape_ase" class='form-control' value='<?php echo $row['nom_ape_ase']; ?>' required style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="dir_ase">* DIRECCIÓN:</label>
                        <input type='text' name='dir_ase' class='form-control' value='<?php echo $row['dir_ase']; ?>' required style="text-transform:uppercase;" />
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="mun_ase">* MUNICIPIO:</label>
                        <select class="form-control" name="mun_ase" required >
                            <option value=""></option>   
                            <option value="PEREIRA" <?php if($row['mun_ase']=='PEREIRA'){echo 'selected';} ?>>PEREIRA</option>
                            <option value="DOSQUEBRADAS" <?php if($row['mun_ase']=='DOSQUEBRADAS'){echo 'selected';} ?>>DOSQUEBRADAS</option>
                            <option value="SANTA ROSA DE CABAL" <?php if($row['mun_ase']=='SANTA ROSA DE CABAL'){echo 'selected';} ?>>SANTA ROSA DE CABAL</option>
                            <option value="APIA" <?php if($row['mun_ase']=='APIA'){echo 'selected';} ?>>APIA</option>
                            <option value="BALBOA" <?php if($row['mun_ase']=='BALBOA'){echo 'selected';} ?>>BALBOA</option>
                            <option value="BELEN DE UMBRIA" <?php if($row['mun_ase']=='BELEN DE UMBRIA'){echo 'selected';} ?>>BELEN DE UMBRIA</option>
                            <option value="GUATICA" <?php if($row['mun_ase']=='GUATICA'){echo 'selected';} ?>>GUATICA</option>
                            <option value="LA CELIA" <?php if($row['mun_ase']=='LA CELIA'){echo 'selected';} ?>>LA CELIA</option>
                            <option value="LA VIRGINIA" <?php if($row['mun_ase']=='LA VIRGINIA'){echo 'selected';} ?>>LA VIRGINIA</option>
                            <option value="MARSELLA" <?php if($row['mun_ase']=='MARSELLA'){echo 'selected';} ?>>MARSELLA</option>
                            <option value="MISTRATO" <?php if($row['mun_ase']=='MISTRATO'){echo 'selected';} ?>>MISTRATO</option>
                            <option value="PUEBLO RICO" <?php if($row['mun_ase']=='PUEBLO RICO'){echo 'selected';} ?>>PUEBLO RICO</option>
                            <option value="QUINCHIA" <?php if($row['mun_ase']=='QUINCHIA'){echo 'selected';} ?>>QUINCHIA</option>
                            <option value="SANTUARIO" <?php if($row['mun_ase']=='SANTUARIO'){echo 'selected';} ?>>SANTUARIO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tel1_ase">CEL:</label>
                        <input type='text' name='tel1_ase' class='form-control' value='<?php echo $row['tel1_ase']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tel2_ase">TEL:</label>
                        <input type='text' name='tel2_ase' class='form-control' value='<?php echo $row['tel2_ase']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-5">
                        <label for="email_ase">EMAIL:</label>
                        <input type='text' name='email_ase' class='form-control' value='<?php echo $row['email_ase']; ?>' style="text-transform:lowercase;" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="fecha_nac_ase">F. NAC.</label>
                        <input type='date' name='fecha_nac_ase' class='form-control' value='<?php echo $row['fecha_nac_ase']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="fecha_vin_ase">F. VIN.</label>
                        <input type='date' name='fecha_vin_ase' class='form-control' value='<?php echo $row['fecha_vin_ase']; ?>' style="text-transform:lowercase;" />
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #24E924; border-radius: 5px;">

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="obs_ase">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="obs_ase" style="text-transform:uppercase;" /><?php echo $row['obs_ase']; ?></textarea>
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