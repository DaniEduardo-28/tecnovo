<?php
if (!isset($_SESSION['id_trabajador'])) {
  header('location: ?view=logout');
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("views/overall/header.php"); ?>
  <title>Gestionar Cronograma | <?= APP_TITLE; ?> </title>

  <!-- FullCalendar CSS -->
  <link rel="stylesheet" href="resources/fullcalendar/fullcalendar.css">
  <!-- Select2 CSS -->
  <link href="resources/select2/css/select2.min.css" rel="stylesheet" />
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="resources/sweetalert2/sweetalert2.min.css">
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

    .modal-lg-custom {
      max-width: 70%;
      /* Ajusta el ancho a tu necesidad */
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
                        <li class="breadcrumb-item">Cronograma</li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Orden de Servicios</li>
                      </ol>
                    </nav>
                  </div>
                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions"
                    name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("vistareportecita"));
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
              </div>
            </div>

            <!-- Filtros -->
            <div class="row">
              <div class="container">
                <div class="row">
                  <div class="form-group col-sm-6 col-md-3">
                    <label for="cboClienteBuscar">Cliente</label>
                    <select class="form-control" id="cboClienteBuscar" name="cboClienteBuscar">
                      <option value="all">Todos</option>
                      <?php
                      include("core/models/ClassCliente.php");
                      $dataCliente = $OBJ_CLIENTE->listarClientes();
                      if ($dataCliente["error"] == "NO") {
                        foreach ($dataCliente["data"] as $key) {
                      ?>
                          <option value="<?= $key['id_cliente']; ?>">
                            <?= $key['nombres_cliente'] . ' ' . $key['apellidos_cliente'] ?>
                          </option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-md-3">
                    <label for="cboFundoBuscar">Fundo</label>
                    <select class="form-control" id="cboFundoBuscar" name="cboFundoBuscar">
                      <option value="all">Todos</option>
                      <?php
                      include("core/models/ClassFundo.php");
                      $dataFundo = $OBJ_FUNDO->show(1, '1');
                      if ($dataFundo["error"] == "NO") {
                        foreach ($dataFundo["data"] as $key) {
                      ?>
                          <option value="<?= $key['id_fundo']; ?>"><?= $key['nombre'] ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-md-3">
                    <label for="cboMaquinariaBuscar">Maquinaria</label>
                    <select class="form-control" id="cboMaquinariaBuscar" name="cboMaquinariaBuscar">
                      <option value="all">Todas</option>
                      <?php
                      include("core/models/ClassMaquinaria.php");
                      $dataMaquinaria = $OBJ_MAQUINARIA->showActivos();
                      if ($dataMaquinaria["error"] == "NO") {
                        foreach ($dataMaquinaria["data"] as $key) {
                      ?>
                          <option value="<?= $key['id_maquinaria']; ?>"><?= $key['descripcion'] ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-md-3">
                    <label for="cboMedicoBuscar">Operador</label>
                    <select class="form-control" id="cboMedicoBuscar" name="cboMedicoBuscar">
                      <option value="all">Todos</option>
                      <?php
                      include("core/models/ClassAccesoSucursal.php");
                      $dataOperador = $OBJ_ACCESO_SUCURSAL->getAccesoTrabajadorSucursal($_SESSION['id_sucursal']);
                      if ($dataOperador["error"] == "NO") {
                        foreach ($dataOperador["data"] as $key) {
                      ?>
                          <option value="<?= $key['id_trabajador']; ?>">
                            <?= $key['apellidos_trabajador'] . ' ' . $key['nombres_trabajador'] ?>
                          </option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-sm-6 col-md-3">
                    <label for="cboUnidadBuscar">Unidad de Negocio</label>
                    <select class="form-control" id="cboUnidadBuscar" name="cboUnidadBuscar">
                      <option value="all">Todos</option>
                      <?php
                      include("core/models/ClassTipoServicio.php");
                      $dataUnidad = $OBJ_TIPO_SERVICIO->show("activo");
                      if ($dataUnidad["error"] == "NO") {
                        foreach ($dataUnidad["data"] as $key) {
                      ?>
                          <option value="<?= $key['id_tipo_servicio']; ?>"><?= $key['name_tipo'] ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>

                </div>

                <!-- <div id="calendario" class="col-md-12"></div> -->
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
                      <th>#</th>
                      <th>Acciones</th>
                      <th>Código</th>
                      <th>Total</th>
                      <th>Gastos</th>
                      <th>Ganancia</th>
                      <th>Id</th>
                      <th>Fundo</th>
                      <th>Nombre Cliente</th>
                      <th>Servicio</th>
                      <th>Nombre Operador</th>
                      <th>Maquinaria</th>
                      <th>Fecha Ingreso</th>
                      <th>Fecha Salida</th>
                      <th>Estado Actual</th>
                      <!-- <th>Acciones</th> -->
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            <!-- Modal Operadores -->
            <div class="modal fade" id="modalOperador" tabindex="-1" role="dialog" aria-labelledby="modalOperadorLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-lg-custom" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalOperadorLabel">Operadores</h5>
                    <div class="col text-right">
                      <button id="btnNuevoOperador" class="btn btn-success">+ Nuevo</button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div id="nuevoOperadorContainer" class="mt-3" style="display: none;">
                      <form id="frmOperador" name="frmOperador" enctype="multipart/form-data">
                        <input type="hidden" name="id_cronograma" id="id_cronograma" value="0">
                        <div class="row">
                          <div class="col-md-1 d-none">
                            <label>#</label>
                            <input type="text" class="form-control" readonly value="AUTO">
                          </div>
                          <div class="col-md-3">
                            <label>Nombre Operador</label>
                            <select id="nombre_operador" name="nombre_operador" class="form-control">
                              <?php
                              $dataOperador = $OBJ_ACCESO_SUCURSAL->getAccesoTrabajadorSucursal($_SESSION['id_sucursal']);
                              if ($dataOperador["error"] == "NO") {
                                foreach ($dataOperador["data"] as $key) {
                              ?>
                                  <option value="<?= $key['id_trabajador']; ?>">
                                    <?= $key['apellidos_trabajador'] . ' ' . $key['nombres_trabajador'] ?>
                                  </option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>

                          <div class="col-md-2">
                            <label>Horas trabajadas</label>
                            <input type="number" id="horas_trabajadas" name="horas_trabajadas" class="form-control" min="0"
                              step="1.00">
                          </div>
                          <div class="col-md-2">
                            <label>Pago / Hora</label>
                            <input type="number" id="pago_por_hora" name="pago_por_hora" class="form-control" min="0"
                              step="1.00">
                          </div>
                          <div class="col-md-2">
                            <label>Pago total</label>
                            <input type="number" id="total_pago" name="total_pago" class="form-control" min="0"
                              step="1.00">
                          </div>
                          <div class="col-md-1 text-center mt-4">
                            <button type="submit" class="btn btn-success btn-sm btnGuardarOper"><i
                                class="fa fa-check"></i></button>
                            <button type="reset" class="btn btn-danger btn-sm btnCancelarOper"><i
                                class="fa fa-trash"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- Tablas de operadores -->
                    <div class="table-responsive">
                      <table class="table table-bordered" id="tablaOperador">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre Operador</th>
                            <th>Horas trabajadas</th>
                            <th>Pago / H.</th>
                            <th>Total</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Maquinarias -->
            <div class="modal fade" id="modalMaquinaria" tabindex="-1" role="dialog"
              aria-labelledby="modalMaquinariaLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg-custom" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalMaquinariaLabel">Maquinarias</h5>
                    <div class="col text-right">
                      <button id="btnNuevaMaquina" class="btn btn-success">+ Nuevo</button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <div id="nuevaMaquinariaContainer" class="mt-3" style="display: none;">
                      <form id="frmMaquinaria" name="frmMaquinaria" enctype="multipart/form-data">
                        <input type="hidden" name="id_cronograma" id="id_cronograma" value="0">
                        <div class="row">
                          <div class="col-md-1 d-none">
                            <label>#</label>
                            <input type="text" class="form-control" readonly value="AUTO">
                          </div>
                          <div class="col-md-3">
                            <label>Nombre Maquinaria</label>
                            <select id="nombre_maquinaria" name="nombre_maquinaria" class="form-control">
                              <?php
                              $dataMaquina = $OBJ_MAQUINARIA->showActivos();
                              if ($dataMaquina["error"] == "NO") {
                                foreach ($dataMaquina["data"] as $key) {
                              ?>
                                  <option value="<?= $key['id_maquinaria']; ?>"><?= $key['descripcion'] ?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>

                          <div class="col-md-2">
                            <label>Ingreso de Petroleo (L)</label>
                            <input type="number" id="petroleo_entrada" name="petroleo_entrada" class="form-control" min="0"
                              step="0.01">
                          </div>
                          <div class="col-md-2">
                            <label>Salida de Petroleo (L)</label>
                            <input type="number" id="petroleo_salida" name="petroleo_salida" class="form-control" min="0"
                              step="0.01">
                          </div>
                          <div class="col-md-2">
                            <label>Consumo Petroleo</label>
                            <input type="number" id="consumo_petroleo" name="consumo_petroleo" class="form-control" min="0"
                              step="0.01">
                          </div>
                          <div class="col-md-2">
                            <label>Precio Petroleo</label>
                            <input type="number" id="precio_petroleo" name="precio_petroleo" class="form-control" min="0"
                              step="0.01">
                          </div>
                          <div class="col-md-2">
                            <label>Pago Petroleo</label>
                            <input type="number" id="pago_petroleo" name="pago_petroleo" class="form-control" min="0"
                              step="0.01">
                          </div>
                          <div class="col-md-1 text-center mt-4">
                            <button type="submit" class="btn btn-success btn-sm btnGuardarMaqui"><i
                                class="fa fa-check"></i></button>
                            <button type="reset" class="btn btn-danger btn-sm btnCancelarMaqui" onclick="cancelarFormMaquinaria()">
                              <i class="fa fa-trash"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- Tablas de maquinarias -->
                    <div class="table-responsive">
                      <table class="table table-bordered" id="tablaMaquinaria">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Maquinaria</th>
                            <th>Ing. Petroleo</th>
                            <th>Sal. Petroleo</th>
                            <th>Consumo Petroleo</th>
                            <th>Precio Petroleo</th>
                            <th>Pago Total</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <?php include("views/overall/footer.php"); ?>
    </div>
  </div>

  <?php include("views/overall/js.php"); ?>

  <script src="resources/moment/min/moment.min.js"></script>
  <script src="resources/fullcalendar/fullcalendar.min.js"></script>
  <script src="resources/fullcalendar/locale/es.js"></script>

  <script src="resources/system/js/pages/citas/ordenservicio.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menucitas").addClass('active');
    $("#submenuordenservicio").addClass('active');
  </script>
</body>

</html>