<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Servicios | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
	</head>

	<body>

		<!-- Preloader -->
		<?php include("views/overall/pre-loader.php"); ?>
		<!-- End Preloader -->

		<?php include("views/overall/topNav.php"); ?>

        <!-- Start Services Area -->
        <div class="content-block-area">
            <div class="container">
                <div class="row">
										<?php
											include("admin/core/models/ClassServicio.php");
											$dataServicio = $OBJ_SERVICIO->show_activos();
											if ($dataServicio["error"]=="NO") {
												foreach ($dataServicio["data"] as $key) {
													?>
													<div class="col-md-6 col-lg-4">
			                        <div class="services-item">
			                            <div class="box">
			                                <img src="admin/<?=$key['src_imagen'];?>" alt="Image">
			                                <h3><?=$key['name_servicio'];?></h3>
			                                <div class="box-content">
			                                    <h3 class="title"><?=$key['name_servicio'];?></h3>
			                                    <span class="post">
																						<?=$key['descripcion_breve'];?>
																					</span>
			                                    <ul class="icon">
			                                        <li><a class="lightbox" href="<?=APP_URL . '/' . 'admin/' . $key['src_imagen'];?>"><i class="fa fa-search"></i></a></li>
			                                        <li><a href="?view=galeria"><i class="fa fa-link"></i></a></li>
			                                    </ul>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
													<?php
												}
											}
										 ?>
                </div>

                <div class="col-lg-12 col-md-12 text-center">
                    <a href="#" id="loadmore" class="btn theme-btn">ver más</a>
                </div>
            </div>

        </div>
        <!-- End Services Area -->

				<!-- Start Our testimonials Area -->
        <div class="content-block-area gray-bg">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 col-lg-4">
                        <div class="section-title text-right">
                            <h3>Nuestros Clientes</h3>
                            <h2><span>CLIENTES QUE CONFIAN</span> EN NUESTRO SERVICIO</h2>
                       </div>
                        <div class="testimonials-car-boxed wow fadeInLeft">
                           <img src="admin/resources/assets-web/img/testimonial-car.png" alt="Image">
                        </div>
                    </div>

										<?php
											include("admin/core/models/ClassTestimonio.php");
											$dataTestimonio = $OBJ_TESTIMONIO->show_cantidad_limite_activos(2);
											if ($dataTestimonio["error"]=="NO") {
												foreach ($dataTestimonio["data"] as $key) {
													?>
													<div class="col-md-6 col-lg-4">
															<div class="testimonial-item">
																	<div class="testimonial-single-item">
																			<p>
																				<?=$key['descripcion'];?>
																			</p>
																			<ul>
																					<li><i class="fa fa-star"></i></li>
																					<li><i class="fa fa-star"></i></li>
																					<li><i class="fa fa-star"></i></li>
																					<li><i class="fa fa-star"></i></li>
																					<li><i class="fa fa-star"></i></li>
																			</ul>
																	</div>
																	<div class="quotation-profile">
																			<img src="admin/<?=$key['src'];?>" alt="Image">
																	</div>

															</div>
													</div>
													<?php
												}
											}
										 ?>

										<div class="col-lg-12 text-center">
												<a href="?view=testimonio" class="btn theme-btn m-t-50">Ver todos los testimonios</a>
										</div>

                </div>
            </div>
        </div>
        <!-- End Our testimonials Area -->

				<!-- Start Our Parners Area -->
        <div class="content-block-area">
            <div class="container">
               <div class="row">
                   <div class="col-lg-6 offset-lg-3">
                       <div class="section-title text-center">
                           <h2><span>Nuestros</span>Socios</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>
														 Nos compormetemos a brindarte un producto o servicio de calidad que satisfaga sus necesidades.
														 Algunos de nuestros aliados son :
													 </p>
                       </div>
                   </div>
                </div>
                <div class="partner-slides">

									<?php
										include("admin/core/models/ClassSocio.php");
										$dataSocio = $OBJ_SOCIO->show_cantidad_limite_activos(10);
										if ($dataSocio["error"]=="NO") {
											foreach ($dataSocio["data"] as $key) {
												?>
												<div class="single-partner-slide">
		                        <a class="partners-logo" href="<?=$key['descripcion'];?>" target="_blank">
															<img src="admin/<?=$key['src'];?>"
															alt="<?=$key['titulo'];?>">
														</a>
		                    </div>
												<?php
											}
										}
									 ?>

                </div>
            </div>
        </div>
        <!-- End Our Parners Area -->

				<!-- Footer Area -->
   	<?php include("views/overall/footer.php"); ?>

 		<?php include("views/overall/js.php"); ?>

	</body>
</html>
