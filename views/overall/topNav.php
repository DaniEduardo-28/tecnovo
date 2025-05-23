<header class="app-header top-bar">
    <!-- begin navbar -->
    <nav class="navbar navbar-expand-md">

        <div class="navbar-header d-flex align-items-center">
            <a href="#" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
            <a class="navbar-brand" href="?view=home">
                <img src="resources/template/assets/img/logo.png" class="img-fluid logo-desktop" alt="logo" />
                <img src="resources/template/assets/img/logo-xs.png" class="img-fluid logo-mobile" alt="logo" />
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="ti ti-align-left"></i>
        </button>
        <!-- end navbar-header -->
        <!-- begin navigation -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="color = orange;">
            <div class="navigation d-flex">
                <ul class="navbar-nav nav-left">
                  <li class="nav-item">
                      <a href="#" class="nav-link sidebar-toggle">
                          <i class="ti ti-align-right"></i>
                      </a>
                  </li>
                </ul>
                <ul class="navbar-nav nav-left">
                  <li class="nav-item">
                    <a href="#" class="nav-link expand">
                      <h4>BIENVENIDO <?=strtoupper($_SESSION['nombres']) . ' ' . strtoupper($_SESSION['apellidos']);?></h4>
                    </a>
                  </li>
                </ul>
                <ul class="navbar-nav nav-right ml-auto">

                    <li class="nav-item dropdown user-profile">
                        <a href="#" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?=$_SESSION['src_image'] ?>" alt="avtar-img">
                            <span class="bg-success user-status"></span>
                        </a>
                        <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                            <div class="bg-gradient px-4 py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="mr-1">
                                        <h4 class="text-white mb-0"><?=$_SESSION['nombres'];?></h4>
                                        <small class="text-white"><?=strtoupper($_SESSION['name_grupo']) . ' - ' . strtoupper($_SESSION['name_especialidad']);?></small>
                                    </div>
                                    <a href="?view=logout" class="text-white font-20 tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cerrar Sesión"> <i
                                      class="zmdi zmdi-power"></i></a>
                                </div>
                            </div>
                            <div class="p-4">
                                <a class="dropdown-item d-flex nav-link" href="?view=myprofile">
                                  <i class="fa fa-user pr-2 text-success"></i> Mi Perfil</a>
                                <a class="dropdown-item d-flex nav-link" href="?view=changepassword">
                                  <i class="fa fa-key pr-2 text-warning"></i> Cambiar Contraseña</a>
                                <a class="dropdown-item d-flex nav-link" href="https://www.oxerva.com/contacto.php"
                                  target="_blank">
                                  <i class="fa fa-compass pr-2 text-primary"></i> ¿Necesitas ayuda?</a>
                                <a class="dropdown-item d-flex nav-link" href="?view=logout">
                                  <i class="fa fa-sign-out pr-2 text-danger"></i> Cerrar Sesión</a>

                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end navigation -->
    </nav>
    <!-- end navbar -->
</header>
