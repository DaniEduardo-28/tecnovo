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
    <title>Mascotas | <?=APP_TITLE;?> </title>

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
                                      Mantenimiento
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">
                                      Mascotas
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                              <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions" name="panelOptions">
                                <?php
                                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("mascota"));
                                    if ($access_options[0]['error']=="NO") {

                                      if ($access_options[0]['flag_agregar']) {
                                        ?>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top"
                                          title="" data-original-title="Agregar" id="btnAdd">
                                          <i class="fe fe-plus-circle btn btn-icon text-success"></i>
                                        </a>
                                        <?php
                                      }

                                      if ($access_options[0]['flag_descargar']) {
                                        ?>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="Descargar en excel">
                                          <i class="fa fa-file-excel-o btn btn-icon text-success"></i>
                                        </a>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                                         data-original-title="Descargar en pdf">
                                          <i class="fa fa-file-pdf-o btn btn-icon text-danger"></i>
                                        </a>
                                        <?php
                                      }
                                    }
                                 ?>
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
                                        <h4 class="card-title">Mascotas</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="panelForm"> <!-- d-none -->
                                      <div class="ser-block block">

                                        <form id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                                          <input type="hidden" name="id_mascota" id="id_mascota" value="">
                                          <input type="hidden" name="flag_imagen" id="flag_imagen" value="0">
                                          <input type="hidden" name="accion" id="accion" value="add">

                                          <div class="row">

                                            <div class="col-sm-6">
                                              <div class="form-group">
                                                <img id="img_destino" src="resources/global/images/sin_imagen.png"
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

                                            <div class="col-sm-6">

                                              <br>
                                              <div class="form-group">
                                                <div class="input-group">
                                                  <div class="input-group-prepend">
                                                    <label class="input-group-text" for="id_documento">&nbsp;&nbsp;<span class="fa fa-list"></span>&nbsp;</label>
                                                  </div>
                                                  <select class="custom-select form-control" id="id_documento" name="id_documento">
                                                    <option value="">Documento de Identidad</option>
                                                    <?php
                            			                    require("core/models/ClassDocumentoIdentidad.php");
                            			                    $resultDocIde = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                            			                    if ($resultDocIde['error']=="NO") {
                            			                      foreach ($resultDocIde['data'] as $key) {
                            			                        echo "<option value='" . $key['id_documento'] . "'>" . $key['name_documento'] . "</option>";
                            			                      }
                            			                    }
                            			                  ?>
                                                  </select>
                                                </div>
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
                                                      <input type="text" class="form-control" name="nombres" placeholder="Nombres Cliente"
                          														required="required" autocomplete="off" id="nombres">
                                                  </div>
                                              </div>

                          										<div class="form-group">
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                                      <input type="text" class="form-control" name="apellidos" placeholder="Apellidos Cliente"
                          														required="required" autocomplete="off" id="apellidos">
                                                  </div>
                                              </div>
                                              <br>

                                            </div>

                                            <div class="form-group col-sm-6">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <label class="input-group-text" for="id_tipo_mascota">&nbsp;&nbsp;<span class="fa fa-list"></span>&nbsp;</label>
                                                </div>
                                                <select class="custom-select form-control" id="id_tipo_mascota" name="id_tipo_mascota">
                                                  <option value="">Tipo de Mascota</option>
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

                                            <div class="form-group col-sm-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                                    <input type="text" class="form-control" name="nombre_mascota" placeholder="Nombre Mascota"
                        														required="required" autocomplete="off" id="nombre_mascota">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 col-sm-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                                    <input type="text" class="form-control" name="raza"
                                                    placeholder="Raza"
                                                    required="required" autocomplete="off" id="raza">
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-6 col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                                    <input type="text" class="form-control" name="color"
                                                    placeholder="Color"
                                                    required="required" autocomplete="off" id="color">
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-6 col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                                    <input type="text" class="form-control" name="peso"
                                                    placeholder="Peso"
                                                    required="required" autocomplete="off" id="peso">
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-6 col-md-3">
                                              <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <label class="input-group-text" for="sexo">&nbsp;&nbsp;<span class="fa fa-paw"></span>&nbsp;</label>
                                                </div>
                                                <select class="custom-select form-control" id="sexo" name="sexo">
                                                  <option value="">Sexo</option>
                                                  <option value="macho">Macho</option>
                                                  <option value="hembra">Hembra</option>
                                                </select>
                                              </div>
                                            </div>

                                            <div class="form-group col-sm-6 col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="date" class="form-control" name="fecha_nacimiento"
                                                    placeholder="Fecha Nacimiento"
                                                    required="required" autocomplete="off" id="fecha_nacimiento">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 col-sm-6">
                                              <div class="form-check">
                                                <input id="estado" name="estado" type="checkbox"
                                                class="form-check-input" checked>
                                                <label for="estado" class="form-check-label">Estado</label>
                                              </div>
                                            </div>

                                            <div class="form-group col-sm-12 col-md-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                                    <input type="text" class="form-control" name="observaciones"
                                                    placeholder="Observaciones"
                                                    required="required" autocomplete="off" id="observaciones">
                                                </div>
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

                                      <div class="row">
                                        <div class="form-group col-md-3 col-sm-6">
                                          <label for="cboTipoBuscar" class="label-control">Tipo de Mascota</label>
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
                                                <th>Id Mascota</th>
                                                <th>Cliente</th>
                                                <th>Tipo de Mascota</th>
                                                <th>Nombre</th>
                                                <th style="width:30px; text-align: center;">Raza</th>
                                                <th style="width:30px; text-align: center;">Color</th>
                                                <th style="width:30px; text-align: center;">Peso</th>
                                                <th style="width:30px; text-align: center;">F. Nac</th>
                                                <th style="width:30px; text-align: center;">Estado</th>
                                                <th style="width:90px;">Opciones</th>
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

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/mantenimiento/mascota.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menumantenimiento").addClass('active');
      $("#menumascota").addClass('active');
    </script>

  </body>
</html>
