<?php
include("../../conexion.php");

if (isset($_POST['nit_cc_arr']) && isset($_POST['nit_cc_cod']) && isset($_POST['nom_ape_cod'])) {
    $nit_cc_arr = $_POST['nit_cc_arr'];
    $nit_cc_cod = $_POST['nit_cc_cod'];
    $nom_ape_cod = mb_strtoupper($_POST['nom_ape_cod'], 'UTF-8');
    
    $consulta = "INSERT INTO codeudor (nit_cc_arr, nit_cc_cod, nom_ape_cod) VALUES ('$nit_cc_arr', '$nit_cc_cod', '$nom_ape_cod')";
    
    if (mysqli_query($mysqli, $consulta)) {
        echo "<p>" . $nit_cc_cod . " - " . utf8_encode($nom_ape_cod) . "</p>";
    } else {
        echo "Error: " . $consulta . "<br>" . mysqli_error($mysqli);
    }
}
?>
