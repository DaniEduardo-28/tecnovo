<!-- Start Top Header Area -->
<div class="top-header-area">
		<div class="container">
				<div class="row">
						<div class="col-md-12 col-lg-8">
								<ul>
										<li><a href="#"><i class="fa fa-clock-o"></i> <?=$dataResult[15]['valor_string']; ?></a></li>
										<li><a href="#"><i class="fa fa-envelope"></i> <?=$dataResult[16]['valor_string']; ?></a></li>
										<li><a href="#"><i class="fa fa-phone"></i> <?=$dataResult[17]['valor_string']; ?></a></li>
								</ul>
						</div>
						<div class="col-md-12 col-lg-4">
								<div class="share-icons">
										<ul>
												<li><a href="<?=$dataResult[18]['valor_string']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
												<li><a href="<?=$dataResult[19]['valor_string']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
												<li><a href="<?=$dataResult[20]['valor_string']; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
												<li><a href="<?=$dataResult[21]['valor_string']; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
												<li><a href="<?=APP_URL;?>admin/" target="_blank"><i class="fa fa-laptop"></i> &nbsp; Intranet</a></li>
										</ul>
								</div>
						</div>
				</div>
		</div>
</div>
<!-- End Start Top Header Area -->

<!-- Start Main Menu Area -->
<div class="main-menu-area">
		<div class="container">
				<div class="row">
						<div class="col-lg-3">
								<div class="logo">
										<a href="<?=APP_URL;?>"><img src="admin/<?=$dataResult[22]['valor_string']; ?>" alt="Logo"></a>
								</div>
						</div>

						<div class="col-lg-9">
								<nav class="navbar navbar-expand-lg navbar-light">
										<!-- Brand and toggle get grouped for better mobile display -->
										<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
										</button>

										<!-- Collect the nav links, forms, and other content for toggling -->
										<div class="collapse navbar-collapse" id="navbarSupportedContent">
												<ul class="navbar-nav main-menu ml-auto">

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>">Inicio</a>
														</li>

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>?view=conocenos">Conócenos</a>
														</li>

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>?view=servicios">Servicios</a>
														</li>

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>?view=articulos">Artículos</a>
														</li>

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>?view=galeria">Galeria</a>
														</li>

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>?view=testimonio">COMENTARIOS</a>
														</li>

														<li class="nav-item">
																<a class="nav-link" href="<?=APP_URL;?>?view=contacto">Contacto</a>
														</li>

														<li class="nav-item dropdown">
																<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
																aria-haspopup="true" aria-expanded="false">
																<?php if (isset($_SESSION['id_cliente'])): ?>
																	<?=$_SESSION['nombres_cliente'];?>
																<?php else: ?>
																	MI CUENTA
																<?php endif; ?>
																<i class="fa fa-angle-down"></i></a>
																<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
																		<?php if (!isset($_SESSION['id_cliente'])): ?>
																			<li><a class="dropdown-item" href="?view=login">Iniciar Sesión</a></li>
																			<li><a class="dropdown-item" href="?view=registro">Registrarse</a></li>
																		<?php else: ?>
																			<li><a class="dropdown-item" href="?view=miperfil">Mi Perfil</a></li>
																			<li><a class="dropdown-item" href="?view=cambiarpassword">Cambiar Contraseña</a></li>
																			<li><a class="dropdown-item" href="?view=mascotas">Mis mascotas</a></li>
																			<li><a class="dropdown-item" href="?view=citas">Mis citas</a></li>
																			<li><a class="dropdown-item" href="?view=promociones">Mis Promociones</a></li>
																			<li><a class="dropdown-item" href="?view=logout">Cerrar Sesión</a></li>
																		<?php endif; ?>
																</ul>
														</li>

												</ul>
										</div><!-- /.navbar-collapse -->
								</nav>
						</div>
				</div>
		</div>
</div>
<!-- End Main Menu Area -->
