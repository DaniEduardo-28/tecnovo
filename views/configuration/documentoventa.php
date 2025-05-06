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
  <title>Documentos de Ingreso y Salida | <?= APP_TITLE; ?> </title>

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
                          Configuración
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                          Documentos de Ingreso y Salida
                        </li>
                      </ol>
                    </nav>
                  </div>

                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions"
                    name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("documentoventa"));
                    if ($access_options[0]['error'] == "NO") {

                      if ($access_options[0]['flag_agregar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="Agregar" id="btnAdd">
                          <i class="fe fe-plus-circle btn btn-icon text-success"></i>
                        </a>
                        <?php
                      }

                      if ($access_options[0]['flag_buscar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="Actualizar listado" id="btnSearch">
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
                      <h4 class="card-title">Documentos de Ingreso y Salida</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12" id="panelForm"> <!-- d-none -->
                        <div class="ser-block block">

                          <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos">

                            <input type="hidden" name="id_documento_venta" id="id_documento_venta" value="">
                            <input type="hidden" name="accion" id="accion" value="add">

                            <div class="row">
                              <div class="form-group col-md-4 col-sm-6">
                                <label for="nombre" class="label-control">Nombre Documento</label>
                                <input id="nombre" type="text" name="nombre" class="form-control" autocomplete="off"
                                  required data-msg="Campo obligatorio...">
                              </div>
                              <div class="form-group col-md-4 col-sm-6">
                                <label for="nombre_corto" class="label-control">Nombre Corto</label>
                                <input id="nombre_corto" type="text" name="nombre_corto" class="form-control"
                                  autocomplete="off" required data-msg="Campo obligatorio...">
                              </div>
                              <div class="form-group col-md-4 col-sm-3">
                                <label for="cod_sunat" class="label-control">Código Sunat</label>
                                <input id="cod_sunat" type="text" name="cod_sunat" class="form-control"
                                  autocomplete="off" data-msg="Campo obligatorio...">
                              </div>
                              <div class="form-group col-md-4 col-sm-3">
                                <label for="serie" class="label-control">Serie</label>
                                <input id="serie" type="text" name="serie" class="form-control" autocomplete="off"
                                  data-msg="Campo obligatorio...">
                              </div>
                              <div class="form-group col-md-4 col-sm-6">
                                <label for="correlativo" class="label-control">Correlativo</label>
                                <input id="correlativo" type="number" name="correlativo" class="form-control"
                                  autocomplete="off" data-msg="Campo obligatorio..." value="1" step="1" min="1">
                              </div>
                              <div class="form-group col-md-4 col-sm-3">
                                <br>
                                <div class="form-check">
                                  <input id="estado" name="estado" type="checkbox" class="form-check-input" checked>
                                  <label for="estado" class="form-check-label">Activo</label>
                                </div>
                              </div>
                              <div class="form-group col-md-4 col-sm-3 d-none">
                                <br>
                                <div class="form-check">
                                  <input id="flag_doc_interno" name="flag_doc_interno" type="checkbox"
                                    class="form-check-input">
                                  <label for="flag_doc_interno" class="form-check-label">¿Documento Interno?</label>
                                </div>
                              </div>

                              <div class="form-group col-md-8 d-flex align-items-center">
                                <div class="form-check mr-3">
                                  <input id="flag_ingreso" name="flag_ingreso" type="checkbox" class="form-check-input">
                                  <label for="flag_ingreso" class="form-check-label">Documento de Ingreso</label>
                                </div>
                                <div class="form-check">
                                  <input id="flag_salida" name="flag_salida" type="checkbox" class="form-check-input">
                                  <label for="flag_salida" class="form-check-label">Documento de Salida</label>
                                </div>
                              </div>

                              <div class="form-group col-md-12">
                                <button type="submit" name="btnSave" id="btnSave" name="button"
                                  class="btn btn-success float-right"> <span class="fa fa-save"></span> Guardar</button>
                                <button type="reset" name="btnCancel" id="btnCancel" name="button"
                                  class="btn btn-danger float-right"> <span class="fa fa-close"></span>
                                  Cancelar</button>
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
                                  <th>Id Documento Venta</th>
                                  <th>Id Sucursal</th>
                                  <th>Nombre Documento</th>
                                  <th>Nombre Corto</th>
                                  <th style="width:30px; text-align: center;">Código Sunat</th>
                                  <th style="width:30px; text-align: center;">Serie</th>
                                  <th style="width:30px; text-align: center;">Correlativo</th>
                                  <th style="width:30px; text-align: center;">Estado</th>
                                  <th style="width:30px; text-align: center;">¿Es doc. interno?</th>
                                  <th style="width:30px; text-align: center;">¿Es doc. de ingreso?</th>
                                  <th style="width:30px; text-align: center;">¿Es doc. de salida?</th>
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
  <script src="resources/system/js/pages/configuration/documentoventa.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menuconfiguration").addClass('active');
    $("#menudocumentoventa").addClass('active');
  </script>

</body>

</html>