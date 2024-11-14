<aside class="app-navbar">
  <div class="sidebar-nav scrollbar scroll_light">
    <ul class="metismenu " id="sidebarNav">
      <li class="nav-static-title" style="color:#06d809;">Menú de Navegación</li>
      <br>
      <li id="menuinicio">
        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
          <i class="nav-icon fa fa-dashboard"></i>
          <span class="nav-title">Inicio</span>
        </a>
        <ul aria-expanded="false">
          <li id="menumyprofile"> <a href='?view=myprofile'>Mi Perfil</a> </li>
          <li id="menuchangepassword"> <a href='?view=changepassword'>Cambiar Contraseña</a> </li>
          <li id="menu"> <a href='?view=logout'>Cerrar Sesión</a> </li>
        </ul>
      </li>

      <?php

      $flag_mostar_menu = false;
      $flag_mybusiness = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("mybusiness"));
      $flag_fundos = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("sucursales"));
      $flag_monedas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("monedas"));
      $flag_identitydocuments = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("identitydocuments"));
      $flag_tiposervicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tiposervicio"));
      $flag_tipogasto = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipogasto"));
      $flag_tipocosecha = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipocosecha"));
      if ($flag_mybusiness || $flag_tipogasto || $flag_fundos || $flag_monedas || $flag_identitydocuments || $flag_tiposervicio || $flag_tipocosecha) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menuconfiguration">
          <a class="has-arrow" href="#" aria-expanded="false">
            <i class="nav-icon fa fa-cog"></i>
            <span class="nav-title">Configuración</span>
          </a>
          <ul aria-expanded="false">
            <?php if ($flag_mybusiness): ?>
              <li id="menumybusiness"><a href="?view=mybusiness">Mi Empresa</a></li>
            <?php endif; ?>
            <?php if ($flag_fundos): ?>
              <li id="menusucursales"><a href="?view=sucursales">Fundos</a></li>
            <?php endif; ?>
            <?php if ($flag_monedas): ?>
              <li id="menumonedas"><a href="?view=monedas">Monedas</a></li>
            <?php endif; ?>
            <?php if ($flag_identitydocuments): ?>
              <li id="menuidentitydocuments"> <a href="?view=identitydocuments">Documentos de Identidad</a> </li>
            <?php endif; ?>
            <?php if ($flag_tiposervicio): ?>
              <li id="menutiposervicio"> <a href="?view=tiposervicio">Tipos de Servicio</a> </li>
            <?php endif; ?>
            <?php if ($flag_tipogasto): ?>
              <li id="menutipogasto"> <a href="?view=tipogasto">Tipos de Productos</a> </li>
            <?php endif; ?>
            <?php if ($flag_tipocosecha): ?>
              <li id="menutipocosecha"> <a href="?view=tipocosecha">Tipos de Cosecha</a> </li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>


      <?php

      $flag_mostar_menu = false;
      $flag_cliente = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("cliente"));
      $flag_servicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("servicio"));
      $flag_operador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("operador"));
      $flag_proveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("proveedor"));
      $flag_maquinaria = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("maquinaria"));
      $flag_gasto = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("gasto"));
      $flag_accesofundo = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesofundo"));
      if ($flag_cliente || $flag_servicio || $flag_operador || $flag_proveedor || $flag_maquinaria || $flag_gasto || $flag_accesofundo) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menumantenimiento">
          <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
            <i class="nav-icon fa fa-database"></i>
            <span class="nav-title">Mantenimiento</span>
          </a>
          <ul aria-expanded="false">
            <?php if ($flag_cliente): ?>
              <li id="menucliente"> <a href="?view=cliente">Clientes</a> </li>
            <?php endif; ?>
            <?php if ($flag_servicio): ?>
              <li id="menuservicio"> <a href="?view=servicio">Servicios</a> </li>
            <?php endif; ?>
            <?php if ($flag_operador): ?>
              <li id="menuoperador"> <a href="?view=operador">Operadores</a> </li>
            <?php endif; ?>
            <?php if ($flag_proveedor): ?>
              <li id="menuproveedor"> <a href="?view=proveedor">Proveedores</a> </li>
            <?php endif; ?>
            <?php if ($flag_maquinaria): ?>
              <li id="menumaquinaria"> <a href="?view=maquinaria">Maquinarias</a> </li>
            <?php endif; ?>
            <?php if ($flag_gasto): ?>
              <li id="menugasto"> <a href="?view=gasto">Productos</a> </li>
            <?php endif; ?>
            <?php if ($flag_accesofundo): ?>
              <li id="menuaccesofundo"> <a href="?view=accesosfundo">Accesos a Fundos</a> </li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>

      <?php

      $flag_mostar_menu = false;
      $flag_grupousuario = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("grupousuario"));
      $flag_accesogrupo = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesogrupo"));
      $flag_trabajador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("trabajador"));
      if ($flag_grupousuario || $flag_accesogrupo || $flag_trabajador) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menuseguridad">
          <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
            <i class="nav-icon fa fa-shield"></i>
            <span class="nav-title">Seguridad</span>
          </a>
          <ul aria-expanded="false">
            <?php if ($flag_grupousuario): ?>
              <li id="menugrupousuario"> <a href="?view=grupousuario">Grupos de Usuario</a> </li>
            <?php endif; ?>
            <?php if ($flag_accesogrupo): ?>
              <li id="menuaccesogrupo"> <a href="?view=accesogrupo">Accesos a Opciones</a> </li>
            <?php endif; ?>
            <?php if ($flag_trabajador): ?>
              <li id="menutrabajador"> <a href="?view=trabajador">Trabajadores</a> </li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>

      <?php

      $flag_mostar_menu = false;
      $flag_ordenventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordenventa"));
      $flag_ordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordencompra"));
      $flag_promocion = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("promocion"));
      $flag_ingreso = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ingreso"));
      $flag_ordengasto = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordengasto"));
      if ($flag_ordenventa || $flag_ordencompra || $flag_promocion || $flag_ingreso || $flag_ordengasto) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menuoperaciones">
          <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
            <i class="nav-icon fa fa-cog"></i>
            <span class="nav-title">Operaciones</span>
          </a>
          <ul aria-expanded="false">
            <?php if ($flag_ordencompra): ?>
              <li id="submenuordencompra"><a href="?view=ordencompra">Orden de Compra</a></li>
            <?php endif; ?>
            <?php if ($flag_ordengasto): ?>
              <li id="submenuordengasto"> <a href="?view=ordengasto">Registro de Gastos</a></li>
            <?php endif; ?>
            <?php if ($flag_ordenventa): ?>
              <li id="submenucronograma"><a href="?view=ordenventa">Cronograma de Cosechas</a></li>
            <?php endif; ?>
            <!-- <?php if ($flag_promocion): ?>
              <li id="submenupromocion"> <a href="?view=promocion">Promociones de Clientes</a></li>
            <?php endif; ?>
            <?php if ($flag_ordengasto): ?>
              <li id="submenuordengasto"> <a href="?view=ordengasto">Orden de Gastos</a></li>
            <?php endif; ?> -->
          </ul>
        </li>

      <?php endif; ?>



      <?php

      $flag_mostar_menu = false;
      $flag_vistareporteordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteordencompra"));
      $flag_vistareporteordenventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteordenventa"));
      $flag_vistareporteaccesorios = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteaccesorios"));
      $flag_observacionesproveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("observacionesproveedor"));
      if ($flag_vistareporteordencompra || $flag_vistareporteordenventa || $flag_vistareporteaccesorios || $flag_observacionesproveedor) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menureportes">
          <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
            <i class="nav-icon fa fa-list"></i>
            <span class="nav-title">Reportes</span>
          </a>
          <ul aria-expanded="false">
            <!-- <?php if ($flag_vistareporteordencompra): ?>
              <li id="submenureporteordencompra"><a href="?view=vistareporteordencompra">Compras</a></li>
            <?php endif; ?>
            <?php if ($flag_vistareporteordenventa): ?>
              <li id="submenureporteordenventa"><a href="?view=vistareporteordenventa">Ventas</a></li>
            <?php endif; ?>
            <?php if ($flag_vistareporteaccesorios): ?>
              <li id="submenureporteaccesorio"><a href="?view=vistareporteaccesorios">Productos</a></li>
            <?php endif; ?>
            <?php if ($flag_observacionesproveedor): ?>
              <li id="submenuobservacionesproveedor"><a href="?view=observacionesproveedor">Observaciones de Proveedor</a>
              </li>
            <?php endif; ?> -->
          </ul>
        </li>

      <?php endif; ?>

    </ul>
  </div>
</aside>