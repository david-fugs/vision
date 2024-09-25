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

		<h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-people-roof"></i> ASESORES REGISTRADOS </b>
		</h1>

		<div class="flex">
			<div class="box">
				<form action="showase.php" method="get" class="form">
					<input name="nit_cc_ase" type="text" placeholder="Número CC">
					<input name="nom_ape_ase" type="text" placeholder="Nombre(s).">
					<input value="Realizar Busqueda" type="submit">
				</form>
			</div>
		</div>

		<br/><a href="../../access.php"><img src='../../img/atras.png' width="72" height="72" title="Regresar" /></a><br>

<?php

	date_default_timezone_set("America/Bogota");
	include("../../conexion.php");
	require_once("../../zebra.php");

	@$nit_cc_ase 	= ($_GET['nit_cc_ase']);
	@$nom_ape_ase 	= ($_GET['nom_ape_ase']);
	
	$query = "SELECT * FROM asesores WHERE (estado_ase=1) AND (nit_cc_ase LIKE '%".$nit_cc_ase."%') AND (nom_ape_ase LIKE '%".$nom_ape_ase."%') ORDER BY nom_ape_ase ASC";
	$res = $mysqli->query($query);
	$num_registros = mysqli_num_rows($res);
	$resul_x_pagina = 50;

	echo "<div class='flex'>
			<div class='box'>
	        	<table class='table'>
	            	<thead>
						<tr>
							<th>No.</th>
							<th>CC</th>
							<th>NOMBRES Y APELLIDOS</th>
							<th>DIRECCION</th>
			        		<th>TELEFONO</th>
			        		<th>EDIT</th>
			    		</tr>
			  		</thead>
	            	<tbody>";

	$paginacion = new Zebra_Pagination();
	$paginacion->records($num_registros);
	$paginacion->records_per_page($resul_x_pagina);

	$consulta = "SELECT * FROM asesores WHERE (estado_ase=1) AND (nit_cc_ase LIKE '%".$nit_cc_ase."%') AND (nom_ape_ase LIKE '%".$nom_ape_ase."%') ORDER BY nom_ape_ase ASC LIMIT " .(($paginacion->get_page() - 1) * $resul_x_pagina). "," .$resul_x_pagina;
	$result = $mysqli->query($consulta);

	$i = 1;
	while($row = mysqli_fetch_array($result))
	{
	    // Establecer el color a rojo si el número de archivos es cero
		$color = ($num_archivos == 0) ? 'color: red;' : '';
		echo '
					<tr>
						<td data-label="No." style="' . $color . '">'.($i + (($paginacion->get_page() - 1) * $resul_x_pagina)).'</td>
						<td data-label="CC y/o NIT">'.$row['nit_cc_ase'].'</td>
						<td data-label="NOMBRES Y APELLIDOS">'.$row['nom_ape_ase'].'</td>
						<td data-label="DIRECCION">'.$row['dir_ase'].'</td>
						<td data-label="TELEFONO">'.$row['tel1_ase'].'</td>
						<td data-label="EDIT"><a href="editase.php?nit_cc_ase='.$row['nit_cc_ase'].'"><img src="../../img/editar.png" width=20 heigth=20></td>
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