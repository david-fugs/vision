<?php
include("../../conexion.php");

$nit_cc_arr = $_POST['nit_cc_arr'];

$query = "SELECT * FROM codeudor WHERE nit_cc_arr = '$nit_cc_arr'";
$result = mysqli_query($mysqli, $query);

$codeudores = array();

while($row = mysqli_fetch_assoc($result)) {
    $codeudores[] = array(
        'nit_cc_cod' => $row['nit_cc_cod'],
        'nom_ape_cod' => $row['nom_ape_cod']
    );
}

echo json_encode($codeudores);
?>
