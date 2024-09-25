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
	    $id_exh  = $_GET['id_exh'];
	    if(isset($_GET['id_exh']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM exhibiciones WHERE id_exh = '$id_exh'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../../img/logo.png' width="300" height="212" class="responsive">
        </center>
        <BR/>
        <h1><b><i class="fa-solid fa-store"></i> ACTUALIZAR INFORMACIÓN DE LA VISITA REALIZADA (EXHIBICION)</b></h1>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='editexh1.php' enctype="multipart/form-data" method="POST">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-1">
                        <label for="id_exh">ID</label>
                        <input type='text' name='id_exh' class='form-control' id="id_exh" value='<?php echo $row['id_exh']; ?>' readonly />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="cod_fr_exh">* COD F.R.</label>
                        <input type='number' name='cod_fr_exh' class='form-control' id="cod_fr_exh" value='<?php echo $row['cod_fr_exh']; ?>'/>
                    </div>
                    <div class="col-12 col-sm-7">
                        <label for="direccion_inm_exh">* DIRECCIÓN INMUEBLE:</label>
                        <input type='text' name='direccion_inm_exh' id="direccion_inm_exh" class='form-control' value='<?php echo $row['direccion_inm_exh']; ?>' required style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="fec_exh">FECHA:</label>
                        <input type='text' name='fec_exh' id="fec_exh" class='form-control' value="<?php echo $row['fec_exh']; ?>" readonly />
                    </div>
                </div>
            </div>
           
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-2">
                        <label for="visita_exh">* ¿CUMPLE CITA?</label>
                        <select class="form-control" name="visita_exh" required autofocus>
                            <option value=""></option>   
                            <option value=1 <?php if($row['visita_exh']==1){echo 'selected';} ?>>SI</option>
                            <option value=0 <?php if($row['visita_exh']==0){echo 'selected';} ?>>NO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="nom_vis_exh">* MOTIVO:</label>
                        <select class="form-control" name="nom_vis_exh" required autofocus>
                            <option value=""></option>   
                            <option value="N/A" <?php if($row['nom_vis_exh']=="N/A"){echo 'selected';} ?>>N/A</option>
                            <option value="FALTA DE TIEMPO" <?php if($row['nom_vis_exh']=="FALTA DE TIEMPO"){echo 'selected';} ?>>FALTA DE TIEMPO</option>
                            <option value="CAMBIO DE DECISION" <?php if($row['nom_vis_exh']=="CAMBIO DE DECISION"){echo 'selected';} ?>>CAMBIO DE DECISION</option>
                            <option value="REPROGRAMAR CITA" <?php if($row['nom_vis_exh']=="REPROGRAMAR CITA"){echo 'selected';} ?>>REPROGRAMAR CITA</option>
                            <option value="NO RESPONDE" <?php if($row['nom_vis_exh']=="NO RESPONDE"){echo 'selected';} ?>>NO RESPONDE</option>
                            <option value="OTRO" <?php if($row['nom_vis_exh']=="OTRO"){echo 'selected';} ?>>OTRO</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="nom_ape_inte_exh">* NOMBRE Y APELLIDOS INTERESAD@:</label>
                        <input type='text' name='nom_ape_inte_exh' id="nom_ape_inte_exh" class='form-control' value='<?php echo $row['nom_ape_inte_exh']; ?>' required style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-3">
                        <label for="raz_soc_exh">* RAZON SOCIAL:</label>
                        <input type='text' name='raz_soc_exh' id="raz_soc_exh" class='form-control' value='<?php echo $row['raz_soc_exh']; ?>' required style="text-transform:uppercase;" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="nit_cc_exh">* NIT y/o CC No:</label>
                        <input type='nunmber' name='nit_cc_exh' class='form-control' value='<?php echo $row['nit_cc_exh']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="cel_inte_exh">CEL:</label>
                        <input type='text' name='cel_inte_exh' class='form-control' value='<?php echo $row['cel_inte_exh']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-2">
                        <label for="tel_inte_exh">TEL:</label>
                        <input type='text' name='tel_inte_exh' class='form-control' value='<?php echo $row['tel_inte_exh']; ?>' style="text-transform:uppercase;" />
                    </div>
                    <div class="col-12 col-sm-5">
                        <label for="email_inte_exh">EMAIL:</label>
                        <input type='text' name='email_inte_exh' class='form-control' value='<?php echo $row['email_inte_exh']; ?>' style="text-transform:lowercase;" />
                    </div>
                </div>
            </div>

            <hr style="border: 4px solid #24E924; border-radius: 5px;">
                <p><i><b><font size=3 color=#c68615>Valora de 1 a 10 las características del inmueble visitado:</i></b></font></p>        
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="valor_ubicacion_exh">UBICACION:</label>
                            <input type='number' min=0 max=10 name='valor_ubicacion_exh' class='form-control' value='<?php echo $row['valor_ubicacion_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_fachada_exh">FACHADAS:</label>
                            <input type='number' min=0 max=10 name='valor_fachada_exh' class='form-control' value='<?php echo $row['valor_fachada_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_area_exterior_exh">AREA EXTERIOR:</label>
                            <input type='number' min=0 max=10 name='valor_area_exterior_exh' class='form-control' value='<?php echo $row['valor_area_exterior_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_iluminacion_exh">ILUMINACION:</label>
                            <input type='number' min=0 max=10 name='valor_iluminacion_exh' class='form-control' value='<?php echo $row['valor_iluminacion_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_altura_exh">ALTURA:</label>
                            <input type='number' min=0 max=10 name='valor_altura_exh' class='form-control' value='<?php echo $row['valor_altura_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_pisos_exh">PISOS:</label>
                            <input type='number' min=0 max=10 name='valor_pisos_exh' class='form-control' value='<?php echo $row['valor_pisos_exh']; ?>' />
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label for="valor_paredes_exh">PAREDES:</label>
                            <input type='number' min=0 max=10 name='valor_paredes_exh' class='form-control' value='<?php echo $row['valor_paredes_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_carpinteria_exh">CARPINTERIA:</label>
                            <input type='number' min=0 max=10 name='valor_carpinteria_exh' class='form-control' value='<?php echo $row['valor_carpinteria_exh']; ?>' />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="valor_banhos_exh">BAÑOS:</label>
                            <input type='number' min=0 max=10 name='valor_banhos_exh' class='form-control' value='<?php echo $row['valor_banhos_exh']; ?>' />
                        </div>
                    </div>
                </div>
                
                <hr style="border: 4px solid #24E924; border-radius: 5px;">
          
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="obs1_exh">¿QUE LE FALTARIA AL INMUEBLE?</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs1_exh" style="text-transform:uppercase;" /><?php echo $row['obs1_exh']; ?></textarea>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="obs2_exh">OBSERVACIONES y/o COMENTARIOS ADICIONALES:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="obs2_exh" style="text-transform:uppercase;" /><?php echo $row['obs2_exh']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <label for="nit_cc_ase">* ASESOR COMERCIAL:</label>
                            <select name='nit_cc_ase' class='form-control' required />
                            <option value=''></option>
                                <?php
                                    header('Content-Type: text/html;charset=utf-8');
                                    $consulta='SELECT * FROM asesores';
                                    $res = mysqli_query($mysqli,$consulta);
                                    $num_reg = mysqli_num_rows($res);
                                    while($row1 = $res->fetch_array())
                                    {
                                    ?>
                                <option value='<?php echo $row1['nit_cc_ase']; ?>'<?php if($row['nit_cc_ase']==$row1['nit_cc_ase']){echo 'selected';} ?>>
                                    <?php echo $row1['nom_ape_ase'].' - '.$row1['nit_cc_ase']; ?>
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
                        <label for="archivo"><strong><i class="fa-regular fa-image"></i> ADJUNTAR FOTOGRAFIA DE LA VISITA</strong></label>
                        <input type="file" id="archivo[]" name="archivo[]" multiple="" accept="image/jpeg,image/gif,image/png,image/jpg,image/bmp,image/webp,application/pdf,image/x-eps">
                        <p style="font-family: 'Rajdhani', sans-serif; color: #c68615; text-align: justify;">Recuerde que puede adjuntar varios archivos a la vez, simplemente mantenga presionado la tecla "CTRL" y de clic sobre cada archivo a adjuntar, una vez estén seleccionados presione el botón abrir. Utilice archivos de tipo: PDF</p>
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