<?php 
require('../../conexion.php');
sleep(1);
if (isset($_POST)) {
    $mat_inm = (string)$_POST['mat_inm'];
    
    $result = $mysqli->query(
        'SELECT * FROM inmuebles WHERE mat_inm = "'.strtolower($mat_inm).'"'
    );
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>VERIFICA EL NUMERO DE MATRICULA!</strong> Ya existe uno igual.</div>';
    } else {
        echo '<div class="alert alert-success"><strong>ES NUEVO REGISTRO!</strong> El inmueble no está registrado.</div>';
    }
}