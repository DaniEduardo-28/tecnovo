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
  <title>Reporte cliente | <?= APP_TITLE; ?> </title>
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


  <div class="app">

    <div class="app-wrap">
      <?php include("views/overall/loader.php"); ?>

      <?php include("views/overall/topNav.php"); ?>
 
      <div class="app-container">

        <?php include("views/overall/leftNav.php"); ?>

        <div class="app-main" id="main">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 m-b-30">
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
                          Registros por pagar
                        </li>
                      </ol>
                    </nav>
                  </div>

                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions"
                    name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareportepagar"));
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

            <div class="row">

              <div class="col-xl-12">
                <div class="card card-statistics">
                  <div class="card-header">
                    <div class="card-heading">
                      <h4 class="card-title">Registros por Pagar</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12" id="panelTabla">

                        <div class="row">

                          
                          <div class="form-group col-md-3">
                            <label for="txtFechaInicio">Fecha de Inicio</label>
                            <input type="date" id="txtFechaInicio" value="<?= date("Y-m-d"); ?>" class="form-control">
                          </div>

                          <div class="form-group col-md-3">
                            <label for="txtFechaFin">Fecha de Fin</label>
                            <input type="date" id="txtFechaFin" value="<?= date("Y-m-d"); ?>" class="form-control">
                          </div>

                          <!-- <div class="form-group col-md-4 col-sm-4">
                            <label for="cboTipoBuscarOrden" class="label-control">Tipo Busqueda</label>
                            <select class="form-control" id="cboTipoBuscarOrden" name="cboTipoBuscarOrden">
                              <option value="1">Nombres / Apellidos</option>
                              <option value="2">Apodo</option>
                            </select>
                          </div> -->

                          <div class="col-md-8 col-sm-8">
                            <label for="">&nbsp;</label>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                                aria-describedby="basic-addon2" id="txtBuscarOrden" name="txtBuscarOrden">
                              <div class="input-group-append">
                                <button class="btn btn-outline-primary" id="btnBuscarOrden"
                                  type="button">Buscar</button>
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
                                  <th>Num</th>
                                  <th>Tipo de Registro</th>
                                  <th>Id</th>
                                  <th>Fecha</th>
                                  <th>Nombre Proveedor</th>
                                  <th>Monto Total</th>
                                  <th>Monto Pagado</th>
                                  <th>Monto Pediente</th>
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
  <script src="resources/system/js/pages/reportes/vistareportepagar.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menureportes").addClass('active');
    $("#submenureportepagar").addClass('active');
  </script>

</body>

</html>