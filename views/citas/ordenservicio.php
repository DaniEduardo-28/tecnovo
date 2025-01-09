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
                        <li class="breadcrumb-item active text-primary" aria-current="page">Gestionar</li>
                      </ol>
                    </nav>
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
                          <option value="<?= $key['id_cliente']; ?>"><?= $key['nombres_cliente'] . ' ' . $key['apellidos_cliente'] ?></option>
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
                          <option value="<?= $key['id_trabajador']; ?>"><?= $key['apellidos_trabajador'] . ' ' . $key['nombres_trabajador'] ?></option>
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
                                  <th>Num</th>
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


          </div>
        </div>
      </div>

      <?php include("views/overall/footer.php"); ?>
    </div>
  </div>

  <!-- Modal REGISTRAR CRONOGRAMA -->
<!--   <form action="#" method="post" id="frmCronograma" name="frmCronograma">
    <div class="modal fade" id="modal-calendario" tabindex="-1" role="dialog" aria-labelledby="modal-calendario-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">Nuevo Registro de Cronograma
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">

              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="id_cliente">Cliente</label>
                  <select class="form-control" id="id_cliente" name="id_cliente" style="width:100%;">
                    <option value="all">Seleccione...</option>
                    <?php
                    $dataCliente = $OBJ_CLIENTE->listarClientes();
                    if ($dataCliente["error"] == "NO") {
                      foreach ($dataCliente["data"] as $key) {
                    ?>
                        <option value="<?= $key['id_cliente']; ?>"><?= $key['nombres_cliente'] . ' ' . $key['apellidos_cliente'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group col-sm-12">
                  <label for="id_fundo">Fundo</label>
                  <select class="form-control" id="id_fundo" name="id_fundo">
                    <option value="all">Seleccione un cliente primero</option>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label for="fecha_ingreso">Fecha Ingreso</label>
                  <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required readonly>
                </div>

                <div class="form-group col-sm-6">
                  <label for="hora_ingreso">Hora Ingreso</label>
                  <input type="time" id="hora_ingreso" name="hora_ingreso" class="form-control" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="fecha_salida">Fecha Salida</label>
                  <input type="date" id="fecha_salida" name="fecha_salida" class="form-control" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="hora_salida">Hora Salida</label>
                  <input type="time" id="hora_salida" name="hora_salida" class="form-control" required>
                </div>

                <div class="form-group col-sm-12">
                  <label for="estado_trabajo">Estado Trabajo</label>
                  <input type="text" id="estado_trabajo" name="estado_trabajo" value="EN PROCESO" class="form-control" readonly>
                </div>

                
                <div class="form-group col-sm-6">
                  <label for="precio_hectarea">Precio por Hectárea</label>
                  <input type="number" id="precio_hectarea" name="precio_hectarea" class="form-control" value="0" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="total_hectareas">Total de Hectáreas</label>
                  <input type="number" id="total_hectareas" name="total_hectareas" class="form-control" value="0" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="descuento">Descuento</label>
                  <input type="number" id="descuento" name="descuento" class="form-control" value="0">
                </div>

                <div class="form-group col-sm-6">
                  <label for="adelanto">Adelanto</label>
                  <input type="number" id="adelanto" name="adelanto" class="form-control" value="0">
                </div>

                <div class="form-group col-sm-6">
                  <label for="monto_total">Monto Total</label>
                  <input type="number" id="monto_total" name="monto_total" class="form-control" value="0" readonly>
                </div>

                <div class="form-group col-sm-6">
                  <label for="saldo_por_pagar">Saldo por Pagar</label>
                  <input type="number" id="saldo_por_pagar" name="saldo_por_pagar" class="form-control" value="0" readonly>
                </div>

                <div class="form-group col-sm-6 d-none">
                  <label for="precio_petroleo">Precio del Petróleo</label>
                  <input type="number" id="precio_petroleo" name="precio_petroleo" class="form-control" value="0">
                </div>

                <div class="form-group col-sm-6 d-none">
                  <label for="consumo_petroleo">Consumo de Petróleo</label>
                  <input type="number" id="consumo_petroleo" name="consumo_petroleo" class="form-control" value="0">
                </div>

                <div class="form-group col-sm-6 d-none">
                  <label for="pago_petroleo">Pago por Petróleo</label>
                  <input type="number" id="pago_petroleo" name="pago_petroleo" class="form-control" value="0">
                </div>

              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cerrar">
            <input type="submit" name="btnSave" id="btnSave" value="Guardar Cronograma" class="btn btn-success">
          </div>
        </div>
      </div>
    </div>
  </form> -->

  <!-- Modal VER CRONOGRAMA -->
  <!-- <form action="#" method="post" id="frmCronogramaView" name="frmCronogramaView">
    <div class="modal fade" id="modal-calendario-show" tabindex="-1" role="dialog" aria-labelledby="modal-calendario-show-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Datos del Cronograma</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">



          </div>

          <div class="modal-footer">
            <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cerrar">
            <button type="button" id="btnAnularCronograma" class="btn btn-warning">Anular Cronograma</button>
          </div>
        </div>
      </div>
    </div>
  </form> -->

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