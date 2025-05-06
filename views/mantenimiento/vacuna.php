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
    <title>Configuración de Vacunas | <?=APP_TITLE;?> </title>

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
                                      Configuración de Vacunas
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                              <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions" name="panelOptions">
                                <?php
                                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vacuna"));
                                    if ($access_options[0]['error']=="NO") {

                                      if ($access_options[0]['flag_agregar']) {
                                        ?>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top"
                                          title="" data-original-title="Agregar" id="btnAdd">
                                          <i class="fe fe-plus-circle btn btn-icon text-success"></i>
                                        </a>
                                        <?php
                                      }

                                      if ($access_options[0]['flag_buscar']) {
                                        ?>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top"
                                        title="" data-original-title="Actualizar listado" id="btnSearch">
                                          <i class="fa fa-refresh btn btn-icon text-primary"></i>
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
                                        <h4 class="card-title">Configuración de Vacunas</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="panelForm"> <!-- d-none -->
                                      <div class="ser-block block">

                                        <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos">

                                          <input type="hidden" name="id_vacuna" id="id_vacuna" value="">
                                          <input type="hidden" name="accion" id="accion" value="add">

                                          <div class="row">

                                            <div class="form-group col-md-4 col-sm-4" hidden>
                                              <label for="id_tipo_mascota" class="label-control">Tipo de Operación</label>
                                              <select name="id_tipo_mascota" id="id_tipo_mascota" class="form-control" required>
                                              <option selected="true" value="1"> Perro</option>
                                                <!-- <option value="">Seleccione...</option> -->
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

                                            <div class="form-group col-md-8 col-sm-8">
                                              <label for="name_vacuna" class="label-control">Vacuna</label>
                                              <input id="name_vacuna" type="text" name="name_vacuna" class="form-control"
                                              autocomplete="off" required data-msg="Campo obligatorio...">
                                            </div>

                                            <div class="form-group col-xs-12">
                                              <label for="descripcion" class="label-control">Descripción</label>
                                              <input id="descripcion" type="text" name="descripcion" class="form-control"
                                              autocomplete="off">
                                            </div>

                                            <div class="form-group col-md-3 col-sm-4">
                                              <label for="edad_minima" class="label-control" id="labelSize">Edad Mínima (días)</label>
                                              <input id="edad_minima" type="number" name="edad_minima" class="form-control"
                                              autocomplete="off" required min="1" value="1">
                                            </div>

                                            <div class="form-group col-md-3 col-sm-4">
                                              <label for="edad_maxima" class="label-control" id="labelSize">Edad Máxima (días)</label>
                                              <input id="edad_maxima" type="number" name="edad_maxima" class="form-control"
                                              autocomplete="off" required min="1" value="1">
                                            </div>

                                            <div class="form-group col-md-2 col-sm-2">
                                              <br>
                                              <div class="form-check">
                                                <input id="estado" name="estado" type="checkbox"
                                                class="form-check-input" checked>
                                                <label for="estado" class="form-check-label">Estado</label>
                                              </div>
                                            </div>

                                            <div class="form-group col-md-2 col-sm-2">
                                              <br>
                                              <div class="form-check">
                                                <input id="tipo_vacuna" name="tipo_vacuna" type="checkbox"
                                                class="form-check-input" checked>
                                                <label for="tipo_vacuna" class="form-check-label">Obligatorio</label>
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
                                      <div class="form-group col-md-4 col-sm-4" hidden>
                                        <label for="cboTipoBuscar" class="label-control">Tipo de Operación</label>
                                        <select name="cboTipoBuscar" id="cboTipoBuscar" class="form-control" required>
                                          <option value="all">Todos</option>
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
                                      <div class="user-block block">
                                        <div class="table-responsive">
                                          <table id="example" class="table table-bordered">
                                            <thead>
                                              <tr>
                                                <th style="width:50px; text-align: center;">#</th>
                                                <th>Id Vacuna</th>
                                                <th>Id Tipo Operación</th>
                                                <th>Tipo de Operación</th>
                                                <th>Vacuna</th>
                                                <th>Descrición</th>
                                                <th style="width:30px; text-align: center;">Edad Min.</th>
                                                <th style="width:30px; text-align: center;">Edad Max.</th>
                                                <th style="width:30px; text-align: center;">Estado</th>
                                                <th style="width:30px; text-align: center;">Tipo Vacuna</th>
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
    <script src="resources/system/js/pages/mantenimiento/vacuna.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menumantenimiento").addClass('active');
      $("#menuvacuna").addClass('active');
    </script>

  </body>
</html>
