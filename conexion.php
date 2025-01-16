<?php

	$mysqli = new mysqli('localhost', 'root', '', 'visioni4_crm');
	$mysqli->set_charset("utf8");
	if($mysqli->connect_error){

		die('Error en la conexion' . $mysqli->connect_error);

	}
    // user visioni4_crm   pass 0IqlF]ox$teq
?>
