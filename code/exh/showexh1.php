<?php
	 
  session_start();
    
  if(!isset($_SESSION['id_usu'])){
      header("Location: ../../index.php");
  }
  
  $nombre = $_SESSION['nombre'];
  $tipo_usu = $_SESSION['tipo_usu'];
  
  include("../../conexion.php");
	
	$cod_fr_exh = $_GET['cod_fr_exh'];
  
	$sql = "SELECT * FROM exhibiciones WHERE cod_fr_exh = '$cod_fr_exh'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
 
?>
<html lang="es">
  <head> 
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VISION | SOFT</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
        .file-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
            margin-top: 20px;
        }
        .file-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            position: relative;
        }
        .file-item img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }
        .delete-btn {
            color: red;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
        }
    </style>
  </head>
    <body>

    <center>
        <img src='../../img/logo.png' width="300" height="212" class="responsive">
    </center>
    <BR/>

     <section class="principal">

      <div style="border-radius: 9px 9px 9px 9px; -moz-border-radius: 9px 9px 9px 9px; -webkit-border-radius: 9px 9px 9px 9px; border: 4px solid #FFFFFF;" align="center">

        <div align="center">

          <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-address-card"></i> EVIDENCIA FOTOGRAFICA </b></h1>

        </div>

        <?php 
        $path = "files/".$cod_fr_exh;
        if(file_exists($path)) {
            $directorio = opendir($path);
            echo "<div class='file-container'>";
            while ($archivo = readdir($directorio)) {
                if (!is_dir($archivo)) {
                    echo "<div class='file-item'>";
                    echo "<p>$archivo</p>";
                    echo "<a href='$path/$archivo' title='Ver Archivo Adjunto' target='_blank'><img src='../../img/img.png' alt='Ver Archivo Adjunto' width=60 heigth=60></a>";
                    echo "<span class='delete-btn' data-path='$path' data-file='$archivo' title='Eliminar archivo'>Eliminar</span>";
                    echo "</div>";
                }
            }
            echo "</div>";
        }
        ?>
        <br>
        <center>
            <br/><a href="showexh.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
        </center>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Manejo del clic en el botón de eliminar
        $(".delete-btn").click(function() {
            var filePath = $(this).data('path') + '/' + $(this).data('file');
            if (confirm("¿Estás seguro de que deseas eliminar este archivo?")) {
                $.ajax({
                    type: 'POST',
                    url: 'deletefile.php', // Aquí debes especificar la ruta al script PHP para eliminar archivos
                    data: {
                        file_path: filePath
                    },
                    success: function(response) {
                        if (response == 'success') {
                            alert("El archivo ha sido eliminado correctamente.");
                            location.reload(); // Recargar la página después de eliminar el archivo
                        } else {
                            alert("Hubo un error al intentar eliminar el archivo.");
                        }
                    }
                });
            }
        });
    });
</script> 

</body>
</html>
