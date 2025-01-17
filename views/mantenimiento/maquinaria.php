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
  <title>Maquinarias | <?= APP_TITLE; ?></title>

  <style>
    .form-check {
      display: flex;
      align-items: center;
    }

    .form-check-input {
      margin-right: 8px;
      position: static;
    }

    .form-check-label {
      position: static;
      top: 3px;
      left: -5px;
    }
  </style>
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
                          Maquinarias
                        </li>
                      </ol>
                    </nav>
                  </div>

                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("maquinaria"));
                    if ($access_options[0]['error'] == "NO") {

                      if ($access_options[0]['flag_agregar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="Agregar"
                          id="btnAdd">
                          <i class="fe fe-plus-circle btn btn-icon text-success"></i>
                        </a>
                        <?php
                      }

                      if ($access_options[0]['flag_buscar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top"
                          title="Actualizar listado" id="btnSearch">
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
                      <h4 class="card-title">Maquinarias</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12 d-none" id="panelForm">
                        <div class="ser-block block">
                          <form action="#" method="post" id="frmDatos" name="frmDatos">
                            <input type="hidden" name="id_maquinaria" id="id_maquinaria" value="">
                            <input type="hidden" name="accion" id="accion" value="add">

                            <div class="row">
                              <div class="form-group col-md-12 col-sm-12">
                                <label for="descripcion" class="label-control">Descripción</label>
                                <input id="descripcion" type="text" name="descripcion" class="form-control"
                                  autocomplete="off" required data-msg="Campo obligatorio...">
                              </div>
                              <div class="form-group col-md-12 col-sm-12">
                                <label for="observaciones" class="label-control">Observaciones</label>
                                <input id="observaciones" type="text" name="observaciones" class="form-control"
                                  autocomplete="off" required data-msg="Campo obligatorio...">
                              </div>
                              <div class="form-group col-md-6 col-sm-6">
                                <label for="id_trabajador" class="label-control">Operador Seleccionado</label>
                                <select name="id_trabajador" id="id_trabajador" class="form-control">
                                  <option value="">Seleccione...</option>
                                  <?php
                                  include("core/models/ClassMaquinaria.php");
                                  $dataTrabajador = $OBJ_MAQUINARIA->showOperators("activo"); // Llama solo a trabajadores activos
                                  if ($dataTrabajador["error"] == "NO" && !empty($dataTrabajador["data"])) {
                                    foreach ($dataTrabajador["data"] as $key) {
                                      echo '<option value="' . $key['id_trabajador'] . '">' . $key['nombre_operador'] . '</option>';
                                    }
                                  } else {
                                    echo '<option value="">Sin operadores disponibles</option>'; // Mostrar mensaje si no hay operadores
                                  }
                                  ?>
                                </select>
                              </div>

                              <div class="form-group col-md-6 col-sm-6">
                                <label for="id_tipo_servicio" class="label-control">Unidad de Negocio</label>
                                <select name="id_tipo_servicio" id="id_tipo_servicio" class="form-control">
                                  <option value="">Seleccione...</option>
                                  <?php
                                  include("core/models/ClassTipoServicio.php");
                                  $dataTIPO = $OBJ_TIPO_SERVICIO->show("activo"); // Llama solo a trabajadores activos
                                  if ($dataTIPO["error"] == "NO" && !empty($dataTIPO["data"])) {
                                    foreach ($dataTIPO["data"] as $key) {
                                      echo '<option value="' . $key['id_tipo_servicio'] . '">' . $key['name_tipo'] . '</option>';
                                    }
                                  } else {
                                    echo '<option value="">Sin unidad establecida</option>'; // Mostrar mensaje si no hay operadores
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group col-md-2 col-sm-6">
                                <br>
                                <div class="form-check">
                                  <input id="estado" name="estado" type="checkbox" class="form-check-input">
                                  <label for="estado" class="form-check-label">Estado</label>
                                </div>
                              </div>

                              <div class="form-group col-md-12">
                                <button type="submit" name="btnSave" id="btnSave" class="btn btn-success float-right">
                                  <span class="fa fa-save"></span> Guardar
                                </button>
                                <button type="reset" name="btnCancel" id="btnCancel" class="btn btn-danger float-right">
                                  <span class="fa fa-close"></span> Cancelar
                                </button>
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
                                  <th>Id</th>
                                  <th>Descripción</th>
                                  <th>Observaciones</th>
                                  <th>Tipo de Negocio</th>
                                  <th>Operador</th>
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
  <script src="resources/system/js/pages/mantenimiento/maquinaria.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menumantenimiento").addClass('active');
    $("#menumaquinaria").addClass('active');
  </script>

</body>

</html>