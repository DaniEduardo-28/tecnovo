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
    <title>Ficha de Operaciones | <?=APP_TITLE;?> </title>

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
                                      Operaciones
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">
                                      Ficha de Operaciones
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                            </div>
                                    <!-- end page title -->
                          </div>
                        </div>

                        <div class="row">

                            <div class="col-xl-12">
                              <div class="card card-statistics">
                                <div class="card-header">
                                    <div class="card-heading">
                                        <h4 class="card-title">Registro de Vacunas</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="HTMLtoPDF"> <!-- d-none -->
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
                                                    placeholder="Peso" disabled
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
                                                    <input type="date" class="form-control" name="fecha_nacimiento"
                                                    placeholder="Fecha Nacimiento" disabled
                                                    required="required" autocomplete="off" id="fecha_nacimiento">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 col-sm-6">
                                              <div class="form-check">
                                                <input id="estado" name="estado" type="checkbox"
                                                class="form-check-input" checked disabled>
                                                <label for="estado" class="form-check-label">Estado</label>
                                              </div>
                                            </div>

                                            <div class="form-group col-sm-12 col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-paw"></i>&nbsp; Observaciones</span>
                                                    <input type="text" class="form-control" name="observaciones"
                                                    placeholder="Observaciones" disabled
                                                    required="required" autocomplete="off" id="observaciones">
                                                </div>
                                            </div>

                                          </div>

                                          <div class="row">

                                            <div class="table-responsive">
                                              <table id="example1" class="table table-bordered">
                                                <thead>
                                                  <tr>
                                                    <th style="width:90px;">Acciones</th>
                                                    <th style="width:50px; text-align: center;">#</th>
                                                    <th>Id Operación Vacuna</th>
                                                    <th>Id Vacuna</th>
                                                    <th>Vacuna</th>
                                                    <th>Fecha Mínima</th>
                                                    <th>Fecha Máxima</th>
                                                    <th style="width:150px;">Observaciones</th>
                                                    <th>Estado</th>
                                                    <th>Sucursal</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha Aplicación</th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                            <div class="col-sm-12">
                                              <br>&nbsp;<br>
                                            </div>
                                            <div class="form-group col-md-12">
                                              <button type="button" name="btnImprimir" id="btnImprimir" name="button" class="btn btn-primary float-right"> <span class="fa fa-print"></span> Imprimir Ficha</button>
                                              <button type="reset" name="btnCancel" id="btnCancel" name="button" class="btn btn-warning float-right"> <span class="fa fa-arrow-left"></span> Volver</button>
                                              <!-- Button trigger modal -->
                                              <button type="button" class="btn btn-success float-left" data-toggle="modal"
                                              data-target="#modalRegistrarVacuna">
                                                Agregar Vacuna
                                              </button>
                                            </div>

                                          </div>
                                      </div>
                                    </div>

                                    <div class="col-md-12" id="panelTabla">

                                      <div class="row">
                                        <div class="form-group col-md-3 col-sm-6" hidden>
                                          <label for="cboTipoBuscar" class="label-control">Tipo de Operación</label>
                                          <select name="cboTipoBuscar" id="cboTipoBuscar" class="form-control">
                                            <option value="">Todos</option>
                                            <?php
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
                                          <label for="cboDocumentoBuscar">Documento de Identidad</label>
                                          <select class="form-control" id="cboDocumentoBuscar" name="cboDocumentoBuscar">
                                            <option value="">Todos</option>
                                            <?php
                                              include("core/models/ClassDocumentoIdentidad.php");
                                              $resultDocIde = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                                              if ($resultDocIde['error']=="NO") {
                                                foreach ($resultDocIde['data'] as $key) {
                                                  echo "<option value='" . $key['id_documento'] . "'>" . $key['name_documento'] . "</option>";
                                                }
                                              }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                          <label for="">&nbsp;</label>
                                          <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search..." aria-label="Recipient's username"
                                            aria-describedby="basic-addon2" id="txtBuscar" name="txtBuscar">
                                            <div class="input-group-append">
                                              <button class="btn btn-outline-primary" id="btnSearch" type="button">Buscar</button>
                                            </div>
                                          </div>
                                        </div>

                                      </div>

                                      <div class="row">
                                        <br>
                                      </div>

                                      <div class="user-block block">
                                        <div class="table-responsive">
                                          <table id="example" class="table table-bordered">
                                            <thead>
                                              <tr>
                                                <th style="width:50px; text-align: center;">#</th>
                                                <th>Id Operación</th>
                                                <th>Cliente</th>
                                                <th>Tipo de Operación</th>
                                                <th>Nombre</th>
                                                <th style="width:30px; text-align: center;">Raza</th>
                                                <th style="width:30px; text-align: center;">Color</th>
                                                <th style="width:30px; text-align: center;">Peso</th>
                                                <th style="width:30px; text-align: center;">F. Nac</th>
                                                <th style="width:30px; text-align: center;">Estado</th>
                                                <th style="width:90px;">Ver Ficha</th>
                                              </tr>
                                            </thead>
                                          </table>
                                        </div>
                                      </div>

                                    </div>

                                  </div>

                                </div>
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

    <!-- Modal -->
    <div class="modal fade" id="modalRegistrarVacuna" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form id="frmDatos" method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Registrar Vacuna</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_mascota_edit" id="id_mascota_edit">
              <div class="form-group">
                <label for="id_vacuna_edit">Vacuna</label>
                <select class="form-control" name="id_vacuna_edit" id="id_vacuna_edit">

                </select>
              </div>
              <div class="form-group">
                <label for="observaciones_edit">Observaciones</label>
                <textarea name="observaciones_edit" id="observaciones_edit"
                rows="8" cols="80" class="form-control"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-success" id="btnSave">Registrar Vacuna</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/operaciones/fichamascota.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menuoperaciones").addClass('active');
      $("#submenufichamascota").addClass('active');
    </script>

  </body>
</html>
