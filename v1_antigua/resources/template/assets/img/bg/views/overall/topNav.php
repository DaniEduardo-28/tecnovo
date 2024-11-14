<header class="header">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex align-items-center justify-content-between">
      <div class="navbar-header">
        <!-- Navbar Header--><a href="<?=APP_URL;?>" class="navbar-brand">
          <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Fast</strong><strong>Qullqi</strong></div>
          <div class="brand-text brand-sm"><strong class="text-primary">F</strong><strong>Q</strong></div></a>
        <!-- Sidebar Toggle Btn-->
        <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
      </div>
      <div class="right-menu list-inline no-margin-bottom">
        <!-- Languages dropdown -->
        <div class="list-inline-item dropdown">
          <a id="languages" rel="nofollow" data-target="#" href="#"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          class="nav-link language dropdown-toggle">
            <img src="<?=$_SESSION['src_image'];?>" alt="<?=$_SESSION['nombres'];?>"
            style="width:40px;height:40px;border-radius:50px;">
              <span class="d-none d-sm-inline-block">
                <?=$_SESSION['nombres'];?>
              </span></a>
          <div aria-labelledby="languages" class="dropdown-menu">
            <a rel="nofollow" href="myprofile" class="dropdown-item">
              <span class="fa fa-user-circle-o"></span> &nbsp; Mi Perfil
            </a>
            <a rel="nofollow" href="changepassword" class="dropdown-item">
              <span class="fa fa-key"></span> &nbsp; Cambiar Contraseña
            </a>
            <a rel="nofollow" href="logout" class="dropdown-item">
              <span class="icon-logout"></span> &nbsp; Cerrar Sesión
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>
