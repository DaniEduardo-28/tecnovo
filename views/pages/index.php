<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Index | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>

	</head>

	<body>
        <!-- Preloader -->
        <?php include("views/overall/pre-loader.php"); ?>
        <!-- End Preloader -->

				<!-- TopNav -->
        <?php include("views/overall/topNav.php"); ?>
        <!-- TopNav -->

        <!-- Start Homepage Slider -->
        <div class="homepage-slides-wrapper ">
            <!-- Slider main container -->
            <div class="swiper-container swiper1">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide" <?php echo 'style="background-image: url(admin/' . $dataResult[0]['valor_string'] . ');"' ?>>
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h1>
                                            	<?=$dataResult[3]['valor_string']; ?>
                                            </h1>
                                            <p>
                                            	<?=$dataResult[6]['valor_string']; ?>
                                            </p>
                                            <a class="btn theme-btn" href="<?=$dataResult[12]['valor_string']; ?>">
																							<?=$dataResult[9]['valor_string']; ?>
																						</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide" <?php echo 'style="background-image: url(admin/' . $dataResult[1]['valor_string'] . ');"' ?>>
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="container">
                                    <div class="row">
																			<div class="col-lg-6">
																					<h1>
																						<?=$dataResult[4]['valor_string']; ?>
																					</h1>
																					<p>
																						<?=$dataResult[7]['valor_string']; ?>
																					</p>
																					<a class="btn theme-btn" href="<?=$dataResult[13]['valor_string']; ?>">
																						<?=$dataResult[10]['valor_string']; ?>
																					</a>
																			</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide" <?php echo 'style="background-image: url(admin/' . $dataResult[2]['valor_string'] . ');"' ?>>
                        <div class="d-table">
                            <div class="d-table-cell">
                                <div class="container">
                                    <div class="row">
																			<div class="col-lg-6">
																					<h1>
																						<?=$dataResult[5]['valor_string']; ?>
																					</h1>
																					<p>
																						<?=$dataResult[8]['valor_string']; ?>
																					</p>
																					<a class="btn theme-btn" href="<?=$dataResult[14]['valor_string']; ?>">
																						<?=$dataResult[11]['valor_string']; ?>
																					</a>
																			</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- If we need pagination -->
                <div class="swiper-pagination swiper-pagination1"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
        </div>
        <!-- End Homepage Slider -->


        <!-- Start Services Area -->
        <div class="content-block-area gray-bg">
            <div class="container">
                <div class="row">
                   <div class="col-lg-6 offset-lg-3">
                       <div class="section-title text-center">
                           <h2><span>NUESTROS SERVICIOS</span> DESTACADOS</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>
														 Ofrecemos toda clase de servicios personalizados para atender y satisfacer las
														 necesidades de sus mascotas.
                           </p>
                       </div>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="featured-boxed text-center">
                           <div class="icon-boxed">
                                <img src="admin/resources/assets-web/img/Pet-1.png" alt="dog-1">
                            </div>
                            <h3>Atención Veterinaria</h3>
                            <div class="upper-line"></div>
                            <div class="bottom-line"></div>
                            <p>
                            	Realizamos consulta médica general y especializada. Atención personalizada a cada
															una de nuestras mascotas. Contamos con un equipo médico veterinario que busca el bienestar
															y calidad de vida de nuestros pacientes.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="featured-boxed text-center">
                            <div class="icon-boxed">
                                <img src="admin/resources/assets-web/img/Pet2.png" alt="dog-1">
                            </div>
                            <h3>Baños Especializados</h3>
                            <div class="upper-line"></div>
                            <div class="bottom-line"></div>
                            <p>
                            	Ofrecemos todo lo necesario para el aseo y cuidado de tu mascota de la mano de un
															servicio de peluquería con años de experiencia y usamos productos seleccionados para que
															tu mascota se vea, sienta y huela increíble.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="featured-boxed text-center">
                            <div class="icon-boxed">
                                <img src="admin/resources/assets-web/img/Pet-3.png" alt="dog-1">
                            </div>
                            <h3>NUESTRO PET SHOP</h3>
                            <div class="upper-line"></div>
                            <div class="bottom-line"></div>
                            <p>
                            	Nos encanta consentir a tu peludito, por eso contamos con una amplia boutique en la
															que podrás encontrar accesorios, juguetería, concentrados y todo lo que necesitas para
															tu mascota.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="separator-line"></div>

            <div class="container-fluid">
                <div class="row">

									<?php
										include("admin/core/models/ClassServicio.php");
										$dataServicio = $OBJ_SERVICIO->show_cantidad_limite_activos(4);
										if ($dataServicio["error"]=="NO") {
											foreach ($dataServicio["data"] as $key) {
												?>
													<div class="col-lg-3 col-md-6">
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
																							<li><a class="singleImage" href="<?=APP_URL . '/' . 'admin/' . $key['src_imagen'];?>"><i class="fa fa-search"></i></a></li>
																							<li><a href="?view=servicios"><i class="fa fa-link"></i></a></li>
																					</ul>
																			</div>
																	</div>
															</div>
													</div>
												<?php
											}
										}
									 ?>

                    <div class="col-lg-12 text-center">
                        <a href="?view=servicios" class="btn theme-btn m-t-50">Ver todos los servicios</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Services Area -->

        <!-- Start Why Choose Us Area -->
        <div class="content-block-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                       <div class="section-title text-center">
                           <h2><span>POR QUÉ</span> ELEGIRNOS</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>
														 Somos una veterinaria con profesionales que trabajan con un solo compromiso el bienestar de su mascota.
													 </p>
                       </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="boxed-item">
                            <span class="sirial-number">01</span>
                            <span class="single-boxed"><i class="fa fa-volume-control-phone"></i></span>
                            <h3>Respuesta Rápida</h3>
                            <p>
															Atendemos las 24 Horas, los 7 días de la semana y los 365 días del año. Porque sabemos lo importante que es tu mascota para tí.
															<br><br>
														</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="boxed-item">
                            <span class="sirial-number">02</span>
                            <span class="single-boxed"><i class="fa fa-home"></i></span>
                            <h3>Moderna Infraestructura</h3>
                            <p>Contamos con una moderna infraestructura, así como un moderno equipamiento con la más avanzada tecnología al servicio que su mascota necesita.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="boxed-item">
                            <span class="sirial-number">03</span>
                            <span class="single-boxed"><i class="fa fa-user-md"></i></span>
                            <h3>Profesional calificado</h3>
                            <p>
															Contamos con un selecto staff de profesionales altamente calificados que brindará
															la mejor y total atención que su mascota necesita.
															<br><br>
														</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="boxed-item">
                            <span class="sirial-number">04</span>
                            <span class="single-boxed"><i class="fa fa-heart"></i></span>
                            <h3>Exelente atención</h3>
                            <p>Contamos con  la satisfacción de nuestros clientes por la atención recibida de nuestros profesionales
														con la mejor atención que su mascota necesita nos respaldan.</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12 text-center">
                    <a href="?view=conocenos" class="btn theme-btn m-t-50">Nosotros</a>
                </div>
            </div>
        </div>
        <!-- End Why Choose Us Area -->

        <!-- Start Count-Down Area -->
        <div class="count-down-area jarallax" style="background : url(admin/resources/assets-web/img/count-bg.jpg)">
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

        <!-- Start Services Area -->
        <div class="content-block-area">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                       <div class="section-title text-center">
                           <h2><span>SERVICIOS</span> ESPECIALES</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>Es un hecho establecido hace mucho tiempo que un lector se distraerá con el contenido legible de una página al mirar su diseño.</p>
                       </div>
                    </div>
                </div>

                <div class="content service_content">
                    <div class="row">
                      <div class="service_left">
                        <div class="apartment">
                            <a href="#">
                                <div class="service_icon round"></div>
                                <h5 class="wow fadeInLeft" data-wow-delay="100ms" data-wow-duration="1000ms">Consejería de comportamiento</h5>
                            </a>
                        </div>
                        <div class="office">
                            <a href="#">
                                <div class="service_icon round"></div>
                                <h5 class="wow fadeInLeft" data-wow-delay="100ms" data-wow-duration="1000ms">Consejos de Alimentación</h5>
                            </a>
                        </div>
                        <div class="move_in_out">
                            <a href="#">
                                <div class="service_icon round"></div>
                                <h5 class="wow fadeInLeft" data-wow-delay="100ms" data-wow-duration="1000ms">Sugerencias generales</h5>
                            </a>
                        </div>
                      </div>
                      <div class="service_middle round">
                        <img class="round" src="admin/resources/assets-web/img/service.png" alt="" />
                      </div>
                      <div class="service_right">
                        <div class="car_washing">
                            <a href="#">
                              <div class="service_icon round"></div>
                              <h5 class="wow fadeInRight" data-wow-delay="100ms" data-wow-duration="1000ms">Manejo de la diabetes</h5></a>
                        </div>
                        <div class="renovation">
                            <a href="#">
                              <div class="service_icon round"></div>
                              <h5 class="wow fadeInRight" data-wow-delay="100ms" data-wow-duration="1000ms">Pruebas fecales</h5></a>
                        </div>
                        <div class="green_cleaning">
                            <a href="#">
                              <div class="service_icon round"></div>
                              <h5 class="wow fadeInRight" data-wow-delay="100ms" data-wow-duration="1000ms">Procedimientos de diagnóstico</h5></a>
                        </div>
                      </div>
                    </div>
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

        <!-- Start Our team Area -->
        <div class="content-block-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                       <div class="section-title text-center">
                           <h2><span>nuestro experienciado</span> equipo</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>
														 La perfecta integración de cada uno de los miembros del equipo y un magnífico
														 ambiente de trabajo, sumado a nuestra constante formación, hace que podamos
														 desarrollar al máximo nuestra vocación y nuestra profesionalidad alcance la excelencia.
													 </p>
                       </div>
                    </div>
                </div>
                <div class="row">

									<?php
										$medcount = 0;
										include("admin/core/models/ClassTrabajador.php");
										$dataMedico = $OBJ_TRABAJADOR->getMedicos("activo");
										if ($dataMedico["error"]=="NO") {
											foreach ($dataMedico["data"] as $key) {
												$medcount++;
												?>
												<div class="col-lg-4 col-md-6 <?php if ($medcount%3==0): ?>
													offset-md-3 offset-lg-0
												<?php endif; ?> ">
														 <div class="our-team">
																 <div class="team-image">
																		 <img src="admin/<?=$key['src_imagen'];?>" alt="team-one">
																		 <p class="description">
																				<?=$key['descripcion']; ?>
																		 </p>
																		 <ul class="social">
																				 <li><a href="<?=$key['link_facebook'];?>" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
																				 <li><a href="<?=$key['link_instagram'];?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
																				 <li><a href="<?=$key['link_twitter'];?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
																		 </ul>
																 </div>
																 <div class="team-info">
																		 <h3 class="title"><?=$key['nombres_medico'];?></h3>
																		 <span class="post">
																		 	<?=$key['name_especialidad'];?>
																		 </span>
																 </div>
														 </div>
												 </div>
												<?php
											}
										}
									?>

                </div>
            </div>
        </div>
        <!-- End Our team Area -->
        <hr>

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
				<!-- End Footer Area -->

        <!-- Back Top top -->
        <a href="#content" class="back-to-top">Top</a>
        <!-- End Back Top top -->

			<?php include("views/overall/js.php"); ?>

	</body>
</html>
