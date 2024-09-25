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
	    $mat_inm  = $_GET['mat_inm'];
	    if(isset($_GET['mat_inm']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM inmuebles WHERE mat_inm = '$mat_inm'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fa-solid fa-city"></i> ACTUALIZAR INFORMACIÓN DEL INMUEBLE</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='editinm1.php' enctype="multipart/form-data" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="mat_inm">* No. MATRÍCULA</label>
                        <input type='text' name='mat_inm' class='form-control' id="mat_inm" value='<?php echo $row['mat_inm']; ?>' readonly />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="nom_inm">* INMUEBLE:</label>
                        <input type='text' name='nom_inm' id="nom_inm" class='form-control' value='<?php echo $row['nom_inm']; ?>' required style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="mun_inm">* MUNICIPIO:</label>
                        <select class="form-control" name="mun_inm" required >
                            <option value=""></option>   
                            <option value="PEREIRA" <?php if($row['mun_inm']=='PEREIRA'){echo 'selected';} ?>>PEREIRA</option>
                            <option value="DOSQUEBRADAS" <?php if($row['mun_inm']=='DOSQUEBRADAS'){echo 'selected';} ?>>DOSQUEBRADAS</option>
                            <option value="SANTA ROSA DE CABAL" <?php if($row['mun_inm']=='SANTA ROSA DE CABAL'){echo 'selected';} ?>>SANTA ROSA DE CABAL</option>
                            <option value="APIA" <?php if($row['mun_inm']=='APIA'){echo 'selected';} ?>>APIA</option>
                            <option value="BALBOA" <?php if($row['mun_inm']=='BALBOA'){echo 'selected';} ?>>BALBOA</option>
                            <option value="BELEN DE UMBRIA" <?php if($row['mun_inm']=='BELEN DE UMBRIA'){echo 'selected';} ?>>BELEN DE UMBRIA</option>
                            <option value="GUATICA" <?php if($row['mun_inm']=='GUATICA'){echo 'selected';} ?>>GUATICA</option>
                            <option value="LA CELIA" <?php if($row['mun_inm']=='LA CELIA'){echo 'selected';} ?>>LA CELIA</option>
                            <option value="LA VIRGINIA" <?php if($row['mun_inm']=='LA VIRGINIA'){echo 'selected';} ?>>LA VIRGINIA</option>
                            <option value="MARSELLA" <?php if($row['mun_inm']=='MARSELLA'){echo 'selected';} ?>>MARSELLA</option>
                            <option value="MISTRATO" <?php if($row['mun_inm']=='MISTRATO'){echo 'selected';} ?>>MISTRATO</option>
                            <option value="PUEBLO RICO" <?php if($row['mun_inm']=='PUEBLO RICO'){echo 'selected';} ?>>PUEBLO RICO</option>
                            <option value="QUINCHIA" <?php if($row['mun_inm']=='QUINCHIA'){echo 'selected';} ?>>QUINCHIA</option>
                            <option value="SANTUARIO" <?php if($row['mun_inm']=='SANTUARIO'){echo 'selected';} ?>>SANTUARIO</option>
                        </select>
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-7">
                        <label for="dir_inm">* DIRECCIÓN:</label>
                        <input type='text' name='dir_inm' class='form-control' value='<?php echo $row['dir_inm']; ?>' required style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tel_inm">TEL:</label>
                        <input type='text' name='tel_inm' class='form-control' value='<?php echo $row['tel_inm']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-1">
                        <label for="est_inm">EST:</label>
                        <select class="form-control" name="est_inm"/>
                            <option value=""></option>   
                            <option value=1 <?php if($row['est_inm']==1){echo 'selected';} ?>>1</option>
                            <option value=2 <?php if($row['est_inm']==2){echo 'selected';} ?>>2</option>
                            <option value=3 <?php if($row['est_inm']==3){echo 'selected';} ?>>3</option>
                            <option value=4 <?php if($row['est_inm']==4){echo 'selected';} ?>>4</option>
                            <option value=5 <?php if($row['est_inm']==5){echo 'selected';} ?>>5</option>
                            <option value=6 <?php if($row['est_inm']==6){echo 'selected';} ?>>6</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="zona_inm">ZONA:</label>
                        <select class="form-control" name="zona_inm"/>
                            <option value=""></option>   
                            <option value="URBANA" <?php if($row['zona_inm']=='URBANA'){echo 'selected';} ?>>URBANA</option>
                            <option value="RURAL" <?php if($row['zona_inm']=='RURAL'){echo 'selected';} ?>>RURAL</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #24E924; border-radius: 5px;">

            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="obs_inm">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="obs_inm" style="text-transform:uppercase;" /><?php echo $row['obs_inm']; ?></textarea>
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #24E924; border-radius: 5px;">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="archivo"><strong><i class="fas fa-file-pdf"></i> ADJUNTAR DOCUMENTOS DEL INMUEBLE</strong></label>
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="application/pdf">
                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;"><b><u>Solamente adicione documentos siempre y cuando este paso no se haya realizado anteriormente. </b></u>Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
                    </div>
                </div>
            </div>

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