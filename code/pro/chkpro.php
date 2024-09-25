<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $nit_cc_pro = (string)$_POST['nit_cc_pro'];
    
    $result = $mysqli->query(
        'SELECT * FROM propietarios WHERE nit_cc_pro = "'.strtolower($nit_cc_pro).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE CC y/o NIT!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El propietario no está registrad@.</div>';
    }
}