<?php
    session_start();

    if(!isset($_SESSION['id_usu'])){
        header("Location: index.php");
    }

    $usuario      = $_SESSION['usuario'];
    $nombre       = $_SESSION['nombre'];
    $tipo_usu     = $_SESSION['tipo_usu'];

?>

<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" defer></script>

    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <title>VISION | SOFT</title>
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="menu/style.css" />
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar">
      <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <img src="img/logo.png" alt=""></i>SOFT | VISION INMOBILIARIA
      </div>

      <!--<div class="search_bar">
        <input type="text" placeholder="Buscar..." />
      </div>-->

      <div class="navbar_content">
        <i class="bi bi-grid"></i>
        <i class="fa-solid fa-sun" id="darkLight"></i><!--<i class='bx bx-sun' id="darkLight"></i>-->
        <a href="logout.php"> <i class="fa-solid fa-door-open"></i></a>
        <img src="img/logo.png" alt="" class="profile" />
      </div>
    </nav>

    <!--************************INICIA MENÚ ADMINISTRADOR************************-->

    <?php if($tipo_usu == 1) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <!--<li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-tree-city"></i>
              </span>
              <span class="navlink">Municipios</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/cities/addcity.php" class="nav_link sublink">Ingresar</a>
              <a href="code/cities/showcity.php" class="nav_link sublink">Consultar</a>

            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-school"></i>
              </span>
              <span class="navlink">Colegios</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/school/addschool.php" class="nav_link sublink">Ingresar</a>
              <a href="code/school/showschool.php" class="nav_link sublink">Consultar</a>

            </ul>
          </li>-->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-address-card"></i>
              </span>
              <span class="navlink">Propietarios</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/pro/addpro.php" class="nav_link sublink">Ingresar Propietario</a>
              <a href="code/pro/showpro.php" class="nav_link sublink">Consultar Propietario</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-city"></i>
              </span>
              <span class="navlink">Propiedades</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/inm/addinm.php" class="nav_link sublink">Nuevo Inmueble</a>
              <a href="code/inm/showinm.php" class="nav_link sublink">Consultar Inmueble</a>
              <a href="code/prop/addprop.php" class="nav_link sublink">Relacionar Propiedad</a>
              <a href="code/prop/showprop.php" class="nav_link sublink">Consultar Propiedad</a>
            </ul>
          </li>


          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-user-group"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Arrendatarios</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/arr/addarr.php" class="nav_link sublink">Ingresar</a>
              <a href="code/arr/showarr.php" class="nav_link sublink">Consultar</a>
              <a href="code/arr/addcod.php" class="nav_link sublink">Ingresar Deudor Solidario</a>
              <a href="code/arr/showcod.php" class="nav_link sublink">Consultar Deudor Solidario</a>

            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-money-bill-transfer"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Afianzadora</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/fia/addfia.php" class="nav_link sublink">Ingresar</a>
              <a href="code/fia/showfia.php" class="nav_link sublink">Consultar</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-pen-to-square"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Contratos</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/cont/addcont.php" class="nav_link sublink">Ingresar</a>
              <a href="code/cont/showcont.php" class="nav_link sublink">Consultar</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class='fa-solid fa-money-check-dollar'></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Pagos</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/pag/showpay.php" class="nav_link sublink">Consultar</a>
            </ul>
             <ul class="menu_items submenu">
              <a href="code/pag/receivables.php" class="nav_link sublink">Cuentas por cobrar</a>
            </ul>
    </li>
    <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class='fa-solid fa-money-check-dollar'></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Comisiones Pendientes</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/pag/showPendingPays.php" class="nav_link sublink">Consultar</a>

            </ul>
    </li>


          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <strong>Formatos-></strong>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-people-roof"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Asesores</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/ase/addase.php" class="nav_link sublink">Ingresar</a>
              <a href="code/ase/showase.php" class="nav_link sublink">Consultar</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-store"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Exhibiciones</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/exh/addexh.php" class="nav_link sublink">Constancia Exhibición</a>
              <a href="code/exh/showexhpre.php" class="nav_link sublink">Preregistro</a>
              <a href="code/exh/showexh.php" class="nav_link sublink">Consultar</a>
              <a href="code/exh/reports/menuReport.php" class="nav_link sublink">Informes</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-building-circle-check"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Captación</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/cap/addcap.php" class="nav_link sublink">Pre-Registro Ficha Comercial</a>
              <a href="code/cap/addcap2.php" class="nav_link sublink">Ficha General Comercial</a>
              <a href="code/cap/showprecap.php" class="nav_link sublink">Ver Registro F. Comercial</a>
              <a href="code/cap/addcapr.php" class="nav_link sublink">Ficha Téc. Residencial</a>
              <a href="code/cap/showFichaTec.php" class="nav_link sublink">Ver Fichas Téc. Residenciales</a>

              <a href="code/cap/preResidencial.php" class="nav_link sublink">Pre-Registro Ficha Residencial</a>
            </ul>
          </li>

          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <?php } ?>


<!--************************MENÚ ENCUESTAS DE CAMPO************************-->
    <?php if($tipo_usu == 2) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <strong>Formatos-></strong>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-people-roof"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Asesores</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/ase/addase.php" class="nav_link sublink">Ingresar</a>
              <a href="code/ase/showase.php" class="nav_link sublink">Consultar</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-store"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Exhibiciones</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/exh/addexh.php" class="nav_link sublink">Constancia Exhibición</a>
              <a href="code/exh/showexhpre.php" class="nav_link sublink">Preregistro</a>
              <a href="code/exh/showexh.php" class="nav_link sublink">Consultar</a>
              <a href="code/exh/reports/menuReport.php" class="nav_link sublink">Informes</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
               <i class="fa-solid fa-building-circle-check"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Captación</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/cap/addcap.php" class="nav_link sublink">Pre-Registro Ficha Comercial</a>
              <a href="code/cap/addcap2.php" class="nav_link sublink">Ficha General Comercial</a>
              <a href="code/cap/showprecap.php" class="nav_link sublink">Continuar Registro F. Comercial</a>
              <a href="code/cap/addcapr.php" class="nav_link sublink">Ficha Téc. Residencial</a>
              <a href="code/cap/showprecapr.php" class="nav_link sublink">Pre-Registro Ficha Residencial</a>
            </ul>
          </li>

          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>
        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <?php } ?>

<!--************************MENÚ VENTANILLA - NUEVA - MOVIMIENTOS************************-->

    <?php if($tipo_usu == 3) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-building-circle-check"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Ventanilla</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/eventan/addsurvey1.php" class="nav_link sublink">Nueva Encuesta</a>
              <a href="code/emovim/addsurvey1.php" class="nav_link sublink">Movimientos</a>
              <a href="code/einfo/addsurvey1.php" class="nav_link sublink">Información</a>
            </ul>
          </li>
          <!-- end -->

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-magnifying-glass"></i>
              </span>
              <span class="navlink">Editar Encuesta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/eventan/showsurvey.php" class="nav_link sublink">Encue. Nueva</a>
              <a href="code/emovim/showsurvey.php" class="nav_link sublink">Movimientos</a>
              <a href="code/einfo/showsurvey.php" class="nav_link sublink">Información</a>
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-chart-pie"></i>
              </span>
              <span class="navlink">Descargue</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/eventan/report/report1.php" class="nav_link sublink">Informes</a>
            </ul>
          </li>
          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
              <!--<a href="#" class="nav_link sublink">Nav Sub Link</a>
              <a href="#" class="nav_link sublink">Nav Sub Link</a>
              <a href="#" class="nav_link sublink">Nav Sub Link</a>-->
            </ul>
          </li>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <?php } ?>

<!--***************MENÚ UNIVERSIDADES**************-->

    <?php if($tipo_usu == 4) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-tree-city"></i>
                <!--<i class="bx bx-home-alt"></i>-->
              </span>

              <span class="navlink">Universidades</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/university/showuniversity.php" class="nav_link sublink">Consultar</a>
            </ul>
          </li>

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-folder-plus"></i>
              </span>
              <span class="navlink">Renovaciones</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/academy/addterm.php" class="nav_link sublink">Registrar Semestre</a>
              <a href="code/academy/showterm.php" class="nav_link sublink">Estudiante Activo</a>
              <a href="code/academy/showinactive.php" class="nav_link sublink">Estudiante Inactivo</a>
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-chart-pie"></i>
              </span>
              <span class="navlink">Informes</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/reports/showgroup.php" class="nav_link sublink">Consultar Grupos</a>
            </ul>
          </li>


          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <?php } ?>

<!--***************MENÚ SUPERVISOR CAMPO**************-->

    <?php if($tipo_usu == 5) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-magnifying-glass"></i>
              </span>
              <span class="navlink">Supervisión</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/supervisor/campo/showEncCampo.php" class="nav_link sublink">Campo</a>
              <!--<a href="code/users/addsurvey.php" class="nav_link sublink">Nueva</a>
              <a href="code/users//addsurvey.php" class="nav_link sublink">Movimientos</a>
              <a href="code/users/addsurvey.php" class="nav_link sublink">Información</a>
              <a href="code/users/addsurvey.php" class="nav_link sublink">Portal Ciudadano</a>-->
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-chart-pie"></i>
              </span>
              <span class="navlink">Informes</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/report/report1.php" class="nav_link sublink">Campo</a>
            </ul>
          </li>


          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <?php } ?>

<!--***************MENÚ SUPERVISOR VENTANILLA**************-->

    <?php if($tipo_usu == 6) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <!-- duplicate or remove this li tag if you want to add or remove navlink with submenu -->
          <!-- start -->

          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-magnifying-glass"></i>
              </span>
              <span class="navlink">Supervisión</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/supervisor/ventan/showEncVentanilla.php" class="nav_link sublink">Ventanilla</a>
              <!--<a href="code/users/addsurvey.php" class="nav_link sublink">Nueva</a>
              <a href="code/users//addsurvey.php" class="nav_link sublink">Movimientos</a>
              <a href="code/users/addsurvey.php" class="nav_link sublink">Información</a>
              <a href="code/users/addsurvey.php" class="nav_link sublink">Portal Ciudadano</a>-->
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-chart-pie"></i>
              </span>
              <span class="navlink">Informes</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="code/report/report7.php" class="nav_link sublink">Ventanilla</a>
            </ul>
          </li>


          <!-- duplicate this li tag if you want to add or remove  navlink with submenu -->
          <!-- start -->
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>

        <!-- Sidebar Open / Close -->
        <div class="bottom_content">
          <div class="bottom expand_sidebar">
            <span> Expand</span>
            <i class='bx bx-log-in' ></i>
          </div>
          <div class="bottom collapse_sidebar">
            <span> Collapse</span>
            <i class='bx bx-log-out'></i>
          </div>
        </div>
      </div>
    </nav>
    <?php } ?>


    <!-- JavaScript -->
    <script src="menu/script.js"></script>
  </body>
</html>
