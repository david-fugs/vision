<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos de showprecap.php
    $cod_pre = $_POST['cod_pre'];
    $nombre_inm_pre = $_POST['nombre_inm_pre'];
    $area_total_pre = $_POST['area_total_pre'];
    $direccion_inm_pre = $_POST['direccion_inm_pre'];
    $tipo_inmueble_pre = $_POST['tipo_inmueble_pre'];

    // Capturar los datos de addcap2.php
    $cod_cap = $_POST['cod_cap'];
    $area_total_cap = $_POST['area_total_cap'];
    $area_piso1_cap = $_POST['area_piso1_cap'];
    $area_piso2_cap = $_POST['area_piso2_cap'];
    $area_sotano_cap = $_POST['area_sotano_cap'];
    $malacate_cap = $_POST['malacate_cap'];
    $malacate_num_cap = $_POST['malacate_num_cap'];
    $malacate_ton_cap = $_POST['malacate_ton_cap'];
    $area_patio_maniobra_cap = $_POST['area_patio_maniobra_cap'];
    $otras_areas_cap = $_POST['otras_areas_cap'];
    $forma_bodega_cap = $_POST['forma_bodega_cap'];
    $frente_mesanine_cap = $_POST['frente_mesanine_cap'];
    $fondo_mesanine_cap = $_POST['fondo_mesanine_cap'];
    $frente_lote_cap = $_POST['frente_lote_cap'];
    $fondo_lote_cap = $_POST['fondo_lote_cap'];
    $frente_nivel1_int_cap = $_POST['frente_nivel1_int_cap'];
    $fondo_nivel1_int_cap = $_POST['fondo_nivel1_int_cap'];
    $altura_min_bodega_cap = $_POST['altura_min_bodega_cap'];
    $altura_max_bodega_cap = $_POST['altura_max_bodega_cap'];
    $altura_nivel_2_cap = $_POST['altura_nivel_2_cap'];
    $altura_nivel_1_2_cap = $_POST['altura_nivel_1_2_cap'];
    $altura_sotano_cap = $_POST['altura_sotano_cap'];
    $altura_puerta_veh_cap = $_POST['altura_puerta_veh_cap'];
    $ancho_puerta_veh_cap = $_POST['ancho_puerta_veh_cap'];
    $tipo_puerta_cap = $_POST['tipo_puerta_cap'];
    $edad_cap = $_POST['edad_cap'];
    $estado_bod_cap = $_POST['estado_bod_cap'];
    $niveles_internos_cap = $_POST['niveles_internos_cap'];
    $tipo_bodega_cap = $_POST['tipo_bodega_cap'];
    $esquinera_medianera_cap = $_POST['esquinera_medianera_cap'];
    $parqueaderos_cap = $_POST['parqueaderos_cap'];
    $oficinas_cap = $_POST['oficinas_cap'];
    $oficinas_tama_cap = $_POST['oficinas_tama_cap'];
    $duchas_cap = $_POST['duchas_cap'];
    $lavamanos_cap = $_POST['lavamanos_cap'];
    $sanitarios_cap = $_POST['sanitarios_cap'];
    $poceta_cap = $_POST['poceta_cap'];
    $cocineta_cap = $_POST['cocineta_cap'];
    $desagues_bodega_cap = $_POST['desagues_bodega_cap'];
    $tipo_piso_cap = $_POST['tipo_piso_cap'];
    $capacidad_piso_2_cap = $_POST['capacidad_piso_2_cap'];
    $capacidad_piso_1_psi_cap = $_POST['capacidad_piso_1_psi_cap'];
    $capacidad_piso_1_tone_cap = $_POST['capacidad_piso_1_tone_cap'];
    $capacidad_piso_1_mr_cap = $_POST['capacidad_piso_1_mr_cap'];
    $capacidad_piso_1_fc_cap = $_POST['capacidad_piso_1_fc_cap'];
    $material_piso_2_cap = $_POST['material_piso_2_cap'];
    $material_piso_1_cap = $_POST['material_piso_1_cap'];
    $material_sotano_cap = $_POST['material_sotano_cap'];
    $acabados_muro_bode_cap = $_POST['acabados_muro_bode_cap'];
    $material_muros_porc_cap = $_POST['material_muros_porc_cap'];
    $tipo_techo_cap = $_POST['tipo_techo_cap'];
    $material_techo_cap = $_POST['material_techo_cap'];
    $cod_dane_dep = $_POST['cod_dane_dep'];
    $id_mun = $_POST['id_mun'];
    $sector_cap = $_POST['sector_cap'];
    $ubicacion_gps_cap = $_POST['ubicacion_gps_cap'];
    $estrato_cap = $_POST['estrato_cap'];
    $conjunto_cerrado_cap = $_POST['conjunto_cerrado_cap'];
    $conjunto_vigilado_cap = $_POST['conjunto_vigilado_cap'];
    $porteria_recpecion_cap = $_POST['porteria_recpecion_cap'];
    $energia_precio_kv_cap = $_POST['energia_precio_kv_cap'];
    $agua_precio_m3_cap = $_POST['agua_precio_m3_cap'];
    $empresa_energia_cap = $_POST['empresa_energia_cap'];
    $tipo_energia_cap = $_POST['tipo_energia_cap'];
    $kva_transformador_cap = $_POST['kva_transformador_cap'];
    $calibre_acometida_cap = $_POST['calibre_acometida_cap'];
    $tomas_220_cap = $_POST['tomas_220_cap'];
    $redes_inde_cap = $_POST['redes_inde_cap'];
    $planta_electrica_cap = $_POST['planta_electrica_cap'];
    $empresa_agua_cap = $_POST['empresa_agua_cap'];
    $tanques_agua_reserva_cap = $_POST['tanques_agua_reserva_cap'];
    $tanques_capacidad_cap = $_POST['tanques_capacidad_cap'];
    $hidrante_cap = $_POST['hidrante_cap'];
    $gabinete_cont_incendio_cap = $_POST['gabinete_cont_incendio_cap'];
    $red_contra_incendios_cap = $_POST['red_contra_incendios_cap'];
    $gas_cap = $_POST['gas_cap'];
    $internet_telefonia_cap = implode(',', $_POST['internet_telefonia_cap']); // Convertir array en cadena
    $venta_neta_cap = $_POST['venta_neta_cap'];
    $venta_m2_cap = $_POST['venta_m2_cap'];
    $canon_neto_cap = $_POST['canon_neto_cap'];
    $canon_m2_cap = $_POST['canon_m2_cap'];
    $porcentaje_iva_cap = $_POST['porcentaje_iva_cap'];
    $valor_iva_cap = $_POST['valor_iva_cap_hidden'];
    $admon_cap = $_POST['admon_cap'];
    $renta_total_cap = $_POST['renta_total_cap_hidden'];
    $rte_fte_cap = $_POST['rte_fte_cap'];
    $tractomulas_cap = $_POST['tractomulas_cap'];
    $tractomulas_ctd_cap = $_POST['tractomulas_ctd_cap'];
    $entrada_veh_directo_cap = $_POST['entrada_veh_directo_cap'];
    $entrada_veh_ctd_cap = $_POST['entrada_veh_ctd_cap'];
    $ampliacion_viable_cap = $_POST['ampliacion_viable_cap'];
    $frentes_inmueble_cap = $_POST['frentes_inmueble_cap'];
    $puertas_vehiculares_cap = $_POST['puertas_vehiculares_cap'];
    $empresas_vecinas_cap = $_POST['empresas_vecinas_cap'];
    $transporte_publico_cap = $_POST['transporte_publico_cap'];
    $ctd_muelle_graduable_cap = $_POST['ctd_muelle_graduable_cap'];
    $ctd_muelle_tractomula_cap = $_POST['ctd_muelle_tractomula_cap'];
    $obs1_cap = $_POST['obs1_cap'];
    $obs2_cap = $_POST['obs2_cap'];

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO propiedades (cod_pre, nombre_inm_pre, area_total_pre, direccion_inm_pre, tipo_inmueble_pre, cod_cap, area_total_cap, area_piso1_cap, area_piso2_cap, area_sotano_cap, malacate_cap, malacate_num_cap, malacate_ton_cap, area_patio_maniobra_cap, otras_areas_cap, forma_bodega_cap, frente_mesanine_cap, fondo_mesanine_cap, frente_lote_cap, fondo_lote_cap, frente_nivel1_int_cap, fondo_nivel1_int_cap, altura_min_bodega_cap, altura_max_bodega_cap, altura_nivel_2_cap, altura_nivel_1_2_cap, altura_sotano_cap, altura_puerta_veh_cap, ancho_puerta_veh_cap, tipo_puerta_cap, edad_cap, estado_bod_cap, niveles_internos_cap, tipo_bodega_cap, esquinera_medianera_cap, parqueaderos_cap, oficinas_cap, oficinas_tama_cap, duchas_cap, lavamanos_cap, sanitarios_cap, poceta_cap, cocineta_cap, desagues_bodega_cap, tipo_piso_cap, capacidad_piso_2_cap, capacidad_piso_1_psi_cap, capacidad_piso_1_tone_cap, capacidad_piso_1_mr_cap, capacidad_piso_1_fc_cap, material_piso_2_cap, material_piso_1_cap, material_sotano_cap, acabados_muro_bode_cap, material_muros_porc_cap, tipo_techo_cap, material_techo_cap, cod_dane_dep, id_mun, sector_cap, ubicacion_gps_cap, estrato_cap, conjunto_cerrado_cap, conjunto_vigilado_cap, porteria_recpecion_cap, energia_precio_kv_cap, agua_precio_m3_cap, empresa_energia_cap, tipo_energia_cap, kva_transformador_cap, calibre_acometida_cap, tomas_220_cap, redes_inde_cap, planta_electrica_cap, empresa_agua_cap, tanques_agua_reserva_cap, tanques_capacidad_cap, hidrante_cap, gabinete_cont_incendio_cap, red_contra_incendios_cap, gas_cap, internet_telefonia_cap, venta_neta_cap, venta_m2_cap, canon_neto_cap, canon_m2_cap, porcentaje_iva_cap, valor_iva_cap, admon_cap, renta_total_cap, rte_fte_cap, tractomulas_cap, tractomulas_ctd_cap, entrada_veh_directo_cap, entrada_veh_ctd_cap, ampliacion_viable_cap, frentes_inmueble_cap, puertas_vehiculares_cap, empresas_vecinas_cap, transporte_publico_cap, ctd_muelle_graduable_cap, ctd_muelle_tractomula_cap, obs1_cap, obs2_cap) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $mysqli->error);
    }

    // Realizar el bind_param con todos los campos
    $stmt->bind_param(
        'ssdssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss',
        $cod_pre, $nombre_inm_pre, $area_total_pre, $direccion_inm_pre, $tipo_inmueble_pre, $cod_cap, $area_total_cap, $area_piso1_cap, $area_piso2_cap, $area_sotano_cap, $malacate_cap, $malacate_num_cap, $malacate_ton_cap, $area_patio_maniobra_cap, $otras_areas_cap, $forma_bodega_cap, $frente_mesanine_cap, $fondo_mesanine_cap, $frente_lote_cap, $fondo_lote_cap, $frente_nivel1_int_cap, $fondo_nivel1_int_cap, $altura_min_bodega_cap, $altura_max_bodega_cap, $altura_nivel_2_cap, $altura_nivel_1_2_cap, $altura_sotano_cap, $altura_puerta_veh_cap, $ancho_puerta_veh_cap, $tipo_puerta_cap, $edad_cap, $estado_bod_cap, $niveles_internos_cap, $tipo_bodega_cap, $esquinera_medianera_cap, $parqueaderos_cap, $oficinas_cap, $oficinas_tama_cap, $duchas_cap, $lavamanos_cap, $sanitarios_cap, $poceta_cap, $cocineta_cap, $desagues_bodega_cap, $tipo_piso_cap, $capacidad_piso_2_cap, $capacidad_piso_1_psi_cap, $capacidad_piso_1_tone_cap, $capacidad_piso_1_mr_cap, $capacidad_piso_1_fc_cap, $material_piso_2_cap, $material_piso_1_cap, $material_sotano_cap, $acabados_muro_bode_cap, $material_muros_porc_cap, $tipo_techo_cap, $material_techo_cap, $cod_dane_dep, $id_mun, $sector_cap, $ubicacion_gps_cap, $estrato_cap, $conjunto_cerrado_cap, $conjunto_vigilado_cap, $porteria_recpecion_cap, $energia_precio_kv_cap, $agua_precio_m3_cap, $empresa_energia_cap, $tipo_energia_cap, $kva_transformador_cap, $calibre_acometida_cap, $tomas_220_cap, $redes_inde_cap, $planta_electrica_cap, $empresa_agua_cap, $tanques_agua_reserva_cap, $tanques_capacidad_cap, $hidrante_cap, $gabinete_cont_incendio_cap, $red_contra_incendios_cap, $gas_cap, $internet_telefonia_cap, $venta_neta_cap, $venta_m2_cap, $canon_neto_cap, $canon_m2_cap, $porcentaje_iva_cap, $valor_iva_cap, $admon_cap, $renta_total_cap, $rte_fte_cap, $tractomulas_cap, $tractomulas_ctd_cap, $entrada_veh_directo_cap, $entrada_veh_ctd_cap, $ampliacion_viable_cap, $frentes_inmueble_cap, $puertas_vehiculares_cap, $empresas_vecinas_cap, $transporte_publico_cap, $ctd_muelle_graduable_cap, $ctd_muelle_tractomula_cap, $obs1_cap, $obs2_cap
    );

    // Ejecutar y verificar si la inserción fue exitosa
    if ($stmt->execute()) {
        echo "Registro guardado exitosamente.";
    } else {
        echo "Error al guardar el registro: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
