<?php
  if (!isset($_SESSION['id_cliente'])) {
    header('location: ?view=login');
    exit();
  }
  require_once "admin/core/models/ClassUsuario.php";
  $result = $OBJ_USUARIO->getUserByCode($_SESSION['id_persona_cliente']);
  if ($result['error']=="SI") {
    header('location: ?view=index');
  }
  $dataUser = $result['data'];

 ?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Mi Perfil | <?=APP_TITLE;?></title>
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
                           <h2><span>Mi</span> Perfil</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>En esta sección actualizaras tus datos de contacto.</p>
                       </div>
                    </div>
               </div>
                <div class="row">
                    <div class="col-lg-5">
											<div class="form-group">
												<form id="frmSubirImagen" enctype="multipart/form-data" name="frmSubirImagen"
													onsubmit="UpdateImageProfile(event);" action="post">
													<img id="img_destino" src="admin/<?=$_SESSION['src_imagen_cliente'];?>" alt="Imagen de Perfil" class="img-fluid rounded-circle"
													width="200" height="200" style="width:200px;height:200px;">
													<br>
													<label for="">Imagen de Perfil</label>
													<br>
													<div class="form-group">
														<input type="file" name="txtImgProfile" id="txtImgProfile" accept="image/jpeg"
														class="is-valid" aria-invalid="false" required>
													</div>
													<button type="submit"class="btn theme-btn">Guardar Foto</button>
												</form>
											</div>
                    </div>
                    <div class="col-lg-7">

												<form onsubmit="UpdateDataProfile(event);" method="post" id="frmDatos" name="frmDatos">

														<div class="row">
															<div class="form-group col-sm-6">
																<label for="tipo_docu" class="label-control">Documento</label>
																<input id="tipo_docu" type="text" name="tipo_docu" class="form-control"
																readonly value="<?=strtoupper($dataUser[0]['name_documento']);?>">
															</div>
															<div class=" form-group col-sm-6">
																<label for="num_documento" class="label-control">Número</label>
																<input id="num_documento" type="text" name="num_documento" class="form-control"
																readonly value="<?=$dataUser[0]['num_documento'];?>">
															</div>
                            </div>

														<div class="row">
															<div class="form-group col-sm-6">
																<label for="txtNombres" class="label-control">Nombres</label>
																<input id="txtNombres" type="text" name="txtNombres" class="form-control"
																readonly value="<?=strtoupper($dataUser[0]['nombres']);?>">
															</div>
															<div class=" form-group col-sm-6">
																<label for="txtApellidos" class="label-control">Apellidos</label>
																<input id="txtApellidos" type="text" name="txtApellidos" class="form-control"
																readonly value="<?=strtoupper($dataUser[0]['apellidos']);?>">
															</div>
                            </div>

														<div class="row">
															<div class="form-group col-sm-12">
																<label for="txtEmail" class="label-control">Correo</label>
																<input id="txtEmail" type="email" name="txtEmail" class="form-control" autocomplete="off" readonly
																value="<?=strtoupper($dataUser[0]['correo']);?>" data-msg="Por favor ingrese un correo válido.">
															</div>
														</div>

                            <div class="row">
                               <div class="col-lg-12">
                                   <p>Actualizar Datos</p>
                               </div>
                            </div>

														<div class="row">
															<div class="form-group col-sm-12">
																<label for="txtAddress" class="label-control">Dirección</label>
																<input id="txtAddress" type="text" name="txtAddress" class="form-control"
																value="<?=strtoupper($dataUser[0]['direccion']);?>" autocomplete="off">
															</div>
														</div>

														<div class="row">
															<div class="form-group col-sm-6">
																<label for="txtPhone" class="label-control">Teléfono</label>
																<input id="txtPhone" type="tel" name="txtPhone" class="form-control"
																value="<?=strtoupper($dataUser[0]['telefono']);?>" autocomplete="off">
															</div>
															<div class="form-group col-sm-6">
																<label for="txtDateNac" class="label-control">Fecha Nacimiento</label>
																<input id="txtDateNac" type="text" name="txtDateNac" class="form-control date-picker-default"
																value="<?=date("d/m/Y", strtotime($dataUser[0]['fecha_nacimiento']))?>" autocomplete="off">
															</div>
														</div>

														<div class="row">
															<div class="form-group col-sm-6">
																<label for="sexo">Sexo</label>
																<select class="form-control" name="sexo" id="sexo">
																	<option value="">Seleccione</option>
																	<option value="masculino">Masculino</option>
																	<option value="femenino">Femenino</option>
																</select>
															</div>
														</div>

                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button class="btn theme-btn" type="submit">Actualizar Datos	</button>
                                </div>
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
			<script src="admin/resources/system/js/pages/frontend/miperfil.js?v=<?=APP_VERSION;?>"></script>

			<script>

			$('#sexo').val("<?=$dataUser[0]['sexo'];?>");
	     function mostrarImagen(input) {
	       if (input.files && input.files[0]) {
	         var reader = new FileReader();
	         reader.onload = function (e) {
	           $('#img_destino').attr('src', e.target.result);
	         }
	         reader.readAsDataURL(input.files[0]);
	       }
	     }
	       $("#txtImgProfile").change(function(){
	       mostrarImagen(this);
	     });
	   </script>

	</body>
</html>
