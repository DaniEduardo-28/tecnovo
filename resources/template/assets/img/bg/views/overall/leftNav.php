<!-- Sidebar Navigation-->
<nav id="sidebar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="<?=$_SESSION['src_image'];?>" alt="..." class="img-fluid rounded-circle"></div>
    <div class="title">
      <h1 class="h5"><?=$_SESSION['nombres'];?></h1>
      <p><?=$_SESSION['name_especialidad'];?></p>
    </div>
  </div>
  <!-- Sidebar Navidation Menus--><span class="heading">Principal</span>
  <ul class="list-unstyled">
    <li><a href="#tabmenuInicio1" id="tabmenuInicio" aria-expanded="false" data-toggle="collapse">
      <i class="fa fa-home"></i>Inicio</a>
      <ul id="tabmenuInicio1" class="collapse list-unstyled">
        <li id="myprofile"><a href="myprofile">Mi Perfil</a></li>
        <li id="changepassword"><a href="changepassword">Cambiar Contraseña</a></li>
        <li><a href="logout">Cerrar Sesión</a></li>
      </ul>
    </li>
    <li><a href="#tabmenuConfiguracion1" id="tabmenuConfiguracion" aria-expanded="false" data-toggle="collapse">
      <i class="fa fa-cog"></i>Configuración</a>
      <ul id="tabmenuConfiguracion1" class="collapse list-unstyled">
        <li id="mybusiness"><a href="mybusiness">Mi Empresa</a></li>
        <li id="sucursales"><a href="sucursales">Sucursales</a></li>
        <li id="monedas"><a href="monedas">Monedas</a></li>
        <li id="identitydocuments"> <a href="identitydocuments">Documentos de Identidad</a> </li>
        <li id="especialidad"> <a href="especialidad">Cargo Trabajador</a> </li>
        <li id="tipocambio"> <a href="tipocambio">Tipo de Cambio</a> </li>
        <li id="documentoventa"> <a href="documentoventa">Documentos de Sunat</a></li>
      </ul>
    </li>
    <li><a href="#tabmenuMantenimiento1" id="tabmenuMantenimiento" aria-expanded="false" data-toggle="collapse">
      <i class="fa fa-database"></i>Mantenimiento</a>
      <ul id="tabmenuMantenimiento1" class="collapse list-unstyled">
        <li id="cliente"> <a href="cliente">Clientes</a> </li>
        <!--<li id="servicio"> <a href="servicio">Servicios</a> </li>
        <li id="accesorio"> <a href="accesorio">Productos</a> </li>
        <li id="medicamento"> <a href="medicamento">Productos</a> </li>
        <li id="medicoservicio"> <a href="medicoservicio">Medicos - Servicios</a></li>
        <li id="vacuna"> <a href="vacuna">Vacunas</a></li>
        <li id="mascota"> <a href="mascota">Operaciones</a></li>-->
      </ul>
    </li>
    <li><a href="#tabmenuSeguridad1" id="tabmenuSeguridad" aria-expanded="false" data-toggle="collapse">
      <i class="fa fa-key"></i>Seguridad</a>
      <ul id="tabmenuSeguridad1" class="collapse list-unstyled">
        <li id="grupousuario"> <a href="grupousuario">Grupos de Usuario</a> </li>
        <li id="accesogrupo"> <a href="accesogrupo">Acceos a Opciones</a> </li>
        <li id="accesosucursal"> <a href="accesosucursal">Acceos a Sucursales</a> </li>
        <li id="trabajador"> <a href="trabajador">Usuarios del Sistema</a> </li>
      </ul>
    </li>
  </ul>
</nav>
<!-- Sidebar Navigation end-->
