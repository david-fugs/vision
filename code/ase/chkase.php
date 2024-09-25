<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $nit_cc_ase = (string)$_POST['nit_cc_ase'];
    
    $result = $mysqli->query(
        'SELECT * FROM asesores WHERE nit_cc_ase = "'.strtolower($nit_cc_ase).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE CC y/o NIT!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El asesor no está registrad@.</div>';
    }
}