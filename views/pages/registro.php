<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Registrarse | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>

	</head>

	<body>

				<!-- Preloader -->
					<?php include("views/overall/pre-loader.php"); ?>
				<!-- End Preloader -->

        <!-- Sign Up Form Area -->
        <div class="content-block-area gray-bg">
            <div class="signup-form">
                <div class="logo-two">
                    <a href="<?=APP_URL;?>">
                        <img src="admin/resources/assets-web/img/logo.png" alt="Logo">
                    </a>
                </div>

                <form id="frmRegistro" onsubmit="goRegistro(event);">
                    <h2>Crear Cuenta</h2>
                    <p class="lead">Es gratis y apenas lleva solo 30 segundos.</p>

										<div class="form-group">
			                <select name="id_documento" id="id_documento" class="form-control">
			                  <option value="">Documento...</option>
			                  <?php
			                    require("admin/core/models/ClassDocumentoIdentidad.php");
			                    $resultDocIde = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
			                    if ($resultDocIde['error']=="NO") {
			                      foreach ($resultDocIde['data'] as $key) {
			                        echo "<option value='" . $key['id_documento'] . "'>" . $key['name_documento'] . "</option>";
			                      }
			                    }
			                  ?>
			                </select>
			              </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card-o"></i></span>
                            <input type="number" class="form-control" name="num_documento" placeholder="Número de documento"
														required="required" autocomplete="off" id="num_documento">
                        </div>
                    </div>

										<div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" name="nombres" placeholder="Nombres"
														required="required" autocomplete="off" id="nombres">
                        </div>
                    </div>

										<div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" name="apellidos" placeholder="Apellidos"
														required="required" autocomplete="off" id="apellidos">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                            <input type="email" class="form-control" name="correo" placeholder="Correo electrónico"
														required="required" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Contraseña" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-lock"></i>
                                <i class="fa fa-check"></i>
                            </span>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar contraseña" required="required">
                        </div>
                    </div>

										<div class="form-group" id="__ajax__">

										</div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Registrarse</button>
                    </div>

                    <p class="small text-center">Al hacer clic en el botón Registrarse, usted acepta nuestros <br>
											<a href="#">Términos &amp; Condiciones</a>, y <a href="#">Políticas de Privacidad</a>.</p>

                </form>
                <p class="text-center">¿Ya tienes una cuenta? <a href="?view=login">Inicia Sesión Aquí</a>.</p>
            </div>
        </div>
        <!-- End Sign Up Form Area -->



		<?php include("views/overall/js.php"); ?>
		<script src="admin/resources/system/js/pages/frontend/registro.js?v=<?=APP_VERSION;?>"></script>

	</body>
</html>
