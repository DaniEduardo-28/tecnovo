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
  <title>Reporte Auditoria | <?= APP_TITLE; ?> </title>
  <style media="screen">
    .pagination {
      display: inline-block;
    }

    .pagination li {
      color: black;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
      cursor: pointer;
    }

    .pagination li.active {
      background-color: #9e61da;
      color: white;
    }

    .pagination li:hover:not(.active) {
      background-color: #ddd;
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
                          Reportes
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                          Proforma
                        </li>
                      </ol>
                    </nav>
                  </div>

                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions"
                    name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareporteauditoria"));
                    if ($access_options[0]['error'] == "NO") {

                      if ($access_options[0]['flag_descargar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="Descargar reporte en pdf" id="btnReportePdf">
                          <i class="fa fa-file-pdf-o btn btn-icon text-danger"></i>
                        </a>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="Descargar reporte en excel" id="btnReporteExcel">
                          <i class="fa fa-file-excel-o btn btn-icon text-success"></i>
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

            <?php
            require "core/models/ClassAuditoria.php";
            $auditoria = new ClassAuditoria();
            $tablas = $auditoria->getNombreTablas();
            ?>

            <div class="row">

              <div class="col-xl-12">
                <div class="card card-statistics">
                  <div class="card-header">
                    <div class="card-heading">
                      <h4 class="card-title">Reporte Auditoria</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12" id="panelTabla">

                        <div class="row">

                          <div class="form-group col-md-3 col-sm-6">
                            <label for="filterUser">Filtrar por Usuario</label>
                            <select id="filterUser" class="form-control">
                              <option value="">Todos</option>
                            </select>
                          </div>
                          <div class="form-group col-md-3 col-sm-6">
                            <label for="filterTable">Filtrar por Tabla</label>
                            <select id="filterTable" class="form-control">
                              <option value="">Todos</option>
                              <?php
                              if ($tablas["error"] == "NO") {
                                foreach ($tablas["data"] as $tabla) {
                                  echo '<option value="' . htmlspecialchars($tabla["nombre_tabla"]) . '">' . htmlspecialchars($tabla["nombre_tabla"]) . '</option>';
                                }
                              } else {
                                echo '<option value="">' . htmlspecialchars($tablas["message"]) . '</option>';
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="txtFechaInicio">Fecha de Inicio</label>
                            <input type="date" id="txtFechaInicio" value="<?= date("Y-m-d"); ?>" class="form-control">
                          </div>

                          <div class="form-group col-md-3">
                            <label for="txtFechaFin">Fecha de Fin</label>
                            <input type="date" id="txtFechaFin" value="<?= date("Y-m-d"); ?>" class="form-control">
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
                                  <th>Num</th>
                                  <th>Id</th>
                                  <th>Nombre Usuario</th>
                                  <th>Tipo Usuario</th>
                                  <th>Nombre Tabla</th>
                                  <th>Tipo Transacción</th>
                                  <th>Fecha</th>
                                  <!-- <th>Acciones</th> -->
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>

                        <br><br>

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
  <script src="resources/system/js/pages/reportes/vistareporteauditoria.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menureportes").addClass('active');
    $("#submenureporteauditoria").addClass('active');
  </script>

</body>

</html>