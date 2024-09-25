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
        <script src="js/64d58efce2.js" ></script>
		<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
		<link rel="stylesheet" type="text/css" href="../../css/estilos2024.css">
		<link href="../../fontawesome/css/all.css" rel="stylesheet">
		<script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    </head>
    <body>
    	
    	<center>
	    	<img src='../../img/logo.png' width="300" height="212" class="responsive">
		</center>

		<h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-city"></i> INMUEBLES REGISTRADOS </b>
		</h1>

		<div class="flex">
			<div class="box">
				<form action="showinm.php" method="get" class="form">
					<input name="mat_inm" type="text" placeholder="Número matrícula">
					<input name="nom_inm" type="text" placeholder="Nombre(s).">
					<input name="dir_inm" type="text" placeholder="Dirección">
					<input name="mun_inm" type="text" placeholder="Municipio">
					<input value="Realizar Busqueda" type="submit">
				</form>
			</div>
		</div>

		<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

	@$mat_inm 	= ($_GET['mat_inm']);
	@$nom_inm 	= ($_GET['nom_inm']);
	@$dir_inm 	= ($_GET['dir_inm']);
	@$mun_inm 	= ($_GET['mun_inm']);

	$query = "SELECT * FROM inmuebles WHERE (estado_inm=1) AND (nom_inm LIKE '%".$nom_inm."%') AND (dir_inm LIKE '%".$dir_inm."%') AND (mat_inm LIKE '%".$mat_inm."%') AND (mun_inm LIKE '%".$mun_inm."%') ORDER BY dir_inm ASC";
	$res = $mysqli->query($query);
	$num_registros = mysqli_num_rows($res);
	$resul_x_pagina = 50;

	echo "<div class='flex'>
			<div class='box'>
	        	<table class='table'>
	            	<thead>
						<tr>
							<th>No.</th>
							<th>MATRICULA</th>
							<th>INMUEBLE</th>
							<th>DIRECCION</th>
			        		<th>MUNICIPIO</th>
			        		<th>PDF</th>
			        		<th>EDIT</th>
			    		</tr>
			  		</thead>
	            	<tbody>";

	$paginacion = new Zebra_Pagination();
	$paginacion->records($num_registros);
	$paginacion->records_per_page($resul_x_pagina);

	$consulta = "SELECT * FROM inmuebles WHERE (estado_inm=1) AND (nom_inm LIKE '%".$nom_inm."%') AND (dir_inm LIKE '%".$dir_inm."%') AND (mat_inm LIKE '%".$mat_inm."%') AND (mun_inm LIKE '%".$mun_inm."%') ORDER BY dir_inm ASC LIMIT " .(($paginacion->get_page() - 1) * $resul_x_pagina). "," .$resul_x_pagina;
	$result = $mysqli->query($consulta);

	function obtenerNumeroArchivos($mat_inm) {
	    $directorio = 'files/'.$mat_inm.'/';

	    if (file_exists($directorio)) {
	        $num_archivos = count(glob($directorio . '*.*'));
	        return max(0, $num_archivos);
	    } else {
	        return 0;
	    }
	}

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{
		$mat_inm = $row['mat_inm'];
	    $num_archivos = obtenerNumeroArchivos($mat_inm);

	    // Establecer el color a rojo si el número de archivos es cero
		$color = ($num_archivos == 0) ? 'color: red;' : '';
		echo '
					<tr>
						<td data-label="No." style="' . $color . '">'.($i + (($paginacion->get_page() - 1) * $resul_x_pagina)).'</td>
						<td data-label="MATRICULA">'.$row['mat_inm'].'</td>
						<td data-label="INMUEBLE">'.$row['nom_inm'].'</td>
						<td data-label="DIRECCION">'.$row['dir_inm'].'</td>
						<td data-label="MUNICIPIO">'.$row['mun_inm'].'</td>
						<td data-label="PDF"><a href="showinm1.php?mat_inm='.$row['mat_inm'].'"><img src="../../img/consultar.png" width=28 heigth=28></a> ('.$num_archivos.')</td>
						<td data-label="EDIT"><a href="editinm.php?mat_inm='.$row['mat_inm'].'"><img src="../../img/editar.png" width=20 heigth=20></td>
					</tr>';
		$i++;
	}
 
	echo '		</table>
			</div>		';

	$paginacion->render();

?>
		
		</div>
		<center>
			<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a>
		</center>

	</body>
</html>