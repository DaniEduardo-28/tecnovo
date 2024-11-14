<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }
 ?>
<!DOCTYPE html>
<html>

  <head>
    <?php include("views/overall/header.php"); ?>
    <title>Gestionar Citas | <?=APP_TITLE;?> </title>
    <link rel="stylesheet" href="resources/fullcalendar/fullcalendar.css">

  </head>

  <body>

    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">

          <!-- begin pre-loader -->
          <?php include("views/overall/loader.php"); ?>
          <!-- end pre-loader -->

          <!-- begin app-top-nav -->
          <?php include("views/overall/topNav.php"); ?>
          <!-- end app-top-nav -->

          <!-- begin app-container -->
          <div class="app-container">

            <!-- begin app-nabar -->
            <?php include("views/overall/leftNav.php"); ?>
            <!-- end app-navbar -->

            <!-- begin app-main -->
              <div class="app-main" id="main">
                <!-- begin container-fluid -->
                <div class="container-fluid">
                  <!-- begin row -->
                  <div class="row">
                    <div class="col-md-12 m-b-30">
                      <!-- begin page title -->
                        <div class="d-block d-lg-flex flex-nowrap align-items-center">
                          <div class="page-title mr-4 pr-4 border-right">
                            <h1>Tablero</h1>
                          </div>
                          <div class="breadcrumb-bar align-items-center">
                            <nav>
                              <ol class="breadcrumb p-0 m-b-0">
                                <li class="breadcrumb-item">
                                  <a href="?view=home"><i class="ti ti-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                  Citas
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">
                                  Gestionar</li>
                              </ol>
                            </nav>
                          </div>

                        </div>
                                <!-- end page title -->
                      </div>
                    </div>

                    <div class="row">

                      <div class="container">

                         <div class="row">

                           <div class="form-group col-sm-6 col-md-4">
                            <label for="cboMedicoBuscar">Usuario</label>
                            <select class="form-control" id="cboMedicoBuscar" name="cboMedicoBuscar">
                              <option value="all">Todos</option>
                              <?php
                                include("core/models/ClassAccesoSucursal.php");
                                $dataMedico = $OBJ_ACCESO_SUCURSAL->getAccesoTrabajadorSucursal($_SESSION['id_fundo']);
                                if ($dataMedico["error"]=="NO") {
                                   foreach ($dataMedico["data"] as $key) {
                                    ?>
                                      <option value="<?=$key['id_trabajador'];?>"><?=$key['apellidos_trabajador'] . ' ' . $key['nombres_trabajador'] . ' (' . $key['name_especialidad'] . ') ' ?></option>
                                    <?php
                                   }
                                }
                               ?>
                            </select>
                           </div>

                           <div class="form-group col-sm-6 col-md-4">
                            <label for="cboDocumentoBuscar">Documento Cliente</label>
                            <select class="form-control" id="cboDocumentoBuscar" name="cboDocumentoBuscar">
                              <option value="all">Todos</option>
                              <?php
                                include("core/models/ClassDocumentoIdentidad.php");
                                $dataDocumento = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                                if ($dataDocumento["error"]=="NO") {
                                   foreach ($dataDocumento["data"] as $key) {
                                    ?>
                                      <option value="<?=$key['id_documento'];?>"><?=$key['name_documento'];?></option>
                                    <?php
                                   }
                                }
                               ?>
                            </select>
                           </div>

                            <div class="col-md-4 col-sm-12">
                              <label for="">&nbsp;</label>
                              <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search..."
                                aria-label="Recipient's username" aria-describedby="basic-addon2"
                                id="txtBuscar" name="txtBuscar">
                                <div class="input-group-append">
                                  <button class="btn btn-outline-primary" id="btnSearch" type="button">Buscar</button>
                                </div>
                              </div>
                            </div>

                         </div>

                         <div id="calendario" class="col-md-12">

                     		</div>

                      </div>

                    </div>

                  </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->

            <!-- begin footer -->
            <?php include("views/overall/footer.php"); ?>
            <!-- end footer -->

        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <!-- Modal ADD-->
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

                  <div class="form-group col-sm-12">
                   <label for="id_trabajador">Usuario</label>
                   <select class="form-control" id="id_trabajador" name="id_trabajador">
                      <?php
                      $dataMedico = $OBJ_ACCESO_SUCURSAL->getAccesoTrabajadorSucursal($_SESSION['id_fundo']);
                      if ($dataMedico["error"]=="NO") {
                         foreach ($dataMedico["data"] as $key) {
                          ?>
                            <option value="<?=$key['id_trabajador'];?>"><?=$key['apellidos_trabajador'] . ' ' . $key['nombres_trabajador'] . ' (' . $key['name_especialidad'] . ') ' ?></option>
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

                  <div class="form-group col-sm-12">
                   <label for="id_documento">Documento Cliente</label>
                   <select class="form-control" id="id_documento" name="id_documento">
                     <?php
                       $dataDocumento = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                       if ($dataDocumento["error"]=="NO") {
                          foreach ($dataDocumento["data"] as $key) {
                           ?>
                             <option value="<?=$key['id_documento'];?>"><?=$key['name_documento'];?></option>
                           <?php
                          }
                       }
                      ?>
                   </select>
                  </div>

                  <div class="col-md-12">
                    <label for="num_documento">Número de documento</label>
                    <div class="input-group mb-3">
                      <input type="number" class="form-control"
                      aria-label="Recipient's username" aria-describedby="basic-addon2"
                      id="num_documento" name="num_documento">
                      <div class="input-group-append">
                        <button class="btn btn-outline-primary" id="btnBuscarMascotas" type="button">Buscar Mascotas</button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-sm-12">
                    <label for="id_mascota">Mascota:</label>
                    <select name="id_mascota" id="id_mascota"
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

              <input type="submit" name="btnSave" id="btnSave"
              value="Guardar Cita" class="btn btn-success">

            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- END MODAL ADD-->

    <!-- Modal EDIT-->
    <form action="#" method="post" id="frmDatosView" name="frmDatosView">
      <div class="modal fade" id="modal-calendario-show" tabindex="-1" role="dialog"
        aria-labelledby="modal-calendario-show-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-calendario-show-label">Datos de cita</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="col-md-12">

                <div class="row">

                  <input type="hidden" id="id_cita" name="id_cita" value="">

                  <div class="form-group col-sm-12">
                   <label for="name_medico">Usuario</label>
                   <input type="text" id="name_medico" value="" class="form-control" readonly>
                  </div>

                  <div class="form-group col-sm-12">
                    <label for="name_servicio">Servicio:</label>
                    <input type="text" id="name_servicio" value="" class="form-control" readonly>
                  </div>

                  <div class="form-group col-sm-12">
                   <label for="name_documento">Documento Cliente</label>
                   <input type="text" id="name_documento" value="" class="form-control" readonly>
                  </div>

                  <div class="col-md-12">
                    <label for="num_documento_show">Número de documento</label>
                    <input type="text" id="num_documento_show" value="" class="form-control" readonly>
                  </div>

                  <div class="form-group col-sm-12">
                    <label for="name_mascota">Mascota:</label>
                    <input type="text" id="name_mascota" value="" class="form-control" readonly>
                  </div>

                  <div class="form-group col-sm-6">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    <input type="text" id="fecha_inicio" value="" class="form-control" readonly>
                  </div>

                  <div class="form-group col-sm-6">
                    <label for="fecha_fin">Fecha Fin</label>
                    <input type="text" id="fecha_fin" value="" class="form-control" readonly>
                  </div>

                  <div class="form-group col-sm-12">
                    <label for="sintomas">Observaciones y/o Sintomas</label>
                    <textarea name="sintomas" rows="8" cols="80" class="form-control"
                      id="sintomas" readonly></textarea>
                  </div>

                </div>

              </div>

            </div>

            <div class="modal-footer">

              <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cerrar">
              <button type="button" id="btnCancelarCita" class="btn btn-warning"><span class="fa fa-ban"></span> &nbsp;Cancelar Cita</button>
              <button type="button" id="btnAceptarCita" class="btn btn-success"><span class="fa fa-check"></span> &nbsp;Aceptar Cita</button>
              <button type="button" id="btnAnularCita" class="btn btn-warning"><span class="fa fa-ban"></span> &nbsp;Anular Cita</button>

            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- END MODAL EDIT-->

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/moment/min/moment.min.js"></script>
    <script src="resources/fullcalendar/fullcalendar.min.js"></script>
    <script src="resources/fullcalendar/locale/es.js"></script>
    <script src="resources/system/js/pages/citas/citas.js?v=<?=APP_VERSION;?>"></script>

   <script>
     $("#menucitas").addClass('active');
     $("#submenucitas").addClass('active');
   </script>
  </body>

</html>
