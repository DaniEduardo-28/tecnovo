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
    <title>Historial  | <?=APP_TITLE;?> </title>

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
                                      Historial 
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
                                        <h4 class="card-title">Historial  de Operaciones</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="panelTabla">

                                      <div class="row">
                                        <div class="form-group col-md-3 col-sm-6" hidden>
                                          <label for="cboTipoBuscar" class="label-control">Tipo de Operación</label>
                                          <select name="cboTipoBuscar" id="cboTipoBuscar" class="form-control">
                                            <option value="">Todos</option>
                                            <?php
                                              include('core/models/ClassTipoMascota.php');
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
                                            include('core/models/ClassDocumentoIdentidad.php');
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

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/citas/historialclinico.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menucitas").addClass('active');
      $("#submenuhistorialclinico").addClass('active');
    </script>

  </body>
</html>
