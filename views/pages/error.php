<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Página no encontrada | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
	</head>

	<body>

			<!-- Preloader -->
			<?php include("views/overall/pre-loader.php"); ?>
			<!-- End Preloader -->

			<!-- TopNav -->
			<?php include("views/overall/topNav.php"); ?>
			<!-- TopNav -->

        <!-- Start Appointment Area -->
        <div class="content-block-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="d-table">
                            <div class="d-table-cell">
                                <h1>404 Error <img src="admin/resources/assets-web/img/sad.png" alt="sad"></h1>
                                <h3>PÁGINA NO ENCONTRADA</h3>
                                <p class="return">La página que estás buscando no existe. Lo sentimos, pero parece que no podemos encontrar la página que solicitó.</p>
                                <p><a class="btn theme-btn" href="<?=APP_URL;?>"><i class="fa fa-arrow-circle-left"></i> Ir a la página de Inicio</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Appointment Area -->

				<!-- Footer Area -->
        <?php include("views/overall/footer.php"); ?>
				<!-- End Footer Area -->

        <!-- Back Top top -->
        <a href="#content" class="back-to-top">Top</a>
        <!-- End Back Top top -->

			<?php include("views/overall/js.php"); ?>

	</body>
</html>
