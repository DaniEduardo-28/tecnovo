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
      $flag_mybusiness = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("mybusiness"));
      $flag_sucursales = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("sucursales"));
      $flag_monedas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("monedas"));
      $flag_identitydocuments = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("identitydocuments"));
      $flag_especialidad = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("especialidad"));
      $flag_categoriaaccesorio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("categoriaaccesorio"));
      $flag_tiposervicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tiposervicio"));
      $flag_tipomascota = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipomascota"));
      $flag_tipomedicamento = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipomedicamento"));
      $flag_formapago = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("formapago"));
      $flag_tipocambio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipocambio"));
      $flag_tipocosecha = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("tipocosecha"));
      $flag_documentoventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("documentoventa"));
      $flag_unidadmedida = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("unidadmedida"));
      $flag_metodoenvio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("metodoenvio"));
      if ($flag_mybusiness || $flag_sucursales || $flag_monedas || $flag_identitydocuments || $flag_especialidad || $flag_categoriaaccesorio || $flag_tiposervicio || $flag_tipomascota || $flag_tipomedicamento || $flag_formapago || $flag_tipocambio || $flag_tipocosecha || $flag_documentoventa || $flag_unidadmedida || $flag_metodoenvio) {
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
              <li id="menumonedas"><a href="?view=monedas">Monedas</a></li>
            <?php endif; ?>
            <?php if ($flag_identitydocuments): ?>
              <li id="menuidentitydocuments"> <a href="?view=identitydocuments">Documentos de Identidad</a> </li>
            <?php endif; ?>
            <?php if ($flag_especialidad): ?>
              <li id="menuespecialidad"> <a href="?view=especialidad">Cargos usuarios</a> </li>
            <?php endif; ?>
            <?php if ($flag_categoriaaccesorio): ?>
              <li id="menucategoriaaccesorio"> <a href="?view=categoriaaccesorio">Categorias de Productos</a> </li>
            <?php endif; ?>
            <?php if ($flag_tiposervicio): ?>
              <li id="menutiposervicio"> <a href="?view=tiposervicio">Tipos de Servicio</a> </li>
            <?php endif; ?>
            <?php if ($flag_formapago): ?>
              <li id="menuformapago"> <a href="?view=formapago">Métodos de Pago</a> </li>
            <?php endif; ?>
            <?php if ($flag_tipocambio): ?>
              <li id="menutipocambio"> <a href="?view=tipocambio">Tipo de Cambio</a> </li>
            <?php endif; ?>
            <?php if ($flag_tipocosecha): ?>
              <li id="menutipocosecha"> <a href="?view=tipocosecha">Tipos de Cosecha</a> </li>
            <?php endif; ?>
            <?php if ($flag_documentoventa): ?>
              <li id="menudocumentoventa"> <a href="?view=documentoventa">Documentos de Salida</a></li>
            <?php endif; ?>
            <?php if ($flag_unidadmedida): ?>
              <li id="menuunidadmedida"> <a href="?view=unidadmedida">Unidades de Medida</a></li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>


      <?php

      $flag_mostar_menu = false;
      $flag_cliente = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("cliente"));
      $flag_proveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("proveedor"));
      $flag_operador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("operador"));
      $flag_fundos = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("fundos"));
      $flag_maquinaria = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("maquinaria"));
      $flag_servicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("servicio"));
      $flag_accesorio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesorio"));
      $flag_medicamento = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("medicamento"));
      $flag_accesofundo = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("accesofundo"));
      $flag_medicoservicio = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("operadorservicio"));
      $flag_vacuna = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vacuna"));
      $flag_trabajador = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("trabajador"));
      $flag_mascota = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("mascota"));
      if ($flag_proveedor || $flag_cliente || $flag_operador || $flag_fundos || $flag_maquinaria || $flag_servicio || $flag_accesorio || $flag_medicamento || $flag_accesofundo || $flag_medicoservicio || $flag_vacuna || $flag_mascota) {
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
            <?php if ($flag_cliente): ?>
              <li id="menucliente"> <a href="?view=cliente">Clientes</a> </li>
            <?php endif; ?>
            <?php if ($flag_proveedor): ?>
              <li id="menuproveedor"> <a href="?view=proveedor">Proveedores</a> </li>
            <?php endif; ?>
            <!-- <?php if ($flag_operador): ?>
              <li id="menuoperador"> <a href="?view=operador">Operadores</a> </li>
            <?php endif; ?> -->
            <?php if ($flag_fundos): ?>
              <li id="menufundo"> <a href="?view=fundos">Fundos</a> </li>
            <?php endif; ?>
            <?php if ($flag_maquinaria): ?>
              <li id="menumaquinaria"> <a href="?view=maquinaria">Maquinaria</a> </li>
            <?php endif; ?>
            <?php if ($flag_servicio): ?>
              <li id="menuservicio"> <a href="?view=servicio">Servicios</a> </li>
            <?php endif; ?>
            <?php if ($flag_accesorio): ?>
              <li id="menuaccesorio"> <a href="?view=accesorio">Productos</a> </li>
            <?php endif; ?>
            <?php if ($flag_accesofundo): ?>
              <li id="menuaccesofundo"> <a href="?view=accesosfundo">Acceso a Fundos</a> </li>
            <?php endif; ?>
            <?php if ($flag_medicoservicio): ?>
              <li id="menumedicoservicio"> <a href="?view=operadorservicio">Operadores - Servicios</a></li>
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
      $flag_citas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("citas"));
      $flag_atencioncitas = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("atencioncitas"));
      $flag_historialclinico = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("historialclinico"));
      if ($flag_citas || $flag_atencioncitas || $flag_historialclinico) {
        $flag_mostar_menu = true;
      } else {
        $flag_mostar_menu = false;
      }

      ?>

      <?php if ($flag_mostar_menu): ?>

        <li id="menucitas">
          <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
            <i class="nav-icon fa fa-calendar"></i>
            <span class="nav-title">Cronogramas de Trabajo</span>
          </a>
          <ul aria-expanded="false">
            <?php if ($flag_citas): ?>
              <li id="submenucitas"> <a href="?view=citas">Gestionar Cronograma</a></li>
            <?php endif; ?>
            <?php if ($flag_atencioncitas): ?>
              <li id="submenuatencioncitas"> <a href="?view=atencioncitas">Atención de Cronograma</a></li>
            <?php endif; ?>
            <!-- <?php if ($flag_historialclinico): ?>
              <li id="submenuhistorialclinico"> <a href="?view=historialclinico">Historial Clínico</a></li>
            <?php endif; ?> -->
          </ul>
        </li>

      <?php endif; ?>



      <?php

      $flag_mostar_menu = false;
      $flag_fichamascota = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("fichamascota"));
      $flag_ordenventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordenventa"));
      $flag_ordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ordencompra"));
      $flag_promocion = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("promocion"));
      $flag_ingreso = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("ingreso"));
      if ($flag_fichamascota || $flag_ordenventa || $flag_ordencompra || $flag_promocion || $flag_ingreso) {
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
            <?php if ($flag_ordenventa): ?>
              <li id="submenuordenventa"><a href="?view=ordenventa">Salida de Productos</a></li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>



      <?php

      $flag_mostar_menu = false;
      $flag_vistareporteordencompra = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteordencompra"));
      $flag_vistareporteordenventa = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteordenventa"));
      $flag_vistareporteaccesorios = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareporteaccesorios"));
      $flag_vistareportemedicamentos = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareportemedicamentos"));
      $flag_observacionesproveedor = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("observacionesproveedor"));
      $flag_vistareportecita = $OBJ_ACCESO_OPCION->checkOptionController($_SESSION['id_grupo'], printCodeOption("vistareportecita"));
      if ($flag_vistareporteordencompra || $flag_vistareporteordenventa || $flag_vistareporteaccesorios || $flag_vistareportemedicamentos || $flag_observacionesproveedor || $flag_vistareportecita) {
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
            <?php if ($flag_vistareporteordenventa): ?>
              <li id="submenureporteordenventa"><a href="?view=vistareporteordenventa">Salida de Productos</a></li>
            <?php endif; ?>
            <?php if ($flag_vistareporteaccesorios): ?>
              <li id="submenureporteaccesorio"><a href="?view=vistareporteaccesorios">Productos</a></li>
            <?php endif; ?>
            <?php if ($flag_vistareportecita): ?>
              <li id="submenureportecita"><a href="?view=vistareportecita">Reporte de citas</a></li>
            <?php endif; ?>
          </ul>
        </li>

      <?php endif; ?>

    </ul>
  </div>
</aside>