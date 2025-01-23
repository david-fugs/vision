<?php
// Muestra todos los errores de PHP
/*error_reporting(E_ALL);
    ini_set('display_errors', '1');*/

include("../../conexion.php");
session_start();

if (!isset($_SESSION['id_usu'])) {
    header("Location: ../../index.php");
    exit();
}


$cod_capr = $_POST['cod_capr'] ?? '';
$area_total_capr = $_POST['area_total_capr']?? '';
$area_lote_capr = $_POST['area_lote_capr'] ?? '';
$area_piso1_capr = $_POST['area_piso1_capr'] ?? '';
$area_piso2_capr = $_POST['area_piso2_capr']?? '';
$frente_habi1_capr = $_POST['frente_habi1_capr']?? '';
$fondo_habi1_capr = $_POST['fondo_habi1_capr']?? '';
$frente_habi2_capr = $_POST['frente_habi2_capr']?? '';
$fondo_habi2_capr = $_POST['fondo_habi2_capr']?? '';
$frente_habi3_capr = $_POST['frente_habi3_capr']?? '';
$fondo_habi3_capr = $_POST['fondo_habi3_capr']?? '';
$frente_sala_capr = $_POST['frente_sala_capr']?? '';
$fondo_sala_capr = $_POST['fondo_sala_capr']?? '';
$vestidores_capr = $_POST['vestidores_capr']?? '';
$closets_capr = $_POST['closets_capr']?? '';
$salas_capr = $_POST['salas_capr']?? '';
$balcon_capr = $_POST['balcon_capr']?? '';
$terraza_capr = $_POST['terraza_capr']?? '';
$patio_capr = $_POST['patio_capr']?? '';
$sotanos_capr = $_POST['sotanos_capr']?? '';
$pisos_capr = $_POST['pisos_capr']?? '';
$tipo_cocina_capr = $_POST['tipo_cocina_capr']?? '';
$isla_cocina_capr = $_POST['isla_cocina_capr']?? '';
$tipo_lavaplatos_capr = $_POST['tipo_lavaplatos_capr']?? '';
$espacio_nevecon_capr = $_POST['espacio_nevecon_capr']?? '';
$cod_dane_dep = $_POST['cod_dane_dep']?? '';
$id_mun = $_POST['id_mun']?? '';
$sector_capr = $_POST['sector_capr'];
$ubicacion_gps_capr = $_POST['ubicacion_gps_capr']?? '';
$estrato_capr = $_POST['estrato_capr']?? '';
$posición_capr = $_POST['posición_capr']?? '';
$conjunto_cerrado_capr = $_POST['conjunto_cerrado_capr']?? '';
$conjunto_vigilado_capr = $_POST['conjunto_vigilado_capr']?? '';
$porteria_recpecion_capr = $_POST['porteria_recpecion_capr']?? '';
$citofonia_capr = $_POST['citofonia_capr']?? '';
$edad_capr = $_POST['edad_capr']?? '';
$estado_inm_capr = $_POST['estado_inm_capr']?? '';
$niveles_internos_capr = $_POST['niveles_internos_capr']?? '';
$tipo_capr = $_POST['tipo_capr']?? '';
$esquinera_medianera_capr = $_POST['esquinera_medianera_capr']?? '';
$oficinas_capr = $_POST['oficinas_capr']?? '';
$duchas_capr = $_POST['duchas_capr']?? '';
$lavamanos_capr = $_POST['lavamanos_capr']?? '';
$sanitarios_capr = $_POST['sanitarios_capr']?? '';
$poceta_capr = $_POST['poceta_capr']?? '';
$cocineta_capr = $_POST['cocineta_capr']?? '';
$tinas_capr = $_POST['tinas_capr']?? '';
$transporte_publico_capr = $_POST['transporte_publico_capr']?? '';
$aire_acondicionado_capr = $_POST['aire_acondicionado_capr']?? '';
$energia_precio_kv_capr = $_POST['energia_precio_kv_capr']?? '';
$agua_precio_m3_capr = $_POST['agua_precio_m3_capr']?? '';
$empresa_energia_capr = $_POST['empresa_energia_capr']?? '';
$tipo_energia_capr = $_POST['tipo_energia_capr']?? '';
$kva_transformador_capr = $_POST['kva_transformador_capr']?? '';
$calibre_acometida_capr = $_POST['calibre_acometida_capr']?? '';
$tomas_220_capr = $_POST['tomas_220_capr']?? '';
$redes_inde_capr = $_POST['redes_inde_capr']?? '';
$planta_electrica_capr = $_POST['planta_electrica_capr']?? '';
$empresa_agua_capr = $_POST['empresa_agua_capr']?? '';
$tanques_agua_reserva_capr = $_POST['tanques_agua_reserva_capr']?? '';
$hidrante_capr = $_POST['hidrante_capr']?? '';
$gabinete_cont_incendio_capr = $_POST['gabinete_cont_incendio_capr']?? '';
$red_contra_incendios_capr = $_POST['red_contra_incendios_capr']?? '';
$gas_capr = $_POST['gas_capr']?? '';
$agua_caliente_capr = $_POST['agua_caliente_capr']?? '';
$internet_telefonia_capr = $_POST['internet_telefonia_capr']?? '';
$restaurantes_capr = $_POST['restaurantes_capr']?? '';
$supermercados_capr = $_POST['supermercados_capr']?? '';
$droguerias_capr = $_POST['droguerias_capr']?? '';
$centro_comer_capr = $_POST['centro_comer_capr']?? '';
$universidades_capr = $_POST['universidades_capr']?? '';
$colegios_capr = $_POST['colegios_capr']?? '';
$jardines_infantiles_capr = $_POST['jardines_infantiles_capr']?? '';
$otros_capr = $_POST['otros_capr']?? '';
$jardines_capr = $_POST['jardines_capr']?? '';
$turcos_capr = $_POST['turcos_capr']?? '';
$jacuzzi_capr = $_POST['jacuzzi_capr']?? '';
$sauna_capr = $_POST['sauna_capr']?? '';
$cancha_tenis_capr = $_POST['cancha_tenis_capr']?? '';
$cancha_futbol_capr = $_POST['cancha_futbol_capr']?? '';
$cancha_micro_fut_capr = $_POST['cancha_micro_fut_capr']?? '';
$cancha_basquet_capr = $_POST['cancha_basquet_capr']?? '';
$piscina_adultos_capr = $_POST['piscina_adultos_capr']?? '';
$piscina_ninos_capr = $_POST['piscina_ninos_capr']?? '';
$sendero_ecol_capr = $_POST['sendero_ecol_capr']?? '';
$mascotas_capr = $_POST['mascotas_capr']?? '';
$zona_mascotas_capr = $_POST['zona_mascotas_capr']?? '';
$gym_capr = $_POST['gym_capr']?? '';
$ascensor_capr = $_POST['ascensor_capr']?? '';
$juegos_ninos_capr = $_POST['juegos_ninos_capr']?? '';
$lago_pesca_capr = $_POST['lago_pesca_capr']?? '';
$cancha_squash_capr = $_POST['cancha_squash_capr']?? '';
$otros_juegos_capr = $_POST['otros_juegos_capr']?? '';
$acabados_pisos_capr = $_POST['acabados_pisos_capr']?? '';
$acabados_muro_capr = $_POST['acabados_muro_capr']?? '';
$material_muro_por_capr = $_POST['material_muro_por_capr']?? '';
$tipo_techo_capr = $_POST['tipo_techo_capr']?? '';
$material_techo_capr = $_POST['material_techo_capr']?? '';
$parquead_cubi_capr = $_POST['parquead_cubi_capr']?? '';
$parquead_descubi_capr = $_POST['parquead_descubi_capr']?? '';
$entradas_vehic_capr = $_POST['entradas_vehic_capr']?? '';
$puertas_vehic_capr = $_POST['puertas_vehic_capr']?? '';
$puertas_peaton_capr = $_POST['puertas_peaton_capr']?? '';
$frentes_inmu_capr = $_POST['frentes_inmu_capr']?? '';
$venta_neta_capr = $_POST['venta_neta_capr']?? '';
$venta_m2_capr = $_POST['venta_m2_capr']?? '';
$canon_neto_capr = $_POST['canon_neto_capr']?? '';
$canon_m2_capr = $_POST['canon_m2_capr']?? '';
$porcentaje_iva_capr = $_POST['porcentaje_iva_capr']?? '';
$valor_iva_capr = $_POST['valor_iva_capr']?? '';
$admon_capr = $_POST['admon_capr']?? '';
$renta_total_capr = $_POST['renta_total_capr']?? '';
$rte_fte_capr = $_POST['rte_fte_capr']?? '';
$fotos_capr = $_POST['fotos_capr']?? '';
$videos_capr = $_POST['videos_capr']?? '';
$planos_capr = $_POST['planos_capr']?? '';
$uso_suelos_capr = $_POST['uso_suelos_capr']?? '';
$mapas_capr = $_POST['mapas_capr']?? '';
$empresas_vecinas_capr = $_POST['empresas_vecinas_capr']?? '';
$direccion_inm_capr = $_POST['direccion_inm_capr']?? '';
$num_matricula_inm_capr = $_POST['num_matricula_inm_capr']?? '';
$num_matricula_agua_capr = $_POST['num_matricula_agua_capr']?? '';
$num_matricula_energia_capr = $_POST['num_matricula_energia_capr']?? '';
$num_matricula_gas_capr = $_POST['num_matricula_gas_capr']?? '';
$nombre_razon_social_capr = $_POST['nombre_razon_social_capr']?? '';
$representante_legal_capr = $_POST['representante_legal_capr']?? '';
$cc_nit_repre_legal_capr = $_POST['cc_nit_repre_legal_capr']?? '';
$cel_repre_legal_capr = $_POST['cel_repre_legal_capr']?? '';
$tel_repre_legal_capr = $_POST['tel_repre_legal_capr']?? '';
$email_repre_legal_capr = $_POST['email_repre_legal_capr']?? '';
$dir_repre_legal_capr = $_POST['dir_repre_legal_capr']?? '';
$remuneracion_vta_capr = $_POST['remuneracion_vta_capr']?? '';
$remuneracion_renta_capr = $_POST['remuneracion_renta_capr']?? '';
$id_usu = $_SESSION['id_usu']?? '';
$obs1_capr1 = $_POST['obs1_capr1']?? '';
$nit_cc_ase = $_SESSION['nit_cc_ase']?? '';
$pre_registro = $_POST['pre_registro']?? '';
if($pre_registro == '0') $residencial_completa = '0';
else $residencial_completa = '1';

$id_capr = $_POST['id_capr'] ?? '';

if ($id_capr != '') {
    // Actualizar en la tabla CONTRATOS
    $query_contratos = "UPDATE capta_comercial SET comercial_completa = 1,
    frente_habi1_capr = '$frente_habi1_capr', fondo_habi1_capr = '$fondo_habi1_capr', frente_habi2_capr = '$frente_habi2_capr', fondo_habi2_capr = '$fondo_habi2_capr', frente_habi3_capr = '$frente_habi3_capr', fondo_habi3_capr = '$fondo_habi3_capr', frente_sala_capr = '$frente_sala_capr',
    fondo_sala_capr = '$fondo_sala_capr', vestidores_capr = '$vestidores_capr', closets_capr = '$closets_capr', salas_capr = '$salas_capr', balcon_capr = '$balcon_capr', terraza_capr = '$terraza_capr', patio_capr = '$patio_capr', sotanos_capr = '$sotanos_capr', pisos_capr = '$pisos_capr',
    tipo_cocina_capr = '$tipo_cocina_capr', isla_cocina_capr = '$isla_cocina_capr', tipo_lavaplatos_capr = '$tipo_lavaplatos_capr', espacio_nevecon_capr = '$espacio_nevecon_capr', restaurantes_capr = '$restaurantes_capr', supermercados_capr = '$supermercados_capr', droguerias_capr = '$droguerias_capr',
    centro_comer_capr = '$centro_comer_capr', universidades_capr = '$universidades_capr', colegios_capr = '$colegios_capr', jardines_infantiles_capr = '$jardines_infantiles_capr', otros_capr = '$otros_capr', jardines_capr = '$jardines_capr', turco_capr = '$turco_capr', jacuzzi_capr = '$jacuzzi_capr',
    sauna_capr = '$sauna_capr', cancha_tenis_capr = '$cancha_tenis_capr', cancha_futbol_capr = '$cancha_futbol_capr', cancha_micro_fut_capr = '$cancha_micro_fut_capr', cancha_basquet_capr = '$cancha_basquet_capr', piscina_adultos_capr = '$piscina_adultos_capr', piscina_ninos_capr = '$piscina_ninos_capr',
    sendero_ecol_capr = '$sendero_ecol_capr', mascotas_capr = '$mascotas_capr', zona_mascotas_capr = '$zona_mascotas_capr', gym_capr = '$gym_capr', ascensor_capr = '$ascensor_capr', juegos_ninos_capr = '$juegos_ninos_capr', lago_pesca_capr = '$lago_pesca_capr', cancha_squash_capr = '$cancha_squash_capr',
    otros_juegos_capr = '$otros_juegos_capr', acabados_pisos_capr = '$acabados_pisos_capr', acabados_muro_capr = '$acabados_muro_capr', parquead_cubi_capr = '$parquead_cubi_capr', parquead_descubi_capr = '$parquead_descubi_capr', entradas_vehic_capr = '$entradas_vehic_capr', puertas_vehic_capr = '$puertas_vehic_capr',
    puertas_peaton_capr = '$puertas_peaton_capr', frentes_inmu_capr = '$frentes_inmu_capr', citofonia_capr = '$citofonia_capr', tinas_capr = '$tinas_capr', agua_caliente_capr = '$agua_caliente_capr', aire_acondicionado_capr = '$aire_acondicionado_capr',
    cod_cap = '$cod_capr', area_total_cap = '$area_total_cap',  area_lote_capr = '$area_lote_capr', area_piso1_cap = '$area_piso1_cap', area_piso2_cap = '$area_piso2_cap', area_sotano_cap = '$area_sotano_cap', malacate_cap = '$malacate_cap', malacate_num_cap = '$malacate_num_cap', malacate_ton_cap = '$malacate_ton_cap',
    area_patio_maniobra_cap = '$area_patio_maniobra_cap', otras_areas_cap = '$otras_areas_cap', forma_bodega_cap = '$forma_bodega_cap', frente_mesanine_cap = '$frente_mesanine_cap', fondo_mesanine_cap = '$fondo_mesanine_cap', frente_lote_cap = '$frente_lote_cap', fondo_lote_cap = '$fondo_lote_cap',
    frente_nivel1_int_cap = '$frente_nivel1_int_cap', fondo_nivel1_int_cap = '$fondo_nivel1_int_cap', frente_sotano_cap = '$frente_sotano_cap', fondo_sotano_cap = '$fondo_sotano_cap', altura_min_bodega_cap = '$altura_min_bodega_cap', altura_max_bodega_cap = '$altura_max_bodega_cap',
    altura_nivel_1_2_cap = '$altura_nivel_1_2_cap', altura_nivel_2_cap = '$altura_nivel_2_cap', altura_sotano_cap = '$altura_sotano_cap', altura_puerta_veh_cap = '$altura_puerta_veh_cap', ancho_puerta_veh_cap = '$ancho_puerta_veh_cap', tipo_puerta_cap = '$tipo_puerta_cap', edad_cap = '$edad_cap',
    estado_bod_cap = '$estado_bod_cap', niveles_internos_cap = '$niveles_internos_cap', tipo_bodega_cap = '$tipo_bodega_cap', esquinera_medianera_cap = '$esquinera_medianera_cap', parqueaderos_cap = '$parqueaderos_cap', oficinas_cap = '$oficinas_cap', oficinas_tama_cap = '$oficinas_tama_cap',
    duchas_cap = '$duchas_cap', lavamanos_cap = '$lavamanos_cap', sanitarios_cap = '$sanitarios_cap', poceta_cap = '$poceta_cap', cocineta_cap = '$cocineta_cap', desagues_bodega_cap = '$desagues_bodega_cap', tipo_piso_cap = '$tipo_piso_cap', capacidad_piso_2_cap = '$capacidad_piso_2_cap',
    capacidad_piso_1_psi_cap = '$capacidad_piso_1_psi_cap', capacidad_piso_1_tone_cap = '$capacidad_piso_1_tone_cap', capacidad_piso_1_mr_cap = '$capacidad_piso_1_mr_cap', capacidad_piso_1_fc_cap = '$capacidad_piso_1_fc_cap', material_piso_2_cap = '$material_piso_2_cap', material_piso_1_cap = '$material_piso_1_cap',
    material_sotano_cap = '$material_sotano_cap', acabados_muro_bode_cap = '$acabados_muro_bode_cap', material_muros_porc_cap = '$material_muros_porc_cap', tipo_techo_cap = '$tipo_techo_cap', material_techo_cap = '$material_techo_cap', cod_dane_dep = '$cod_dane_dep', id_mun = '$id_mun',
    sector_capr = '$sector_capr', ubicacion_gps_capr = '$ubicacion_gps_capr', estrato_cap = '$estrato_cap', posición_cap = '$posición_cap', conjunto_cerrado_cap = '$conjunto_cerrado_cap', conjunto_vigilado_cap = '$conjunto_vigilado_cap', porteria_recpecion_cap = '$porteria_recpecion_cap',
    energia_precio_kv_cap = '$energia_precio_kv_cap', agua_precio_m3_cap = '$agua_precio_m3_cap', empresa_energia_capr = '$empresa_energia_capr', tipo_energia_capr = '$tipo_energia_capr', kva_transformador_cap = '$kva_transformador_cap', calibre_acometida_cap = '$calibre_acometida_cap',
    tomas_220_cap = '$tomas_220_cap', redes_inde_cap = '$redes_inde_cap', planta_electrica_cap = '$planta_electrica_cap', empresa_agua_capr = '$empresa_agua_capr', tanques_agua_reserva_cap = '$tanques_agua_reserva_cap', tanques_capacidad_cap = '$tanques_capacidad_cap', hidrante_cap = '$hidrante_cap',
    gabinete_cont_incendio_cap = '$gabinete_cont_incendio_cap', red_contra_incendios_cap = '$red_contra_incendios_cap', gas_cap = '$gas_cap', internet_telefonia_capr = '$internet_telefonia_capr', venta_neta_cap = '$venta_neta_cap', venta_m2_cap = '$venta_m2_cap', venta_total = '$venta_total',
    canon_neto_cap = '$canon_neto_cap', canon_m2_cap = '$canon_m2_cap', porcentaje_iva_cap = '$porcentaje_iva_cap', valor_iva_cap = '$valor_iva_cap', admon_cap = '$admon_cap', renta_total_cap = '$renta_total_cap', rte_fte_cap = '$rte_fte_cap', tractomulas_cap = '$tractomulas_cap',
    tractomulas_ctd_cap = '$tractomulas_ctd_cap', ctd_muelle_graduable_cap = '$ctd_muelle_graduable_cap', altura_muelle_graduable_cap = '$altura_muelle_graduable_cap', ctd_muelle_tractomula_cap = '$ctd_muelle_tractomula_cap', tipo_muelle_tractomula_cap = '$tipo_muelle_tractomula_cap',
    altura_muelle_tractomula_cap = '$altura_muelle_tractomula_cap', entrada_veh_directo_cap = '$entrada_veh_directo_cap', entrada_veh_ctd_cap = '$entrada_veh_ctd_cap', ampliacion_viable_cap = '$ampliacion_viable_cap', frentes_inmueble_cap = '$frentes_inmueble_cap', puertas_vehiculares_cap = '$puertas_vehiculares_cap',
    fotos_cap = '$fotos_cap', videos_cap = '$videos_cap', planos_cap = '$planos_cap', uso_suelos_cap = '$uso_suelos_cap', mapas_cap = '$mapas_cap', empresas_vecinas_cap = '$empresas_vecinas_cap', transporte_publico_cap = '$transporte_publico_cap', direccion_inm_capr = '$direccion_inm_capr',
    num_matricula_inm_capr = '$num_matricula_inm_capr', num_matricula_agua_cap = '$num_matricula_agua_cap', num_matricula_energia_cap = '$num_matricula_energia_cap', num_matricula_gas_cap = '$num_matricula_gas_cap', nombre_razon_social_capr = '$nombre_razon_social_capr', representante_legal_capr = '$representante_legal_capr',
    cc_nit_repre_legal_cap = '$cc_nit_repre_legal_cap', cel_repre_legal_cap = '$cel_repre_legal_cap', tel_repre_legal_capr = '$tel_repre_legal_capr', email_repre_legal_capr = '$email_repre_legal_capr', dir_repre_legal_capr = '$dir_repre_legal_capr', remuneracion_vta_cap = '$remuneracion_vta_cap',
    remuneracion_renta_cap = '$remuneracion_renta_cap', obs1_cap= '$obs1_capr1', nit_cc_ase = '$nit_cc_ase', estado_cap = '$estado_cap', fecha_alta_cap = '$fecha_alta_cap', id_usu_alta_cap = '$id_usu_alta_cap', fecha_edit_cap = '$fecha_edit_cap', id_usu = '$id_usu', consentimiento = '$consentimiento'
    WHERE id_cap = '$id_cap'";
    if (mysqli_query($mysqli, $query_contratos)) {
        echo "Actualizacion exitosa.";
        //guardar los archivos en files
        if (!empty($_FILES['archivo']['name'][0])) {
            $folderPath = 'files/' . $cod_capr;
            // Verifica si la carpeta existe; si no, la crea
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true); // Permisos 0777 y recursivo
            }
            foreach ($_FILES['archivo']['name'] as $index => $name) {
                if ($_FILES['archivo']['error'][$index] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['archivo']['tmp_name'][$index];
                    $destination = $folderPath . '/' . basename($name); // Ruta destino

                    // Mover el archivo subido a la carpeta de destino
                    if (move_uploaded_file($tmp_name, $destination)) {
                        echo "Archivo '$name' subido correctamente.<br>";
                    } else {
                        echo "Error al mover el archivo '$name'.<br>";
                    }
                } else {
                    echo "Error al subir el archivo '$name'.<br>";
                }
            }
        } else {
            echo "No se recibieron archivos.";
        }
    } else {
        echo "Error al insertar los datos: " . mysqli_error($mysqli);
    }
}


if ($id_cap == '') {
    // Insertar en la tabla CONTRATOS
    $query_contratos = "INSERT INTO capta_residencial
    (cod_capr, area_total_capr, area_lote_capr, area_piso1_capr, area_piso2_capr, frente_habi1_capr, fondo_habi1_capr, frente_habi2_capr, fondo_habi2_capr, frente_habi3_capr, fondo_habi3_capr, frente_sala_capr, fondo_sala_capr, vestidores_capr, closets_capr, salas_capr, balcon_capr, terraza_capr, patio_capr, sotanos_capr, pisos_capr, tipo_cocina_capr, isla_cocina_capr, tipo_lavaplatos_capr, espacio_nevecon_capr, cod_dane_dep, id_mun, sector_capr, ubicacion_gps_capr, estrato_capr, posición_capr, conjunto_cerrado_capr, conjunto_vigilado_capr, porteria_recpecion_capr, citofonia_capr, edad_capr, estado_inm_capr, niveles_internos_capr, tipo_capr, esquinera_medianera_capr, oficinas_capr, duchas_capr, lavamanos_capr, sanitarios_capr, poceta_capr, cocineta_capr, tinas_capr, transporte_publico_capr, aire_acondicionado_capr, energia_precio_kv_capr, agua_precio_m3_capr, empresa_energia_capr, tipo_energia_capr, kva_transformador_capr, calibre_acometida_capr, tomas_220_capr, redes_inde_capr, planta_electrica_capr, empresa_agua_capr, tanques_agua_reserva_capr, hidrante_capr, gabinete_cont_incendio_capr, red_contra_incendios_capr, gas_capr, agua_caliente_capr, internet_telefonia_capr, restaurantes_capr, supermercados_capr, droguerias_capr, centro_comer_capr, universidades_capr, colegios_capr, jardines_infantiles_capr, otros_capr, jardines_capr, turcos_capr, jacuzzi_capr, sauna_capr, cancha_tenis_capr, cancha_futbol_capr, cancha_micro_fut_capr, cancha_basquet_capr, piscina_adultos_capr, piscina_ninos_capr, sendero_ecol_capr, mascotas_capr, zona_mascotas_capr, gym_capr, ascensor_capr, juegos_ninos_capr, lago_pesca_capr, cancha_squash_capr, otros_juegos_capr, acabados_pisos_capr, acabados_muro_capr, material_muro_por_capr, tipo_techo_capr, material_techo_capr, parquead_cubi_capr, parquead_descubi_capr, entradas_vehic_capr, puertas_vehic_capr, puertas_peaton_capr, frentes_inmu_capr, venta_neta_capr, venta_m2_capr, canon_neto_capr, canon_m2_capr, porcentaje_iva_capr, valor_iva_capr, admon_capr, renta_total_capr, rte_fte_capr, fotos_capr, videos_capr, planos_capr, uso_suelos_capr, mapas_capr, empresas_vecinas_capr, direccion_inm_capr, num_matricula_inm_capr, num_matricula_agua_capr, num_matricula_energia_capr, num_matricula_gas_capr, nombre_razon_social_capr, representante_legal_capr, cc_nit_repre_legal_capr, cel_repre_legal_capr, tel_repre_legal_capr, email_repre_legal_capr, dir_repre_legal_capr, remuneracion_vta_capr, remuneracion_renta_capr, id_usu, obs1_capr1,nit_cc_ase,residencial_completa)
    VALUES ('$cod_capr', '$area_total_capr', '$area_lote_capr', '$area_piso1_capr', '$area_piso2_capr', '$frente_habi1_capr', '$fondo_habi1_capr', '$frente_habi2_capr', '$fondo_habi2_capr', '$frente_habi3_capr', '$fondo_habi3_capr', '$frente_sala_capr', '$fondo_sala_capr', '$vestidores_capr', '$closets_capr', '$salas_capr', '$balcon_capr', '$terraza_capr', '$patio_capr', '$sotanos_capr', '$pisos_capr', '$tipo_cocina_capr', '$isla_cocina_capr', '$tipo_lavaplatos_capr', '$espacio_nevecon_capr', '$cod_dane_dep', '$id_mun', '$sector_capr', '$ubicacion_gps_capr', '$estrato_capr', '$posición_capr', '$conjunto_cerrado_capr', '$conjunto_vigilado_capr', '$porteria_recpecion_capr', '$citofonia_capr', '$edad_capr', '$estado_inm_capr', '$niveles_internos_capr', '$tipo_capr', '$esquinera_medianera_capr', '$oficinas_capr', '$duchas_capr', '$lavamanos_capr', '$sanitarios_capr', '$poceta_capr', '$cocineta_capr', '$tinas_capr', '$transporte_publico_capr', '$aire_acondicionado_capr', '$energia_precio_kv_capr', '$agua_precio_m3_capr', '$empresa_energia_capr', '$tipo_energia_capr', '$kva_transformador_capr', '$calibre_acometida_capr', '$tomas_220_capr', '$redes_inde_capr', '$planta_electrica_capr', '$empresa_agua_capr', '$tanques_agua_reserva_capr', '$hidrante_capr', '$gabinete_cont_incendio_capr', '$red_contra_incendios_capr', '$gas_capr', '$agua_caliente_capr', '$internet_telefonia_capr', '$restaurantes_capr', '$supermercados_capr', '$droguerias_capr', '$centro_comer_capr', '$universidades_capr', '$colegios_capr', '$jardines_infantiles_capr', '$otros_capr', '$jardines_capr', '$turcos_capr', '$jacuzzi_capr', '$sauna_capr', '$cancha_tenis_capr', '$cancha_futbol_capr', '$cancha_micro_fut_capr', '$cancha_basquet_capr', '$piscina_adultos_capr', '$piscina_ninos_capr', '$sendero_ecol_capr', '$mascotas_capr', '$zona_mascotas_capr', '$gym_capr', '$ascensor_capr', '$juegos_ninos_capr', '$lago_pesca_capr', '$cancha_squash_capr', '$otros_juegos_capr', '$acabados_pisos_capr', '$acabados_muro_capr', '$material_muro_por_capr', '$tipo_techo_capr', '$material_techo_capr', '$parquead_cubi_capr', '$parquead_descubi_capr', '$entradas_vehic_capr', '$puertas_vehic_capr', '$puertas_peaton_capr', '$frentes_inmu_capr', '$venta_neta_capr', '$venta_m2_capr', '$canon_neto_capr', '$canon_m2_capr', '$porcentaje_iva_capr', '$valor_iva_capr', '$admon_capr', '$renta_total_capr', '$rte_fte_capr', '$fotos_capr', '$videos_capr', '$planos_capr', '$uso_suelos_capr', '$mapas_capr', '$empresas_vecinas_capr', '$direccion_inm_capr', '$num_matricula_inm_capr', '$num_matricula_agua_capr', '$num_matricula_energia_capr', '$num_matricula_gas_capr', '$nombre_razon_social_capr', '$representante_legal_capr', '$cc_nit_repre_legal_capr', '$cel_repre_legal_capr', '$tel_repre_legal_capr', '$email_repre_legal_capr', '$dir_repre_legal_capr', '$remuneracion_vta_capr', '$remuneracion_renta_capr',  '$id_usu', '$obs1_capr1','$nit_cc_ase', '$residencial_completa')

      ";

    if (mysqli_query($mysqli, $query_contratos)) {
        echo "Inserción exitosa.";
        //guardar los archivos en files
        if (!empty($_FILES['archivo']['name'][0])) {
            $folderPath = 'files_resid/' . $cod_capr;
            // Verifica si la carpeta existe; si no, la crea
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true); // Permisos 0777 y recursivo
            }
            foreach ($_FILES['archivo']['name'] as $index => $name) {
                if ($_FILES['archivo']['error'][$index] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['archivo']['tmp_name'][$index];
                    $destination = $folderPath . '/' . basename($name); // Ruta destino

                    // Mover el archivo subido a la carpeta de destino
                    if (move_uploaded_file($tmp_name, $destination)) {
                        echo "Archivo '$name' subido correctamente.<br>";
                    } else {
                        echo "Error al mover el archivo '$name'.<br>";
                    }
                } else {
                    echo "Error al subir el archivo '$name'.<br>";
                }
            }
        } else {
            echo "No se recibieron archivos.";
        }
    } else {
        echo "Error al insertar los datos: " . mysqli_error($mysqli);
    }
}

echo "
            <!DOCTYPE html>
                <html lang='es'>
                    <head>
                        <meta charset='utf-8' />
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet'>
                        <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
                        <link rel='stylesheet' href='../../css/bootstrap.min.css'>
                        <link href='../../fontawesome/css/all.css' rel='stylesheet'>
                        <script src='https://kit.fontawesome.com/fed2435e21.js' crossorigin='anonymous'></script>
                        <title>VISION | SOFT</title>
                        <style>
                            .responsive {
                                max-width: 100%;
                                height: auto;
                            }
                        </style>
                    </head>
                    <body>
                        <center>
                           <img src='../../img/logo.png' width=300 height=212 class='responsive'>
                        <div class='container'>
                            <br />
                            <h3><b><i class='fa-solid fa-building-circle-check'></i> SE GUARDÓ DE FORMA EXITOSA EL REGISTRO</b></h3><br />
                            <p align='center'><a href='showFichaTec.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                        </div>
                        </center>
                    </body>
                </html>
            ";
