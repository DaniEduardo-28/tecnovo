<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Galeria | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
	</head>

	<body>
        <!-- Preloader -->
      	<?php include("views/overall/pre-loader.php"); ?>
        <!-- End Preloader -->

				<!-- TopNav -->
        <?php include("views/overall/topNav.php"); ?>
        <!-- TopNav -->

        <!-- Start Services Area -->
        <div class="content-block-area">
            <div class="container">
                <div class="row">

									<?php
										include("admin/core/models/ClassGaleria.php");
										$dataGaleria = $OBJ_GALERIA->show_activos();
										if ($dataGaleria["error"]=="NO") {
											foreach ($dataGaleria["data"] as $key) {
												?>
												<div class="col-lg-4 col-md-6 gallery-boxed">
														<div class="gallery-item-one">
																<div class="pic">
																		<img src="admin/<?=$key['src'];?>" alt="Image Description">
																		<ul class="lightbox-link">
																				<li><a class="lightbox" href="<?=APP_URL . '/' . 'admin/' . $key['src'];?>">
																					<i class="fa fa-plus"></i></a></li>
																		</ul>
																</div>
																<div class="gallery-content">
																		<h3 class="title"><?=$key['titulo'];?></h3>
																		<span class="post"><?=$key['descripcion'];?></span>
																</div>
														</div>
												</div>
												<?php
											}
										}
									 ?>

                    <div class="col-lg-12 text-center">
                        <a href="#" id="loadmore" class="btn theme-btn">ver más</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Services Area -->

        <!-- Footer Area -->
        <footer class="site-footer">
            <<?php include("views/overall/footer.php"); ?>
        </footer> <!-- End Footer Area -->

        <!-- Back Top top -->
        <a href="#content" class="back-to-top">Top</a>
        <!-- End Back Top top -->

		<!-- Bootstrap JS file -->
  			<?php include("views/overall/js.php"); ?>
	</body>
</html>
