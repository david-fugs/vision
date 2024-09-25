<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $nit_cc_arr = (string)$_POST['nit_cc_arr'];
    
    $result = $mysqli->query(
        'SELECT * FROM arrendatarios WHERE nit_cc_arr = "'.strtolower($nit_cc_arr).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE CC y/o NIT!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El arrendatario no está registrad@.</div>';
    }
}