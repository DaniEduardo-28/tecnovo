<?php
  if (!isset($_SESSION['id_cliente'])) {
    header('location: ?view=login');
    exit();
  }
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Cambiar Contraseña | <?=APP_TITLE;?></title>
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
                           <h2><span>Cambiar</span> Contraseña</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>En esta sección podrás cambiar tu contraseña.</p>
                       </div>
                    </div>
               </div>
                <div class="row">
                    <div class="col-lg-12">
                      <form onsubmit="UpdatePassword(event);" method="post" id="frmDatos" name="frmDatos">

                        <div class="row">

                          <div class="form-group col-md-3"></div>
                          <div class="form-group col-md-6">
                            <label for="txtPassOld" class="label-control">Clave Actual</label>
                            <input id="txtPassOld" type="password" name="txtPassOld" class="form-control"
                            autocomplete="off" required data-msg="Por favor ingrese su clave actual.">
                          </div>
                          <div class="form-group col-md-3"></div>

                          <div class="form-group col-md-3"></div>
                          <div class="form-group col-md-6">
                            <label for="txtNewPass" class="label-control">Nueva Clave</label>
                            <input id="txtNewPass" type="password" name="txtNewPass" class="form-control"
                            autocomplete="off" data-msg="Por favor ingrese una nueva clave de acceso." required>
                          </div>
                          <div class="form-group col-md-3"></div>

                          <div class="form-group col-md-3"></div>
                          <div class="form-group col-md-6">
                            <label for="txtNewPass1" class="label-control">Repetir Clave</label>
                            <input id="txtNewPass1" type="password" name="txtNewPass1" class="form-control" required
                            autocomplete="off" data-msg="Por favor repita su nueva clave de acceso.">
                          </div>
                          <div class="form-group col-md-3"></div>

                          <div class="form-group col-md-3"></div>
                          <div class="form-group col-md-6">
                            <button type="submit" name="btnGuardar" id="btnGuardar" class="btn theme-btn">
                              Actualizar Clave
                            </button>
                          </div>
                          <div class="form-group col-md-3"></div>

                        </div>

                      </form>
                    </div>
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
			<script src="admin/resources/system/js/pages/frontend/cambiarclave.js?v=<?=APP_VERSION;?>"></script>

	</body>
</html>
