<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $con_fia = (string)$_POST['con_fia'];
    
    $result = $mysqli->query(
        'SELECT * FROM fianzas WHERE con_fia = "'.strtolower($con_fia).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE FIANZA!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El contrato de fianza no está registrado.</div>';
    }
}