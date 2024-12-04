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

$frente_habi1_capr = $_POST['frente_habi1_capr'] ?? '';
$fondo_habi1_capr = $_POST['fondo_habi1_capr'] ?? '';
$frente_habi2_capr = $_POST['frente_habi2_capr'] ?? '';
$fondo_habi2_capr = $_POST['fondo_habi2_capr'] ?? '';
$frente_habi3_capr = $_POST['frente_habi3_capr'] ?? '';
$fondo_habi3_capr = $_POST['fondo_habi3_capr'] ?? '';
$frente_sala_capr = $_POST['frente_sala_capr'] ?? '';
$fondo_sala_capr = $_POST['fondo_sala_capr'] ?? '';
$vestidores_capr = $_POST['vestidores_capr'] ?? '';
$closets_capr = $_POST['closets_capr'] ?? '';
$salas_capr = $_POST['salas_capr'] ?? '';
$balcon_capr = $_POST['balcon_capr'] ?? '';
$terraza_capr = $_POST['terraza_capr'] ?? '';
$patio_capr = $_POST['patio_capr'] ?? '';
$sotanos_capr = $_POST['sotanos_capr'] ?? '';
$pisos_capr = $_POST['pisos_capr'] ?? '';
$tipo_cocina_capr = $_POST['tipo_cocina_capr'] ?? '';
$isla_cocina_capr = $_POST['isla_cocina_capr'] ?? '';
$tipo_lavaplatos_capr = $_POST['tipo_lavaplatos_capr'] ?? '';
$espacio_nevecon_capr = $_POST['espacio_nevecon_capr'] ?? '';
$restaurantes_capr = $_POST['restaurantes_capr'] ?? '';
$supermercados_capr = $_POST['supermercados_capr'] ?? '';
$droguerias_capr = $_POST['droguerias_capr'] ?? '';
$centro_comer_capr = $_POST['centro_comer_capr'] ?? '';
$universidades_capr = $_POST['universidades_capr'] ?? '';
$colegios_capr = $_POST['colegios_capr'] ?? '';
$jardines_infantiles_capr = $_POST['jardines_infantiles_capr'] ?? '';
$otros_capr = $_POST['otros_capr'] ?? '';
$jardines_capr = $_POST['jardines_capr'] ?? '';
$turco_capr = $_POST['turco_capr'] ?? '';
$jacuzzi_capr = $_POST['jacuzzi_capr'] ?? '';
$sauna_capr = $_POST['sauna_capr'] ?? '';
$cancha_tenis_capr = $_POST['cancha_tenis_capr'] ?? '';
$cancha_futbol_capr = $_POST['cancha_futbol_capr'] ?? '';
$cancha_micro_fut_capr = $_POST['cancha_micro_fut_capr'] ?? '';
$cancha_basquet_capr = $_POST['cancha_basquet_capr'] ?? '';
$piscina_adultos_capr = $_POST['piscina_adultos_capr'] ?? '';
$piscina_ninos_capr = $_POST['piscina_ninos_capr'] ?? '';
$sendero_ecol_capr = $_POST['sendero_ecol_capr'] ?? '';
$mascotas_capr = $_POST['mascotas_capr'] ?? '';
$zona_mascotas_capr = $_POST['zona_mascotas_capr'] ?? '';
$gym_capr = $_POST['gym_capr'] ?? '';
$ascensor_capr = $_POST['ascensor_capr'] ?? '';
$juegos_ninos_capr = $_POST['juegos_ninos_capr'] ?? '';
$lago_pesca_capr = $_POST['lago_pesca_capr'] ?? '';
$cancha_squash_capr = $_POST['cancha_squash_capr'] ?? '';
$otros_juegos_capr = $_POST['otros_juegos_capr'] ?? '';
$acabados_pisos_capr = $_POST['acabados_pisos_capr'] ?? '';
$acabados_muro_capr = $_POST['acabados_muro_capr'] ?? '';
$parquead_cubi_capr = $_POST['parquead_cubi_capr'] ?? '';
$parquead_descubi_capr = $_POST['parquead_descubi_capr'] ?? '';
$entradas_vehic_capr = $_POST['entradas_vehic_capr'] ?? '';
$puertas_vehic_capr = $_POST['puertas_vehic_capr'] ?? '';
$puertas_peaton_capr = $_POST['puertas_peaton_capr'] ?? '';
$frentes_inmu_capr = $_POST['frentes_inmu_capr'] ?? '';






$cod_capr                    = $_POST['cod_capr'] ?? '';
$area_total_cap            = $_POST['area_total_cap'] ?? '';
$area_piso1_cap            = $_POST['area_piso1_cap'] ?? '';
$area_piso2_cap            = $_POST['area_piso2_cap'] ?? '';
$area_sotano_cap            = $_POST['area_sotano_cap'] ?? '';
$malacate_cap              = $_POST['malacate_cap'] ?? '';
$malacate_num_cap            = $_POST['malacate_num_cap'] ?? '';
$malacate_ton_cap          = $_POST['malacate_ton_cap'] ?? '';
$area_patio_maniobra_cap   = $_POST['area_patio_maniobra_cap'] ?? '';
$otras_areas_cap            = $_POST['otras_areas_cap'] ?? '';
$forma_bodega_cap          = $_POST['forma_bodega_cap'] ?? '';
$frente_mesanine_cap       = $_POST['frente_mesanine_cap'] ?? '';
$fondo_mesanine_cap        = $_POST['fondo_mesanine_cap'] ?? '';
$frente_lote_cap           = $_POST['frente_lote_cap'] ?? '';
$fondo_lote_cap            = $_POST['fondo_lote_cap'] ?? '';
$frente_nivel1_int_cap        = $_POST['frente_nivel1_int_cap'] ?? '';
$fondo_nivel1_int_cap      = $_POST['fondo_nivel1_int_cap'] ?? '';
$frente_sotano_cap         = $_POST['frente_sotano_cap'] ?? '';
$fondo_sotano_cap          = $_POST['fondo_sotano_cap'] ?? '';
$altura_min_bodega_cap     = $_POST['altura_min_bodega_cap'] ?? '';
$altura_max_bodega_cap     = $_POST['altura_max_bodega_cap'] ?? '';
$altura_nivel_1_2_cap      = $_POST['altura_nivel_1_2_cap'] ?? '';
$altura_nivel_2_cap        = $_POST['altura_nivel_2_cap'] ?? '';
$altura_sotano_cap         = $_POST['altura_sotano_cap'] ?? '';
$altura_puerta_veh_cap     = $_POST['altura_puerta_veh_cap'] ?? '';
$ancho_puerta_veh_cap      = $_POST['ancho_puerta_veh_cap'] ?? '';
$tipo_puerta_cap           = $_POST['tipo_puerta_cap'] ?? '';
$edad_cap                  = $_POST['edad_cap'] ?? '';
$estado_bod_cap            = $_POST['estado_bod_cap'] ?? '';
$niveles_internos_cap      = $_POST['niveles_internos_cap'] ?? '';
$tipo_bodega_cap           = $_POST['tipo_bodega_cap'] ?? '';
$esquinera_medianera_cap   = $_POST['esquinera_medianera_cap'] ?? '';
$parqueaderos_cap          = $_POST['parqueaderos_cap'] ?? '';
$oficinas_cap              = $_POST['oficinas_cap'] ?? '';
$oficinas_tama_cap         = $_POST['oficinas_tama_cap'] ?? '';
$duchas_cap                = $_POST['duchas_cap'] ?? '';
$lavamanos_cap             = $_POST['lavamanos_cap'] ?? '';
$sanitarios_cap            = $_POST['sanitarios_cap'] ?? '';
$poceta_cap                = $_POST['poceta_cap'] ?? '';
$cocineta_cap              = $_POST['cocineta_cap'] ?? '';
$desagues_bodega_cap       = $_POST['desagues_bodega_cap'] ?? '';
$tipo_piso_cap             = $_POST['tipo_piso_cap'] ?? '';
$capacidad_piso_2_cap      = $_POST['capacidad_piso_2_cap'] ?? '';
$capacidad_piso_1_psi_cap  = $_POST['capacidad_piso_1_psi_cap'] ?? '';
$capacidad_piso_1_tone_cap = $_POST['capacidad_piso_1_tone_cap'] ?? '';
$capacidad_piso_1_mr_cap   = $_POST['capacidad_piso_1_mr_cap'] ?? '';
$capacidad_piso_1_fc_cap   = $_POST['capacidad_piso_1_fc_cap'] ?? '';
$material_piso_2_cap       = $_POST['material_piso_2_cap'] ?? '';
$material_piso_1_cap       = $_POST['material_piso_1_cap'] ?? '';
$material_sotano_cap       = $_POST['material_sotano_cap'] ?? '';
$acabados_muro_bode_cap    = $_POST['acabados_muro_bode_cap'] ?? '';
$material_muros_porc_cap   = $_POST['material_muros_por_cap'] ?? '';
$tipo_techo_cap            = $_POST['tipo_techo_capr'] ?? '';
$material_techo_cap        = $_POST['material_techo_capr'] ?? '';
$cod_dane_dep              = $_POST['cod_dane_dep'] ?? '';
$id_mun                     = $_POST['id_mun'] ?? '';
$sector_cap                = $_POST['sector_cap'] ?? '';
$ubicacion_gps_cap         = $_POST['ubicacion_gps_cap'] ?? '';
$estrato_cap               = $_POST['estrato_cap'] ?? '';
$posición_cap              = $_POST['posición_cap'] ?? '';
$conjunto_cerrado_cap      = $_POST['conjunto_cerrado_cap'] ?? '';
$conjunto_vigilado_cap     = $_POST['conjunto_vigilado_cap'] ?? '';
$porteria_recpecion_cap    = $_POST['porteria_recpecion_cap'] ?? '';
$energia_precio_kv_cap     = $_POST['energia_precio_kv_cap'] ?? '';
$agua_precio_m3_cap        = $_POST['agua_precio_m3_cap'] ?? '';
$empresa_energia_cap       = $_POST['empresa_energia_cap'] ?? '';
$tipo_energia_cap          = $_POST['tipo_energia_cap'] ?? '';
$kva_transformador_cap     = $_POST['kva_transformador_cap'] ?? '';
$calibre_acometida_cap     = $_POST['calibre_acometida_cap'] ?? '';
$tomas_220_cap             = $_POST['tomas_220_cap'] ?? '';
$redes_inde_cap            = $_POST['redes_inde_cap'] ?? '';
$planta_electrica_cap      = $_POST['planta_electrica_cap'] ?? '';
$empresa_agua_cap          = $_POST['empresa_agua_cap'] ?? '';
$tanques_agua_reserva_cap   = $_POST['tanques_agua_reserva_cap'] ?? '';
$tanques_capacidad_cap      = isset($_POST['tanques_capacidad_cap']) ? $_POST['tanques_capacidad_cap'] : '';
$tanques_capacidad_cap     = $_POST['tanques_capacidad_cap'] ?? '';
$hidrante_cap              = $_POST['hidrante_cap'] ?? '';
$gabinete_cont_incendio_cap = $_POST['gabinete_cont_incendio_cap'] ?? '';
$red_contra_incendios_cap  = $_POST['red_contra_incendios_cap'] ?? '';
$gas_cap                   = $_POST['gas_cap'] ?? '';
$internet_telefonia_cap = isset($_POST['internet_telefonia_cap']) ? implode(',', $_POST['internet_telefonia_cap']) : '';
$venta_neta_cap            = $_POST['venta_neta_cap'] ?? '';
$venta_m2_cap              = $_POST['venta_m2_cap'] ?? '';
$venta_total = isset($_POST['venta_total_hidden']) ? floatval($_POST['venta_total_hidden']) : 0;
$canon_neto_cap            = $_POST['canon_neto_cap'] ?? '';
$canon_m2_cap              = $_POST['canon_m2_cap'] ?? '';
$porcentaje_iva_cap        = $_POST['porcentaje_iva_cap'] ?? '';
$valor_iva_cap = isset($_POST['valor_iva_cap_hidden']) ? floatval($_POST['valor_iva_cap_hidden']) : 0;
$admon_cap                 = $_POST['admon_cap'] ?? '';
$renta_total_cap = isset($_POST['renta_total_cap_hidden']) ? floatval($_POST['renta_total_cap_hidden']) : 0;
$rte_fte_cap               = $_POST['rte_fte_cap'] ?? '';
$tractomulas_cap           = $_POST['tractomulas_cap'] ?? '';
$tractomulas_ctd_cap       = $_POST['tractomulas_ctd_cap'] ?? '';
$ctd_muelle_graduable_cap  = $_POST['ctd_muelle_graduable_cap'] ?? '';
$altura_muelle_graduable_cap = isset($_POST['altura_muelle_graduable_cap']) ? implode(',', $_POST['altura_muelle_graduable_cap']) : '';
$ctd_muelle_tractomula_cap = $_POST['ctd_muelle_tractomula_cap'] ?? '';
$tipo_muelle_tractomula_cap = isset($_POST['tipo_muelle_tractomula_cap']) ? implode(',', $_POST['tipo_muelle_tractomula_cap']) : '';
$altura_muelle_tractomula_cap = isset($_POST['altura_muelle_tractomula_cap']) ? implode(',', $_POST['altura_muelle_tractomula_cap']) : '';
$entrada_veh_directo_cap   = $_POST['entrada_veh_directo_cap'] ?? '';
$entrada_veh_ctd_cap       = $_POST['entrada_veh_ctd_cap'] ?? '';
$ampliacion_viable_cap     = $_POST['ampliacion_viable_cap'] ?? '';
$frentes_inmueble_cap      = $_POST['frentes_inmueble_cap'] ?? '';
$puertas_vehiculares_cap   = $_POST['puertas_vehiculares_cap'] ?? '';
$fotos_cap                 = $_POST['fotos_cap'] ?? '';
$videos_cap                = $_POST['videos_cap'] ?? '';
$planos_cap                = $_POST['planos_cap'] ?? '';
$uso_suelos_cap            = $_POST['uso_suelos_cap'] ?? '';
$mapas_cap                 = $_POST['mapas_cap'] ?? '';
$empresas_vecinas_cap      = $_POST['empresas_vecinas_cap'] ?? '';
$transporte_publico_cap    = $_POST['transporte_publico_cap'] ?? '';
$direccion_inm_cap         = $_POST['direccion_inm_cap'] ?? '';
$num_matricula_inm_cap     = $_POST['num_matricula_inm_cap'] ?? '';
$num_matricula_agua_cap    = $_POST['num_matricula_agua_cap'] ?? '';
$num_matricula_energia_cap = $_POST['num_matricula_energia_cap'] ?? '';
$num_matricula_gas_cap     = $_POST['num_matricula_gas_cap'] ?? '';
$nombre_razon_social_cap   = $_POST['nombre_razon_social_cap'] ?? '';
$representante_legal_cap   = $_POST['representante_legal_cap'] ?? '';
$cc_nit_repre_legal_cap    = $_POST['cc_nit_repre_legal_cap'] ?? '';
$cel_repre_legal_cap       = $_POST['cel_repre_legal_cap'] ?? '';
$tel_repre_legal_cap       = $_POST['tel_repre_legal_cap'] ?? '';
$email_repre_legal_cap     = $_POST['email_repre_legal_cap'] ?? '';
$dir_repre_legal_cap       = $_POST['dir_repre_legal_cap'] ?? '';
$remuneracion_vta_cap      = $_POST['remuneracion_vta_cap'] ?? '';
$remuneracion_renta_cap    = $_POST['remuneracion_renta_cap'] ?? '';
$obs1_cap                  = $_POST['obs1_cap'] ?? '';
$obs2_cap                  = $_POST['obs2_cap'] ?? '';
$nit_cc_ase                = $_POST['nit_cc_ase'] ?? '';
$estado_cap                = 1;
$fecha_alta_cap            = date('Y-m-d h:i:s');
$id_usu_alta_cap           = $_SESSION['id_usu'];
$fecha_edit_cap            = ('0000-00-00 00:00:00');
$id_usu                    = $_SESSION['id_usu'];
$consentimiento            = $_POST['consentimiento'] ?? '';

// Insertar en la tabla CONTRATOS
$query_contratos = "INSERT INTO capta_comercial (
    cod_cap, area_total_cap, area_piso1_cap, area_piso2_cap, area_sotano_cap, malacate_cap, malacate_num_cap, malacate_ton_cap,
    area_patio_maniobra_cap, otras_areas_cap, forma_bodega_cap, frente_mesanine_cap, fondo_mesanine_cap, frente_lote_cap, fondo_lote_cap,
    frente_nivel1_int_cap, fondo_nivel1_int_cap, frente_sotano_cap, fondo_sotano_cap, altura_min_bodega_cap, altura_max_bodega_cap,
    altura_nivel_1_2_cap, altura_nivel_2_cap, altura_sotano_cap, altura_puerta_veh_cap, ancho_puerta_veh_cap, tipo_puerta_cap, edad_cap,
    estado_bod_cap, niveles_internos_cap, tipo_bodega_cap, esquinera_medianera_cap, parqueaderos_cap, oficinas_cap, oficinas_tama_cap,
    duchas_cap, lavamanos_cap, sanitarios_cap, poceta_cap, cocineta_cap, desagues_bodega_cap, tipo_piso_cap, capacidad_piso_2_cap,
    capacidad_piso_1_psi_cap, capacidad_piso_1_tone_cap, capacidad_piso_1_mr_cap, capacidad_piso_1_fc_cap, material_piso_2_cap,
    material_piso_1_cap, material_sotano_cap, acabados_muro_bode_cap, material_muros_porc_cap, tipo_techo_cap, material_techo_cap,
    cod_dane_dep, id_mun, sector_cap, ubicacion_gps_cap, estrato_cap, posición_cap, conjunto_cerrado_cap, conjunto_vigilado_cap,
    porteria_recpecion_cap, energia_precio_kv_cap, agua_precio_m3_cap, empresa_energia_cap, tipo_energia_cap, kva_transformador_cap,
    calibre_acometida_cap, tomas_220_cap, redes_inde_cap, planta_electrica_cap, empresa_agua_cap, tanques_agua_reserva_cap,
    tanques_capacidad_cap, hidrante_cap, gabinete_cont_incendio_cap, red_contra_incendios_cap, gas_cap, internet_telefonia_cap,
    venta_neta_cap, venta_m2_cap, venta_total, canon_neto_cap, canon_m2_cap, porcentaje_iva_cap, valor_iva_cap, admon_cap, renta_total_cap, rte_fte_cap,
    tractomulas_cap, tractomulas_ctd_cap, ctd_muelle_graduable_cap, altura_muelle_graduable_cap, ctd_muelle_tractomula_cap,
    tipo_muelle_tractomula_cap, altura_muelle_tractomula_cap, entrada_veh_directo_cap, entrada_veh_ctd_cap, ampliacion_viable_cap,
    frentes_inmueble_cap, puertas_vehiculares_cap, fotos_cap, videos_cap, planos_cap, uso_suelos_cap, mapas_cap, empresas_vecinas_cap,
    transporte_publico_cap, direccion_inm_cap, num_matricula_inm_cap, num_matricula_agua_cap, num_matricula_energia_cap, num_matricula_gas_cap,
    nombre_razon_social_cap, representante_legal_cap, cc_nit_repre_legal_cap, cel_repre_legal_cap, tel_repre_legal_cap, email_repre_legal_cap,
    dir_repre_legal_cap, remuneracion_vta_cap, remuneracion_renta_cap, obs1_cap, obs2_cap, nit_cc_ase, estado_cap, fecha_alta_cap,
    id_usu_alta_cap, fecha_edit_cap, id_usu,consentimiento)
VALUES (
    '$cod_cap', '$area_total_cap', '$area_piso1_cap', '$area_piso2_cap', '$area_sotano_cap', '$malacate_cap', '$malacate_num_cap',
    '$malacate_ton_cap', '$area_patio_maniobra_cap', '$otras_areas_cap', '$forma_bodega_cap', '$frente_mesanine_cap', '$fondo_mesanine_cap',
    '$frente_lote_cap', '$fondo_lote_cap', '$frente_nivel1_int_cap', '$fondo_nivel1_int_cap', '$frente_sotano_cap', '$fondo_sotano_cap',
    '$altura_min_bodega_cap', '$altura_max_bodega_cap', '$altura_nivel_1_2_cap', '$altura_nivel_2_cap', '$altura_sotano_cap', '$altura_puerta_veh_cap',
    '$ancho_puerta_veh_cap', '$tipo_puerta_cap', '$edad_cap', '$estado_bod_cap', '$niveles_internos_cap', '$tipo_bodega_cap',
    '$esquinera_medianera_cap', '$parqueaderos_cap', '$oficinas_cap', '$oficinas_tama_cap', '$duchas_cap', '$lavamanos_cap', '$sanitarios_cap',
    '$poceta_cap', '$cocineta_cap', '$desagues_bodega_cap', '$tipo_piso_cap', '$capacidad_piso_2_cap', '$capacidad_piso_1_psi_cap',
    '$capacidad_piso_1_tone_cap', '$capacidad_piso_1_mr_cap', '$capacidad_piso_1_fc_cap', '$material_piso_2_cap', '$material_piso_1_cap',
    '$material_sotano_cap', '$acabados_muro_bode_cap', '$material_muros_porc_cap', '$tipo_techo_cap', '$material_techo_cap', '$cod_dane_dep',
    '$id_mun', '$sector_cap', '$ubicacion_gps_cap', '$estrato_cap', '$posición_cap', '$conjunto_cerrado_cap', '$conjunto_vigilado_cap',
    '$porteria_recpecion_cap', '$energia_precio_kv_cap', '$agua_precio_m3_cap', '$empresa_energia_cap', '$tipo_energia_cap',
    '$kva_transformador_cap', '$calibre_acometida_cap', '$tomas_220_cap', '$redes_inde_cap', '$planta_electrica_cap', '$empresa_agua_cap',
    '$tanques_agua_reserva_cap', '$tanques_capacidad_cap', '$hidrante_cap', '$gabinete_cont_incendio_cap', '$red_contra_incendios_cap',
    '$gas_cap', '$internet_telefonia_cap', '$venta_neta_cap', '$venta_m2_cap', '$venta_total', '$canon_neto_cap', '$canon_m2_cap', '$porcentaje_iva_cap',
    '$valor_iva_cap', '$admon_cap', '$renta_total_cap', '$rte_fte_cap', '$tractomulas_cap', '$tractomulas_ctd_cap', '$ctd_muelle_graduable_cap',
    '$altura_muelle_graduable_cap', '$ctd_muelle_tractomula_cap', '$tipo_muelle_tractomula_cap', '$altura_muelle_tractomula_cap',
    '$entrada_veh_directo_cap', '$entrada_veh_ctd_cap', '$ampliacion_viable_cap', '$frentes_inmueble_cap', '$puertas_vehiculares_cap',
    '$fotos_cap', '$videos_cap', '$planos_cap', '$uso_suelos_cap', '$mapas_cap', '$empresas_vecinas_cap', '$transporte_publico_cap',
    '$direccion_inm_cap', '$num_matricula_inm_cap', '$num_matricula_agua_cap', '$num_matricula_energia_cap', '$num_matricula_gas_cap',
    '$nombre_razon_social_cap', '$representante_legal_cap', '$cc_nit_repre_legal_cap', '$cel_repre_legal_cap', '$tel_repre_legal_cap',
    '$email_repre_legal_cap', '$dir_repre_legal_cap', '$remuneracion_vta_cap', '$remuneracion_renta_cap', '$obs1_cap', '$obs2_cap',
    '$nit_cc_ase', '$estado_cap', '$fecha_alta_cap', '$id_usu_alta_cap', '$fecha_edit_cap', '$id_usu' ,'$consentimiento')";

if (mysqli_query($mysqli, $query_contratos)) {
    echo "Inserción exitosa.";
} else {
    echo "Error al insertar los datos: " . mysqli_error($mysqli);
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
                            <p align='center'><a href='showprecap.php'><img src='../../img/atras.png' width=96 height=96></a></p>
                        </div>
                        </center>
                    </body>
                </html>
            ";
