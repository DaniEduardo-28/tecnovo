<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Conocénos | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
	</head>

	<body>

        <!-- Preloader -->
        <?php include("views/overall/pre-loader.php"); ?>
        <!-- End Preloader -->

      	<?php include("views/overall/topNav.php"); ?>

        <!-- Start Top Banner Area -->
        <div class="content-block-area gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="banner-man-boxed" style="background-image: url(admin/resources/assets-web/img/banner-man-bg.png);"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="banner-boxed">
                            <h2>Ayudando y proporcionando<span> Mejores Servicios</span> para tu engreído <span>
															con 10 años de experiencia.
														</span></h2>
                            <p class="subtitle">
														 	<?=APP_TITLE;?> es un centro especializado en la
															atención integral de la mascota. Desde hace más de 10 años ofrecemos a nuestros clientes una
															completa atención para sus engreídos.
														</p>
                            <p style="text-align: justify;">
															Con el tiempo hemos ido creciendo y mejorando nuestras instalaciones. Hoy en
															día nos sentimos orgullosos de ser uno de los centros mejor dotados en todo
															Aragón. Esto nos hace capaces de proporcionar una asistencia de gran calidad a
															los habitantes de la zona. No obstante, el equipo humano de nuestro Centro y
															su infraestructura, hace posible que ésta se amplíe a una extensa zona de la
															 geografía de nuestro país.
															<br>
															Ofrecemos un servicio higiénico-sanitario completo, asesoramiento nutricional,
															contamos con servicio de análisis de laboratorio, peluquería, guardería, ente
															otros. Asimismo, trabajamos en colaboración con otros profesionales veterinarios,
															poniendo a su disposición nuestros medios y personal.

														</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Banner Area -->

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

            </div>
        </div>
        <!-- End Why Choose Us Area -->

				<!-- Start Count-Down Area -->
        <div class="count-down-area jarallax" style="background : url(admin/resources/assets-web/img/count-bg-2.png)">
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

		<?php include("views/overall/js.php"); ?>
	</body>
</html>
