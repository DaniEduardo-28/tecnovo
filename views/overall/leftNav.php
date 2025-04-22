<aside class="app-navbar">
  <div class="sidebar-nav scrollbar scroll_light">
    <ul class="metismenu " id="sidebarNav">
      <li class="nav-static-title" style="color:#f7440c;">Menú de Navegación</li>
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
      $flag_sucursales = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("sucursales"));
      $flag_monedas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("monedas"));
      $flag_accesorio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesorio"));
      $flag_identitydocuments = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("identitydocuments"));
      $flag_formapago = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("formapago"));
      $flag_tipocambio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipocambio"));
      $flag_unidadmedida = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("unidadmedida"));
      if ($flag_mybusiness || $flag_sucursales || $flag_monedas || $flag_identitydocuments ||  $flag_formapago || $flag_tipocambio || $flag_unidadmedida || $flag_accesorio ) {
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
            <?php if ($flag_sucursales): ?>
              <li id="menusucursales"><a href="?view=sucursales">Sucursales</a></li>
            <?php endif; ?>
            <?php if ($flag_monedas): ?>
              <li id="menumonedas"><a href="?view=monedas">Tipo de Moneda</a></li>
            <?php endif; ?>
            <?php if ($flag_identitydocuments): ?>
              <li id="menuidentitydocuments"> <a href="?view=identitydocuments">Documentos de Identidad</a> </li>
            <?php endif; ?>
            <?php if ($flag_formapago): ?>
              <li id="menuformapago"> <a href="?view=formapago">Métodos de Pago</a> </li>
            <?php endif; ?>
            <?php if ($flag_tipocambio): ?>
              <li id="menutipocambio"> <a href="?view=tipocambio">Tipo de Cambio</a> </li>
            <?php endif; ?>
            <?php if ($flag_unidadmedida): ?>
              <li id="menuunidadmedida"> <a href="?view=unidadmedida">Unidades de Medida</a></li>
            <?php endif; ?>
            <?php if ($flag_accesorio): ?>
              <li id="menuaccesorio"> <a href="?view=accesorio">Productos</a> </li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>


      <?php

      $flag_mostar_menu = false;
      $flag_proveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("proveedor"));
      $flag_accesofundo = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesofundo"));
      $flag_trabajador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("trabajador"));
      if ($flag_proveedor || $flag_trabajador ) {
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
            <?php if ($flag_trabajador): ?>
              <li id="menutrabajador"> <a href="?view=trabajador">Trabajadores</a> </li>
            <?php endif; ?>
            <?php if ($flag_proveedor): ?>
              <li id="menuproveedor"> <a href="?view=proveedor">Proveedores</a> </li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>


      <?php

      $flag_mostar_menu = false;
      $flag_grupousuario = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("grupousuario"));
      $flag_accesogrupo = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesogrupo"));
      $flag_accesosucursal = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesosucursal"));
      $flag_trabajador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("trabajador"));
      if ($flag_grupousuario || $flag_accesogrupo || $flag_accesosucursal || $flag_trabajador) {
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
              <li id="menuaccesogrupo"> <a href="?view=accesogrupo">Acceos a Opciones</a> </li>
            <?php endif; ?>
            <?php if ($flag_accesosucursal): ?>
              <li id="menuaccesosucursal"> <a href="?view=accesosucursal">Acceos a Sucursales</a> </li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>

      <?php

      $flag_mostar_menu = false;
      $flag_ordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordencompra"));
      $flag_ingreso = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ingreso"));

      if ($flag_ordencompra || $flag_ingreso) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menuoperaciones">
          <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
            <i class="nav-icon fa fa-cogs"></i>
            <span class="nav-title">Operaciones</span>
          </a>
          <ul aria-expanded="false">
            <?php if ($flag_ordencompra): ?>
              <li id="submenuordencompra"><a href="?view=ordencompra">Ordenes de Compra</a></li>
            <?php endif; ?>
            <?php if ($flag_ingreso): ?>
              <li id="submenuingreso"> <a href="?view=ingreso">Ingreso de Productos</a></li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>



      <?php

      $flag_mostar_menu = false;
      $flag_vistareporteordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteordencompra"));
      $flag_vistareporteaccesorios = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteaccesorios"));
      if ($flag_vistareporteordencompra || $flag_vistareporteaccesorios) {
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
            <?php if ($flag_vistareporteordencompra): ?>
              <li id="submenureporteordencompra"><a href="?view=vistareporteordencompra">Compras</a></li>
            <?php endif; ?>
            <?php if ($flag_vistareporteaccesorios): ?>
              <li id="submenureporteaccesorio"><a href="?view=vistareporteaccesorios">Productos</a></li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>

    </ul>
  </div>
</aside>