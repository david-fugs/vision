<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $num_con = (string)$_POST['num_con'];
    
    $result = $mysqli->query(
        'SELECT * FROM contratos WHERE num_con = "'.strtolower($num_con).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE CONTRATO!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El contrato de arrendamiento no está registrado.</div>';
    }
}