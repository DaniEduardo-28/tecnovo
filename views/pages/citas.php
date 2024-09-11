<?php
  if (!isset($_SESSION['id_cliente'])) {
    header('location: ?view=login');
    exit();
  }
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Mis Citas | <?=APP_TITLE;?></title>
		<?php include("views/overall/header.php"); ?>
    <link rel="stylesheet" href="admin/resources/fullcalendar/fullcalendar.css">

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
                           <h2><span>Listado</span> Citas</h2>
                           <div class="car-icon"><img src="admin/resources/assets-web/img/dog.png" alt="car"></div>
                           <p>En esta sección podrás encontrar todas tus citas registradas en el sistema.</p>
                       </div>
                    </div>
               </div>

               <div class="row">

                 <div class="form-group col-sm-6">
                  <label for="cboSucursalBuscar">Sucursal</label>
                  <select class="form-control" id="cboSucursalBuscar" name="cboSucursalBuscar">
                    <?php
                      include("admin/core/models/ClassSucursal.php");
                      $dataSucursal = $OBJ_SUCURSAL->show(ID_EMPRESA,"1");
                      if ($dataSucursal["error"]=="NO") {
                         foreach ($dataSucursal["data"] as $key) {
                          ?>
                            <option value="<?=$key['id_sucursal'];?>"><?=$key['nombre'] . ' (' . $key['direccion'] . ') ' ?></option>
                          <?php
                         }
                      }
                     ?>
                  </select>
                 </div>

                 <div class="form-group col-sm-6">
                  <label for="cboMedicoBuscar">Médico</label>
                  <select class="form-control" id="cboMedicoBuscar" name="cboMedicoBuscar">

                  </select>
                 </div>

               </div>

               <div id="calendario" class="col-md-12">

           		</div>

            </div>
        </div>
        <!-- End Appointment Area -->

        <!-- Back Top top -->
        <a href="#content" class="back-to-top">Inicio</a>
        <!-- End Back Top top -->

        <!-- Modal -->
        <form action="#" method="post" id="frmDatos" name="frmDatos">
          <div class="modal fade" id="modal-calendario" tabindex="-1" role="dialog"
            aria-labelledby="modal-calendario-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal-calendario-label">Nueva Cita</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="col-md-12">

                    <div class="row">

                      <input type="hidden" id="id_cita" name="id_cita" value="">
                      <input type="hidden" id="id_trabajador" name="id_trabajador" value="">
                      <input type="hidden" id="id_sucursal" name="id_sucursal" value="">
                      <input type="hidden" id="name_sucursal" name="name_sucursal" value="">
                      <input type="hidden" id="valor_igv" name="valor_igv" value="<?=$dataResult[37]['valor_decimal'];?>">

                      <div class="form-group col-sm-12">
                        <label for="id_mascota">Mascota:</label>
                        <select name="id_mascota" id="id_mascota"
                          class="form-control" required="true">
                          <?php
                            include("admin/core/models/ClassMascota.php");
                            $dataMascota = $OBJ_MASCOTA->show_mis_mascotas($_SESSION['id_cliente']);
                            if ($dataMascota["error"]=="NO") {
                               foreach ($dataMascota["data"] as $key) {
                                ?>
                                  <option value="<?=$key['id_mascota'];?>"><?=$key['nombre'];?></option>
                                <?php
                               }
                            }
                           ?>
                        </select>
                      </div>

                      <div class="form-group col-sm-12">
                        <label for="cboServicioForm">Servicio:</label>
                        <select name="cboServicioForm" id="cboServicioForm"
                          class="form-control" required="true">

                        </select>
                      </div>

                      <div class="form-group col-sm-6">
                        <label for="txtFechaInicio">Fecha Inicio</label>
                        <input type="date" id="txtFechaInicio" name="txtFechaInicio"
                        value=""  class="form-control" required readonly>
                      </div>

                      <div class="form-group col-sm-6">
                        <label for="txtHoraInicio">Hora</label>
                        <input type="time" id="txtHoraInicio" name="txtHoraInicio"
                        value=""  class="form-control" required readonly>
                      </div>

                      <div class="form-group col-sm-6">
                        <label for="txtFechaTermino">Fecha Término</label>
                        <input type="date" id="txtFechaTermino" name="txtFechaTermino"
                        value=""  class="form-control" required readonly>
                      </div>

                      <div class="form-group col-sm-6">
                        <label for="txtHoraFin">Hora</label>
                        <input type="time" id="txtHoraFin" name="txtHoraFin"
                        value=""  class="form-control" required readonly>
                      </div>

                      <div class="form-group col-sm-12">
                        <label for="txtSintomas">Observaciones y/o Sintomas</label>
                        <textarea name="txtSintomas" rows="8" cols="80" class="form-control"
                          id="txtSintomas"></textarea>
                      </div>

                    </div>

                  </div>

                </div>

                <div class="modal-footer">

                  <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cerrar">

                  <button type="button" id="btnCancelar" class="btn btn-warning d-none">
                    Cancelar Cita
                  </button>

                  <input type="submit" name="btnSave" id="btnSave"
                  value="Guardar Cita" class="btn btn-success">

                </div>
              </div>
            </div>
          </div>
        </form>

				<!-- Footer Area -->
			<?php include("views/overall/footer.php"); ?>
			<?php include("views/overall/js.php"); ?>

      <script src="admin/resources/moment/min/moment.min.js"></script>
      <script src="admin/resources/fullcalendar/fullcalendar.min.js"></script>
      <script src="admin/resources/fullcalendar/locale/es.js"></script>
			<script src="admin/resources/system/js/pages/frontend/citas.js?v=<?=APP_VERSION;?>"></script>

	</body>
</html>
