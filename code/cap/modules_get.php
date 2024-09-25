<?php
	include("../../conexion.php");
	$cod_dane_dep=intval($_REQUEST['cod_dane_dep']);
	$municipios = $mysqli->prepare("SELECT * FROM municipios WHERE cod_dane_dep = '$cod_dane_dep'") or die(mysqli_error());
		echo '<option value = "">Seleccione un municipio </option>';
	if($municipios->execute()){
		$a_result = $municipios->get_result();
	}
		while($row = $a_result->fetch_array()){
			echo '<option value = "'.$row['id_mun'].'">'.$row['nom_mun'].'</option>';
		}
?>