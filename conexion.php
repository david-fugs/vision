<?php
	 
	$mysqli = new mysqli('localhost', 'visioni4_crm', '0IqlF]ox$teq', 'visioni4_crm');
	$mysqli->set_charset("utf8");
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>
