<?php
  if (!isset($_SESSION['id_cliente'])) {
    header('location: ?view=login');
    exit();
  }
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Mis Mascotas | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
    <!-- Datatable-->
    <link rel="stylesheet" href="admin/resources/global/css/datatable.css">
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
                           <h2><span>Listado</span> Mascotas</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>En esta sección podrás encontrar todas tus mascotas registradas en el sistema.</p>
                       </div>
                    </div>
                    <div class="col-xs-12" id="panelOptions">
                      <button href="#" class="btn theme-btn pull-right" data-toggle="tooltip" data-placement="top"
                        title="" data-original-title="Agregar" id="btnAdd">
                        <i class="fa fa-plus"></i> &nbsp; Agregar
                      </button>
                    </div>
               </div>

               <div class="row">

                 <div class="col-md-12" id="panelForm"> <!-- d-none -->
                   <div class="ser-block block">

                     <form id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                       <input type="hidden" name="id_mascota" id="id_mascota" value="">
                       <input type="hidden" name="flag_imagen" id="flag_imagen" value="0">
                       <input type="hidden" name="accion" id="accion" value="add">

                       <div class="row">

                         <div class="col-sm-12">
                           <div class="form-group">
                             <img id="img_destino" src="admin/resources/global/images/sin_imagen.png"
                             alt="Imagen Mascota" class="img-fluid rounded-circle"
                             style="width:200px;height:200px;">
                             <br>
                             <label for="">Imagen Mascota</label>
                             <br>
                             <div class="form-group">
                               <input type="file" name="src_imagen" id="src_imagen" accept="image/jpeg"
                               class="is-valid" aria-invalid="false">
                             </div>
                           </div>
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                           <label for="id_tipo_mascota">Tipo de Mascota</label>
                           <select class="form-control" id="id_tipo_mascota" name="id_tipo_mascota">
                             <option value="">Seleccione</option>
                             <?php
                               include("admin/core/models/ClassTipoMascota.php");
                               $dataTipoMascota = $OBJ_TIPO_MASCOTA->show("all");
                               if ($dataTipoMascota["error"]=="NO") {
                                 foreach ($dataTipoMascota["data"] as $key) {
                                   echo '<option value="' . $key['id_tipo_mascota'] . '">' . $key['name_tipo'] . '</option>';
                                 }
                               }
                              ?>
                           </select>
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                            <label for="nombre_mascota">Nombre de Mascota</label>
                            <input type="text" class="form-control" name="nombre_mascota"
                            required="required" autocomplete="off" id="nombre_mascota">
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                            <label for="raza">Raza</label>
                            <input type="text" class="form-control" name="raza"
                            required="required" autocomplete="off" id="raza">
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                            <label for="color">Color</label>
                            <input type="text" class="form-control" name="color"
                            required="required" autocomplete="off" id="color">
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                            <label for="peso">Peso</label>
                            <input type="text" class="form-control" name="peso"
                            required="required" autocomplete="off" id="peso">
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                           <label for="sexo">Sexo</label>
                           <select class="custom-select form-control" id="sexo" name="sexo">
                             <option value="">Seleccione</option>
                             <option value="macho">Macho</option>
                             <option value="hembra">Hembra</option>
                           </select>
                         </div>

                         <div class="form-group col-sm-6 col-md-3">
                           <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                           <input type="date" class="form-control" name="fecha_nacimiento"
                           value="<?=date('Y-m-d');?>"
                           required="required" autocomplete="off" id="fecha_nacimiento">
                         </div>

                         <div class="form-group col-md-3 col-sm-6">
                           <label for="">&nbsp;</label>
                           <div class="form-check">
                             <input id="estado" name="estado" type="checkbox"
                             class="checkbox" checked>
                             <label for="estado" class="form-check-label">Estado</label>
                           </div>
                         </div>

                         <div class="form-group col-sm-12">
                            <label for="observaciones">Observaciones</label>
                            <input type="text" class="form-control" name="observaciones"
                            required="required" autocomplete="off" id="observaciones">
                         </div>

                         <div class="form-group col-md-12">
                           <button type="submit" name="btnSave" id="btnSave" name="button" class="btn btn-success float-right"> <span class="fa fa-save"></span> Guardar</button>
                           <button type="reset" name="btnCancel" id="btnCancel" name="button" class="btn btn-danger float-right"> <span class="fa fa-close"></span> Cancelar</button>
                         </div>
                       </div>

                     </form>
                   </div>
                 </div>

                 <div class="col-md-12" id="panelTabla">

                   <div class="table-responsive">
                     <table id="example" class="table table-bordered">
                       <thead>
                         <tr>
                           <th style="width:50px; text-align: center;">#</th>
                           <th>Id Mascota</th>
                           <th>Cliente</th>
                           <th>Tipo de Mascota</th>
                           <th>Nombre</th>
                           <th style="width:30px; text-align: center;">Raza</th>
                           <th style="width:30px; text-align: center;">Color</th>
                           <th style="width:30px; text-align: center;">Peso</th>
                           <th style="width:30px; text-align: center;">F. Nac</th>
                           <th style="width:30px; text-align: center;">Estado</th>
                           <th style="width:150px;">Opciones</th>
                         </tr>
                       </thead>
                     </table>
                   </div>

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
      <script src="admin/resources/global/js/datatable.js"></script>
			<script src="admin/resources/system/js/pages/frontend/mascotas.js?v=<?=APP_VERSION;?>"></script>

	</body>
</html>
