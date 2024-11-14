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
    <title>Reporte Facturación | <?=APP_TITLE;?> </title>
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
                                      Facturación
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                              <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions" name="panelOptions">
                                <?php
                                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareporteordenventa"));
                                    if ($access_options[0]['error']=="NO") {

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
                                        <h4 class="card-title">Reporte Facturación</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="panelTabla">

                                      <div class="row">
                                        <div class="form-group col-md-3 col-sm-6">
                                          <label for="cboTipoDocVentaBuscar" class="label-control">Documento de Venta</label>
                                          <select name="cboTipoDocVentaBuscar" id="cboTipoDocVentaBuscar" class="form-control">
                                            <option value="">Todos</option>
                                            <?php
                                              include("core/models/ClassDocumentoVenta.php");
                                              $dataDocuVenta = $OBJ_DOCUMENTO_VENTA->show($_SESSION['id_fundo'],"all");
                                              if ($dataDocuVenta["error"]=="NO") {
                                                foreach ($dataDocuVenta["data"] as $key) {
                                                  if ($key['cod_sunat']!="07" && $key['cod_sunat']!="08") {
                                                    echo '<option value="' . $key['id_documento_venta'] . '">' . $key['nombre_corto'] . '</option>';
                                                  }
                                                }
                                              }
                                             ?>
                                          </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6">
                                          <label for="cboTipoDocuClieBuscar">Documento de Cliente</label>
                                          <select class="form-control" id="cboTipoDocuClieBuscar" name="cboTipoDocuClieBuscar">
                                            <option value="">Todos</option>
                                            <?php
                                              include("core/models/ClassDocumentoIdentidad.php");
                                              $dataDocuCliente = $OBJ_DOCUMENTO_IDENTIDAD->show("all");
                                              if ($dataDocuCliente["error"]=="NO") {
                                                foreach ($dataDocuCliente["data"] as $key) {
                                                  echo '<option value="' . $key['id_documento'] . '">' . $key['name_documento'] . '</option>';
                                                }
                                              }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6">
                                          <label for="txtFechaInicio">Fecha de Inicio</label>
                                          <input type="date" id="txtFechaInicio" value="<?=date("Y-m-d");?>" class="form-control">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6">
                                          <label for="txtFechaFin">Fecha de Fin</label>
                                          <input type="date" id="txtFechaFin" value="<?=date("Y-m-d");?>" class="form-control">
                                        </div>

                                        <div class="col-xs-12">
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
                                                <th style="width:90px;">Acciones</th>
                                                <th>Id Venta</th>
                                                <th style="width:30px; text-align: center;">Estado</th>
                                                <th>Doc. Compra</th>
                                                <th>Doc. Identidad</th>
                                                <th>Cliente</th>
                                                <th>Dirección</th>
                                                <th>Fecha</th>
                                                <th>Moneda</th>
                                                <th>M. Pago</th>
                                                <th>Sub Total</th>
                                                <th>IGV</th>
                                                <th>Total</th>
                                                <th>T.C.</th>
                                              </tr>
                                            </thead>
                                          </table>
                                        </div>
                                      </div>

                                      <br><br>

                                      <div class="col-md-12 col-sm-12 col-xs-12 text-center" id="divPaginador">
                                        <ul class="pagination pagination-split" id="paginador">

                                        </ul>
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
    <script src="resources/system/js/pages/reportes/vistareporteordenventa.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menureportes").addClass('active');
      $("#submenureporteordenventa").addClass('active');
    </script>

  </body>
</html>
