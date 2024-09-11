<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Iniciar Sesión | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>

	</head>

	<body>

        <!-- Preloader -->
      <?php include("views/overall/pre-loader.php"); ?>
        <!-- End Preloader -->

        <!-- Sign In Form Area -->
        <div class="content-block-area gray-bg">
            <div class="signup-form signin-form">
                <div class="logo-two">
                    <a href="<?=APP_URL;?>">
                        <img src="admin/resources/assets-web/img/logo.png" alt="Logo">
                    </a>
                </div>

                <form id="frmLogin" onsubmit="goLogin(event);">
                    <h2>Iniciar Sesión</h2>
	                    <p class="lead">Es gratis y apenas lleva más de 30 segundos.</p>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Correo electrónico ..."
														required="required" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Contraseña ..."
														required="required">
                        </div>
                    </div>
										<div class="form-group" id="__ajax__">

										</div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Iniciar Sesión</button>
                    </div>
                    <p class="small text-center">Al hacer clic en el botón Iniciar sesión, aceptas nuestros
											<br><a href="#">Términos &amp; Condiciones</a>, y <a href="#">Políticas de Privacidad</a>.</p>
                </form>
                <p class="text-center">¿No tienes una cuenta? <a href="?view=registro">Registrate Aquí</a>.</p>
            </div>
        </div>
        <!-- End Sign In Form Area -->


		<?php include("views/overall/js.php"); ?>
		<script src="admin/resources/system/js/pages/frontend/index.js?v=<?=APP_VERSION;?>"></script>

	</body>
</html>
