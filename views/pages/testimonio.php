<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Testimonios | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
	</head>

	<body>
       <!-- Preloader -->
        <?php include("views/overall/pre-loader.php"); ?>
        <!-- End Preloader -->

				<!-- TopNav -->
				<?php include("views/overall/topNav.php"); ?>
				<!-- TopNav -->

        <!-- Start Our testimonials Area -->
        <div class="content-block-area gray-bg">
            <div class="container">
                <div class="row">

									<div class="col-md-12 col-lg-4">
											<div class="section-title text-right">
													<h3>Nuestros Clientes</h3>
													<h2><span>CONFIAN</span> EN NUESTRO SERVICIO</h2>
										 </div>
											<div class="testimonials-car-boxed wow fadeInLeft">
												 <img src="admin/resources/assets-web/img/testimonial-car.png" alt="Image">
											</div>
									</div>

									<?php
										include("admin/core/models/ClassTestimonio.php");
										$dataTestimonio = $OBJ_TESTIMONIO->show_cantidad_limite_activos(30);
										if ($dataTestimonio["error"]=="NO") {
											$countTest = 1;
											foreach ($dataTestimonio["data"] as $key) {
												$countTest++;
												?>
												<div class="col-lg-4">
			                        <div class="testimonial-item mrb-30">
			                            <div class="testimonial-single-item">
			                                <p>
																				<?=$key['descripcion'];?>
																			</p>
			                                <ul>
			                                  <?php for($x=0;$x<5;$x++): ?>
																					<?php if ($x<$key['referencia_1']): ?>
																						<li><i class="fa fa-star"></i></li>
																					<?php else: ?>
																						<li><i class="fa fa-star-o"></i></li>
																					<?php endif; ?>
			                                  <?php endfor;?>
			                                </ul>
																			<?=$key['titulo'] . '<br><font size="2">' . $key['referencia_2'] . '</font>';?>
			                            </div>
			                            <div class="quotation-profile">
			                                <img src="admin/<?=$key['src'];?>" alt="<?=$key['titulo'];?>">
			                            </div>
			                        </div>
			                    </div>
												<?php
												if ($countTest%3==0) {
													echo "</div>";
													echo '<div class="space-tb-30"></div>';
													echo '<div class="row">';
												}
											}
										}
									?>

                </div>

            </div>
        </div>
        <!-- End Our testimonials Area -->

				<!-- Start Count-Down Area -->
        <div class="count-down-area jarallax" style="background : url(admin/resources/assets-web/img/count-bg-3.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="count-down-boxed text-center">
                            <div class="icon-box">
                               <i class="fa fa-smile-o"></i>
                            </div>
                            <span class="count-icon">
                                <span class="count-number counter">
																	<?=$dataResult[24]['valor_int']; ?>
																</span>
                            </span>
                            <h3 class="count-info">Clientes Felices</h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="count-down-boxed text-center">
                           <div class="icon-box">
                               <i class="fa fa-building-o"></i>
                            </div>
                            <span class="count-icon">
                                <span class="count-number counter">
																	<?=$dataResult[25]['valor_int']; ?>
																</span>
                            </span>
                            <h3 class="count-info">Proyectos Completados</h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="count-down-boxed text-center">
                           <div class="icon-box">
                               <i class="fa fa-trophy"></i>
                            </div>
                            <span class="count-icon">
                                <span class="count-number counter">
																	<?=$dataResult[26]['valor_int']; ?>
																</span>
                            </span>
                            <h3 class="count-info">Premios</h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="count-down-boxed text-center">
                           <div class="icon-box">
                               <i class="fa fa-clock-o"></i>
                            </div>
                            <span class="count-icon">
                                <span class="count-number counter">
																	<?=$dataResult[27]['valor_int']; ?>
																</span>
                            </span>
                            <h3 class="count-info">Horas Trabajadas</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Count-Down Area -->

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

	</body>

	<!-- Footer Area -->
	<?php include("views/overall/footer.php"); ?>
	<!-- Back Top top -->
	<a href="#content" class="back-to-top">Top</a>
	<!-- End Back Top top -->

	<?php include("views/overall/js.php"); ?>
</html>
