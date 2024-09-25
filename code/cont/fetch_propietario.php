<?php
include("../../conexion.php");

if (isset($_POST['mat_inm'])) {
    $mat_inm = $_POST['mat_inm'];

    // Consulta para obtener el propietario correspondiente al inmueble seleccionado
    $query = "SELECT p.nit_cc_pro, p.nom_ape_pro FROM propiedades prop 
              INNER JOIN propietarios p ON prop.nit_cc_pro = p.nit_cc_pro 
              WHERE prop.mat_inm = '$mat_inm'";

    $result = mysqli_query($mysqli, $query);

    $propietarios = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $propietarios[] = array(
            'nit_cc_pro' => $row['nit_cc_pro'],
            'nom_ape_pro' => $row['nom_ape_pro']
        );
    }

    echo json_encode($propietarios);
}
?>
