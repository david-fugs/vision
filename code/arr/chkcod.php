<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $nit_cc_cod = (string)$_POST['nit_cc_cod'];
    
    $result = $mysqli->query(
        'SELECT * FROM codeudor WHERE nit_cc_cod = "'.strtolower($nit_cc_cod).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE CC y/o NIT!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El codeudor no está registrad@.</div>';
    }
}