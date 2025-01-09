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
    <title>Aprobación de Cronograma | <?=APP_TITLE;?> </title>
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
                                  Cronograma
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">
                                  Atender</li>
                              </ol>
                            </nav>
                          </div>

                        </div>
                                <!-- end page title -->
                      </div>
                    </div>

                    <!-- Filtros -->
                    <div class="row">
                      <div class="container">
                        <div class="row" id="panelDetalle">

                          <div class="col-md-12">
                            <div class="ser-block block">

                                <input type="hidden" name="id_mascota" id="id_mascota" value="">
                                <input type="hidden" name="accion" id="accion" value="add">

                                <div class="row">

                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <img id="img_destino" src="resources/global/images/sin_imagen.png"
                                      alt="Imagen Operación" class="img-fluid rounded-circle"
                                      style="width:200px;height:200px;">
                                      <br>
                                      <label for="">Imagen Operación</label>
                                    </div>
                                  </div>

                                  <div class="col-sm-6">

                                    <br>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-prepend">
                                          <label class="input-group-text" for="id_tipo_mascota">&nbsp;&nbsp;<span class="fa fa-list"></span>&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        </div>
                                        <select class="custom-select form-control" id="id_tipo_mascota" name="id_tipo_mascota" disabled>
                                          <option value="">Tipo de Operación</option>
                                          <?php
                                            include("core/models/ClassTipoMascota.php");
                                            $dataTipoMascota = $OBJ_TIPO_MASCOTA->show("all");
                                            if ($dataTipoMascota["error"]=="NO") {
                                              foreach ($dataTipoMascota["data"] as $key) {
                                                echo '<option value="' . $key['id_tipo_mascota'] . '">' . $key['name_tipo'] . '</option>';
                                              }
                                            }
                                           ?>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-paw"></i>&nbsp;Nombre</span>
                                            <input type="text" class="form-control" name="nombre_mascota" placeholder="Nombre Operación"
                                            required="required" autocomplete="off" id="nombre_mascota" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-paw"></i>&nbsp;Raza&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <input type="text" class="form-control" name="raza"
                                            placeholder="Raza" disabled
                                            required="required" autocomplete="off" id="raza">
                                        </div>
                                    </div>

                                    <br>

                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-paw"></i>&nbsp; Color</span>
                                          <input type="text" class="form-control" name="color"
                                          placeholder="Color" disabled
                                          required="required" autocomplete="off" id="color">
                                      </div>
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-paw"></i>&nbsp; Peso</span>
                                          <input type="text" class="form-control" name="peso"
                                          placeholder="Peso"
                                          required="required" autocomplete="off" id="peso">
                                      </div>
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <label class="input-group-text" for="sexo">&nbsp;&nbsp;<span class="fa fa-paw"></span>&nbsp; Sexo</label>
                                      </div>
                                      <select class="custom-select form-control" id="sexo" name="sexo" disabled>
                                        <option value="">Sexo</option>
                                        <option value="macho">Macho</option>
                                        <option value="hembra">Hembra</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i>&nbsp; F. Nac.</span>
                                          <input type="text" class="form-control" name="fecha_nacimiento"
                                          placeholder="Fecha Nacimiento" disabled
                                          required="required" autocomplete="off" id="fecha_nacimiento">
                                      </div>
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i>&nbsp; Estado</span>
                                          <input type="text" class="form-control" name="estado"
                                          placeholder="Fecha Nacimiento" disabled
                                          required="required" autocomplete="off" id="estado">
                                      </div>
                                  </div>

                                  <div class="form-group col-sm-12 col-md-9">
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-paw"></i>&nbsp; Motivo de Cita</span>
                                          <input type="text" class="form-control" name="motivo"
                                          placeholder="Observaciones" disabled
                                          required="required" autocomplete="off" id="motivo">
                                      </div>
                                  </div>

                                </div>

                                <div class="row">

                                  <div class="form-group col-sm-6">
                                    <label for="sintomas_edit">Síntomas</label>
                                    <textarea name="sintomas_edit" rows="8" cols="80"
                                      class="form-control" id="sintomas_edit"></textarea>
                                  </div>
                                  <div class="form-group col-sm-6">
                                    <label for="tratamiento_edit">Tratamiento</label>
                                    <textarea name="tratamiento_edit" rows="8" cols="80"
                                      class="form-control" id="tratamiento_edit"></textarea>
                                  </div>
                                  <div class="form-group col-sm-6">
                                    <label for="vacunas_edit">Vacunas Aplicadas</label>
                                    <textarea name="vacunas_edit" rows="8" cols="80"
                                      class="form-control" id="vacunas_edit"></textarea>
                                  </div>
                                  <div class="form-group col-sm-6">
                                    <label for="observaciones_edit">Observaciones</label>
                                    <textarea name="observaciones_edit" rows="8" cols="80"
                                      class="form-control" id="observaciones_edit"></textarea>
                                  </div>

                                  <div class="form-group col-md-12">
                                    <button type="button" name="btnSave" id="btnSave" name="button" class="btn btn-success float-right"> <span class="fa fa-save"></span> Registrar Atención</button>
                                    <button type="reset" name="btnCancel" id="btnCancel" name="button" class="btn btn-warning float-right"> <span class="fa fa-arrow-left"></span> Volver</button>
                                  </div>

                                </div>

                            </div>
                          </div>

                        </div>

                         <div class="row" id="panelCalendario">

                           <div class="form-group col-sm-6 col-md-4">
                            <label for="cboDocumentoBuscar">Maquinaria</label>
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

                            <div class="col-md-8 col-sm-6">
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
                    <label for="name_mascota">Operación:</label>
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
              <button type="button" id="btnAtenderCita" class="btn btn-success"><span class="fa fa-check"></span> &nbsp;Atender Cita</button>

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
    <script src="resources/system/js/pages/citas/atencioncitas.js?v=<?=APP_VERSION;?>"></script>

   <script>
     $("#menucitas").addClass('active');
     $("#submenuatencioncitas").addClass('active');
   </script>

  </body>

</html>
