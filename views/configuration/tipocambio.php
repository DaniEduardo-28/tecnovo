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
    <title>Tipo de Cambio | <?=APP_TITLE;?> </title>

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
                                      Configuración
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">
                                      Tipo de Cambio
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                              <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions" name="panelOptions">
                                <?php
                                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipocambio"));
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
                                        <h4 class="card-title">Tipo de Cambio</h4>
                                    </div>
                                </div>
                                <div class="card-header" id="panelOptions2">
                                  <div class="row">
                                    <div class="form-group col-md-4 col-sm-6">
                                      <label for="fecha_inicio">Fecha Inicio</label>
                                      <input type="date" name="fecha_inicio" id="fecha_inicio"
                                      value="<?=date('Y-m-d');?>" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-6">
                                      <label for="fecha_fin">Fecha Inicio</label>
                                      <input type="date" name="fecha_fin" id="fecha_fin"
                                      value="<?=date('Y-m-d');?>" class="form-control">
                                    </div>
                                  </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="panelForm"> <!-- d-none -->
                                      <div class="ser-block block">
                                        <form action="#" method="post" id="frmDatos" name="frmDatos">

                                          <div class="row">
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="">Moneda</label>
                                              <select class="form-control" name="id_moneda" id="id_moneda" required>
                                                <option value="">Seleccionar</option>
                                                <?php
                                                  include("core/models/ClassMoneda.php");
                                                  $dataMoneda = $OBJ_MONEDA->show("1");
                                                  if ($dataMoneda["error"]=="NO") {
                                                    foreach ($dataMoneda["data"] as $key) {
                                                      if ($key['flag_principal']=="0") {
                                                        echo '<option value="' . $key['id_moneda'] . '">' . $key['name_moneda'] . '</option>';
                                                      }
                                                    }
                                                  }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="tipo_cambio" class="label-control">Tipo de Cambio</label>
                                              <input id="tipo_cambio" type="number" name="tipo_cambio" class="form-control"
                                              autocomplete="off" required data-msg="Campo obligatorio..." value="3.00" min="0.1" step="0.01">
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
                                      <div class="user-block block">
                                        <div class="table-responsive">
                                          <table id="example" class="table table-bordered">
                                            <thead>
                                              <tr>
                                                <th style="width:50px; text-align: center;">#</th>
                                                <th>Id Moneda</th>
                                                <th>Moneda</th>
                                                <th>Usuario</th>
                                                <th>Fecha</th>
                                                <th style="width: 40px;">Tipo Cambio</th>
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
    <script src="resources/system/js/pages/configuration/tipocambio.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menuconfiguration").addClass('active');
      $("#menutipocambio").addClass('active');
    </script>

  </body>

</html>
