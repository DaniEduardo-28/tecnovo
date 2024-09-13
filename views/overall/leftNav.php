<aside class="app-navbar">
  <div class="sidebar-nav scrollbar scroll_light">
      <ul class="metismenu " id="sidebarNav">
          <li class="nav-static-title" style="color:#f2dff0;">Menú de Navegación</li>
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
            $flag_mybusiness = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("mybusiness"));
            $flag_fundos = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("sucursales"));
            $flag_monedas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("monedas"));
            $flag_identitydocuments = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("identitydocuments"));
            $flag_tiposervicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("tiposervicio"));
           if ($flag_mybusiness || $flag_fundos || $flag_monedas || $flag_identitydocuments || $flag_tiposervicio|| $flag_tipocambio) {
          		$flag_mostar_menu = true;
          	}else{
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
                </ul>
            </li>

          <?php endif; ?>


          <?php

            $flag_mostar_menu = false;
            $flag_cliente = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("cliente"));
            $flag_proveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("proveedor"));
            $flag_servicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("servicio"));
            if ($flag_proveedor || $flag_cliente || $flag_servicio) {
          		$flag_mostar_menu = true;
          	}else{
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
                    <?php if ($flag_proveedor): ?>
                      <li id="menuproveedor"> <a href="?view=proveedor">Proveedores</a> </li>
                    <?php endif; ?>
                    <?php if ($flag_servicio): ?>
                      <li id="menuservicio"> <a href="?view=servicio">Servicios</a> </li>
                    <?php endif; ?>
                </ul>
            </li>

          <?php endif; ?>

          <?php

              $flag_mostar_menu = false;
              $flag_accesosucursal = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("accesosucursal"));
              if ($flag_accesosucursal) {
                $flag_mostar_menu = true;
              }else{
                $flag_mostar_menu = false;
              }

          ?>

          <?php if ($flag_mostar_menu): ?>

            <li id="menuseguridad">
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                  <i class="nav-icon fa fa-shield"></i>
                  <span class="nav-title">Fundos por clientes</span>
                </a>
                <ul aria-expanded="false">
                    <?php if ($flag_accesosucursal): ?>
                      <li id="menuaccesosucursal"> <a href="?view=accesosucursal">Accesos a Fundos</a> </li>
                    <?php endif; ?>
                </ul>
            </li>

          <?php endif; ?>

          <?php

            $flag_mostar_menu = false;
            $flag_grupousuario = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("grupousuario"));
            $flag_accesogrupo = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("accesogrupo"));
            $flag_trabajador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("trabajador"));
            if ($flag_grupousuario || $flag_accesogrupo || $flag_trabajador) {
          		$flag_mostar_menu = true;
          	}else{
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
            $flag_citas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("citas"));
            $flag_atencioncitas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("atencioncitas"));
            $flag_historialclinico = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("historialclinico"));
            if ($flag_citas || $flag_atencioncitas || $flag_historialclinico) {
          		$flag_mostar_menu = true;
          	}else{
          		$flag_mostar_menu = false;
          	}

          ?>

          <?php if ($flag_mostar_menu): ?>

            <li id="menucitas">
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                  <i class="nav-icon fa fa-calendar"></i>
                  <span class="nav-title">Citas</span>
                </a>
                <ul aria-expanded="false">
                    <?php if ($flag_citas): ?>
                      <li id="submenucitas"> <a href="?view=citas">Gestionar Citas</a></li>
                    <?php endif; ?>
                    <?php if ($flag_atencioncitas): ?>
                      <li id="submenuatencioncitas"> <a href="?view=atencioncitas">Atención de Citas</a></li>
                    <?php endif; ?>
                    <?php if ($flag_historialclinico): ?>
                      <li id="submenuhistorialclinico"> <a href="?view=historialclinico">Historial Clínico</a></li>
                    <?php endif; ?>
                </ul>
            </li>

          <?php endif; ?>



          <?php

            $flag_mostar_menu = false;
            $flag_fichamascota = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("fichamascota"));
            $flag_ordenventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("ordenventa"));
            $flag_ordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("ordencompra"));
            $flag_promocion = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("promocion"));
            $flag_ingreso = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("ingreso"));
            if ($flag_fichamascota || $flag_ordenventa || $flag_ordencompra || $flag_promocion || $flag_ingreso) {
          		$flag_mostar_menu = true;
          	}else{
          		$flag_mostar_menu = false;
          	}

          ?>

          <?php if ($flag_mostar_menu): ?>

            <li id="menuoperaciones">
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                  <i class="nav-icon fa fa-paw"></i>
                  <span class="nav-title">Operaciones</span>
                </a>
                <ul aria-expanded="false">
                  <?php if ($flag_fichamascota): ?>
                    <li id="submenufichamascota"><a href="?view=fichamascota">Ficha de Mascotas y Vacunas</a></li>
                  <?php endif; ?>
                  <?php if ($flag_ordencompra): ?>
                    <li id="submenuordencompra"><a href="?view=ordencompra">Ordenes de Compra</a></li>
                  <?php endif; ?>
                  <?php if ($flag_ingreso): ?>
                    <li id="submenuingreso"> <a href="?view=ingreso">Ingreso de Productos</a></li>
                  <?php endif; ?>
                  <?php if ($flag_ordenventa): ?>
                    <li id="submenuordenventa"><a href="?view=ordenventa">Ordenes de venta</a></li>
                  <?php endif; ?>
                  <?php if ($flag_promocion): ?>
                    <li id="submenupromocion"> <a href="?view=promocion">Promociones de Clientes</a></li>
                  <?php endif; ?>
                </ul>
            </li>

          <?php endif; ?>



          <?php

            $flag_mostar_menu = false;
            $flag_vistareporteordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareporteordencompra"));
            $flag_vistareporteordenventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareporteordenventa"));
            $flag_vistareporteaccesorios = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareporteaccesorios"));
            $flag_vistareportemedicamentos = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("vistareportemedicamentos"));
            $flag_observacionesproveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'],printCodeOption("observacionesproveedor"));
            if ($flag_vistareporteordencompra || $flag_vistareporteordenventa || $flag_vistareporteaccesorios || $flag_vistareportemedicamentos || $flag_observacionesproveedor) {
          		$flag_mostar_menu = true;
          	}else{
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
                  <?php if ($flag_vistareporteordenventa): ?>
                    <li id="submenureporteordenventa"><a href="?view=vistareporteordenventa">Ventas</a></li>
                  <?php endif; ?>
                  <?php if ($flag_vistareporteaccesorios): ?>
                    <li id="submenureporteaccesorio"><a href="?view=vistareporteaccesorios">Accesorios</a></li>
                  <?php endif; ?>
                  <?php if ($flag_vistareportemedicamentos): ?>
                    <li id="submenureportemedicamentos"><a href="?view=vistareportemedicamentos">Medicamentos</a></li>
                  <?php endif; ?>
                  <?php if ($flag_observacionesproveedor): ?>
                    <li id="submenuobservacionesproveedor"><a href="?view=observacionesproveedor">Observaciones de Proveedor</a></li>
                  <?php endif; ?>
                </ul>
            </li>

          <?php endif; ?>

      </ul>
  </div>
</aside>
