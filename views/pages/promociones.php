<?php
  if (!isset($_SESSION['id_cliente'])) {
    header('location: ?view=login');
    exit();
  }
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Mis Promociones | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>

	</head>

	<body>

		<!-- Preloader -->
		<?php include("views/overall/pre-loader.php"); ?>
		<!-- End Preloader -->

		<?php include("views/overall/topNav.php"); ?>

        <!-- Start Appointment Area -->
        <div class="content-block-area">
            <div class="container">
               <div class="row">
                   <div class="col-lg-6 offset-lg-3">
                       <div class="section-title text-center">
                           <h2><span>Listado</span> Promociones</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>En esta sección podrás encontrar todas las promociones registradas en el sistema.</p>
                       </div>
                    </div>
               </div>

               <div class="row">
                   <?php
                     include("admin/core/models/ClassCliente.php");
                     $dataCliente = $OBJ_CLIENTE->showPromocionesCliente($_SESSION['id_cliente']);
                     if ($dataCliente["error"]=="NO") {
                       foreach ($dataCliente["data"] as $key) {
                         ?>
                         <div class="col-md-6 col-lg-4">
                             <div class="services-item">
                                 <div class="box">
                                     <img src="admin/<?=$key['src_imagen'];?>" alt="Image">
                                     <h3><?=$key['titulo'];?></h3>
                                     <div class="box-content">
                                         <h3 class="title"><?=$key['titulo'];?></h3>
                                         <span class="post">
                                           <?=$key['descripcion'] . '<br> Válido : ' . date('d/m/Y', strtotime($key['fecha_inicio'])) . ' - ' . date('d/m/Y', strtotime($key['fecha_fin']));?>
                                         </span>
                                         <ul class="icon">
                                             <li><a class="lightbox" href="<?=APP_URL . 'admin/' . $key['src_imagen'];?>"><i class="fa fa-search"></i></a></li>
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
        <!-- End Appointment Area -->

        <!-- Back Top top -->
        <a href="#content" class="back-to-top">Inicio</a>
        <!-- End Back Top top -->

				<!-- Footer Area -->
			<?php include("views/overall/footer.php"); ?>
			<?php include("views/overall/js.php"); ?>

	</body>
</html>
