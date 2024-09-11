<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Contacto | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
	</head>

	<body>
        <!-- Preloader -->
        <?php include("views/overall/pre-loader.php"); ?>
        <!-- End Preloader -->

        <!-- Start Top Header Area -->
        <?php include("views/overall/topNav.php"); ?>
        <!-- End Start Top Header Area -->


        <!-- Contact Form Area -->
        <div class="content-block-area contact-us">
            <div class="container">
               <h2 class="area-title">Información Contacto</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="media">
                            <div class="media-left">
                                <i class="ion-ios-location-outline"></i>
                            </div>
                            <div class="media-body">
                                <h4>
																	<?=$dataResult[23]['valor_string'];?>
																</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="media">
                            <div class="media-left">
                                <i class="ion-ios-telephone-outline"></i>
                            </div>
                            <div class="media-body">
                                <h4><?=$dataResult[17]['valor_string'];?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="media">
                            <div class="media-left">
                                <i class="ion-ios-email-outline"></i>
                            </div>
                            <div class="media-body">
                                <h4><?=$dataResult[16]['valor_string'];?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-area">
                   <h2 class="area-title">Estar en contacto</h2>
                    <div class="row">
                        <div class="col-md-5 col-lg-4">
                            <div class="contact-img-bg"></div>
                        </div>
                        <div class="col-md-7 col-lg-8">
                            <form id="contatc_form" method="POST" name="myform" action="ajax.php?accion=goMail">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="contact_name" name="name"
																						placeholder="Nombre" required="" data-parsley-minlength="4" autocomplete="off"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" id="contact_email"
																						placeholder="Email" required="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="sub" id="contact_subject"
																						placeholder="Asunto" required="" data-parsley-minlength="4" autocomplete="off"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="phone" id="contact_phone"
																						placeholder="Telefono" data-parsley-type="integer" data-parsley-minlength="6"
																						data-parsley-type-message="Only numbers" required="" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea id="contact_message" class="form-control" name="message" rows="6"
                                    placeholder="Mensaje" required="" data-parsley-trigger="keyup" data-parsley-minlength="10"
                                    data-parsley-minlength-message="Come on! You need to enter at least a 10 character comment.."
                                    ></textarea>
                                </div>
                                <div class="g-recaptcha" data-sitekey="6LeMly8UAAAAAG8FJH-xbRYPyV825xNA3KzwWtcr"></div>
                                <div id="contact_send_status"></div>
                                <button type="submit" class="btn theme-btn">Enviar Mensaje</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Form Area -->

        <!-- Google Map Area -->
        <div style="background-color: #eaeaea;">
        	<?=$dataResult[36]['valor_string'];?>
        </div>
        <!-- Google Map Area -->

        <!-- Footer Area -->

        <?php include("views/overall/footer.php"); ?>
				<!-- End Footer Area -->

        <!-- Back Top top -->
        <a href="#content" class="back-to-top">Top</a>
        <!-- End Back Top top -->

			<?php include("views/overall/js.php"); ?>


	</body>
</html>
