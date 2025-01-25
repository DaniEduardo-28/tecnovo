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
  <title>Aprobación de Cronograma | <?= APP_TITLE; ?> </title>
  <link rel="stylesheet" href="resources/fullcalendar/fullcalendar.css">

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
                        <li class="breadcrumb-item active text-primary" aria-current="page">Aprobación y Atención</li>
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
                          <option value="<?= $key['id_cliente']; ?>"><?= $key['nombres_cliente'] . ' ' . $key['apellidos_cliente'] . '(' . $key['apodo'] . ')' ?></option>
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

                </div>

                <div id="calendario" class="col-md-12"></div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <?php include("views/overall/footer.php"); ?>
    </div>
  </div>

  <!-- Modal VER CRONOGRAMA -->
  <form action="#" method="post" id="frmCronogramaView" name="frmCronogramaView">
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
            <div class="col-md-12">

              <div class="row">

                <input type="hidden" id="id_cronograma" name="id_cronograma" value="">
                <div class="form-group col-sm-12">
                  <label for="fundo_show">Fundo</label>
                  <input type="text" id="fundo_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-12">
                  <label for="cliente_show">Cliente</label>
                  <input type="text" id="cliente_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-12">
                  <label for="operador_show">Operador</label>
                  <input type="text" id="operador_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-12">
                  <label for="maquinaria_show">Maquinaria</label>
                  <input type="text" id="maquinaria_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-6">
                  <label for="fecha_ingreso_show">Fecha Ingreso</label>
                  <input type="text" id="fecha_ingreso_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-6">
                  <label for="fecha_salida_show">Fecha Salida</label>
                  <input type="text" id="fecha_salida_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-12">
                  <label for="fecha_pago_show">Fecha Pago</label>
                  <input type="text" id="fecha_pago_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-6">
                  <label for="fecha_ingreso_edit">Fecha Ingreso</label>
                  <input type="date" id="fecha_ingreso_edit" name="fecha_ingreso" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="hora_ingreso_edit">Hora Ingreso</label>
                  <input type="time" id="hora_ingreso_edit" name="hora_ingreso" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="fecha_salida_edit">Fecha Salida</label>
                  <input type="date" id="fecha_salida_edit" name="fecha_salida" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="hora_salida_edit">Hora Salida</label>
                  <input type="time" id="hora_salida_edit" name="hora_salida" class="form-control">
                </div>
                
                <div class="form-group col-sm-6">
                  <label for="fecha_pago_edit">Fecha de Pago</label>
                  <input type="date" id="fecha_pago_edit" name="fecha_pago" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="hora_pago_edit">Hora de Pago</label>
                  <input type="time" id="hora_pago_edit" name="hora_pago" class="form-control">
                </div>

                <div class="form-group col-sm-12">
                  <label for="estado_trabajo_show">Estado del Trabajo</label>
                  <input type="text" id="estado_trabajo_show" class="form-control" readonly>
                </div>

                
                <div class="form-group col-sm-6">
                  <label for="cantidad_edit">Cantidad</label>
                  <input type="number" id="cantidad_edit" name="cantidad" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="monto_unitario_edit">Monto Unitario</label>
                  <input type="number" id="monto_unitario_edit" name="monto_unitario" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="descuento_edit">Descuento</label>
                  <input type="number" id="descuento_edit" name="descuento" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="adelanto_edit">Adelanto</label>
                  <input type="number" id="adelanto_edit" name="adelanto" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="monto_total_edit">Monto Total</label>
                  <input type="number" id="monto_total_edit" name="monto_total" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-6">
                  <label for="saldo_por_pagar_edit">Saldo por Pagar</label>
                  <input type="number" id="saldo_por_pagar_edit" name="saldo_por_pagar" class="form-control" readonly>
                </div>

              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cerrar">
            <button type="button" id="btnGuardarCambios" class="btn btn-info"><i class="fa fa-calendar"></i>  Actualizar</button>
            <div id="accionesAprobacion"></div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php include("views/overall/js.php"); ?>
  <script src="resources/moment/min/moment.min.js"></script>
  <script src="resources/fullcalendar/fullcalendar.min.js"></script>
  <script src="resources/fullcalendar/locale/es.js"></script>

  <script src="resources/system/js/pages/citas/atencioncitas.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menucitas").addClass('active');
    $("#submenuatencioncitas").addClass('active');
  </script>
</body>

</html>