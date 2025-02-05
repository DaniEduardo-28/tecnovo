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
  <style>
    .evento-en-proceso {
        color: black !important; /* Asegura que el texto sea negro */
        font-weight: bold; /* Hace que el texto sea más visible */
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
            <div class="row">
              <div class="col-md-12 text-right">
                <button type="button" class="btn btn-primary" id="btnAddCronograma">
                  <i class="fa fa-plus"></i> Nuevo
                </button>
              </div>
            </div>

            <!-- Filtros -->
            <div class="row">

              <div class="form-group col-12 col-sm-6 col-md-3">
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
              <div id="calendario" class="col-md-12"></div>
            </div>

          </div>
        </div>
      </div>

      <?php include("views/overall/footer.php"); ?>
    </div>
  </div>

  <!-- Modal REGISTRAR CRONOGRAMA -->
  <form action="#" method="post" id="frmCronograma" name="frmCronograma">
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

                <?php
                include("core/models/ClassTipoServicio.php");
                $dataUnidadNegocio = $OBJ_TIPO_SERVICIO->show('activo');
                if ($dataUnidadNegocio["error"] == "NO") {
                ?>
                  <input type="hidden" id="json_unidad_negocio" name="json_unidad_negocio" value='<?= json_encode($dataUnidadNegocio["data"], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                <?php
                } else {
                ?>
                  <input type="hidden" id="json_unidad_negocio" name="json_unidad_negocio" value="{}">
                <?php
                }
                ?>

                <div class="form-group col-sm-12">
                  <label for="id_unidad">Unidad Negocio</label>
                  <select class="form-control" id="id_unidad" require name="id_unidad" style="width:100%;">
                    <option value="">Seleccione...</option>
                    <?php
                    if ($dataUnidadNegocio["error"] == "NO") {
                      foreach ($dataUnidadNegocio["data"] as $key) {
                    ?>
                        <option value="<?= $key['id_tipo_servicio']; ?>"><?= $key['name_tipo'] ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>

                <?php
                include("core/models/ClassServicio.php");
                $dataServicio = $OBJ_SERVICIO->show_activos();
                if ($dataServicio["error"] == "NO") {
                ?>
                  <input type="hidden" id="json_servicio" name="json_servicio" value='<?= json_encode($dataServicio["data"], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                <?php
                } else {
                ?>
                  <input type="hidden" id="json_servicio" name="json_servicio" value="{}">
                <?php
                }
                ?>
                <div class="form-group col-sm-12">
                  <label for="id_servicio">Servicio</label>
                  <select class="form-control" id="id_servicio" require name="id_servicio" style="width:100%;">
                    <option value="">Seleccione...</option>
                  </select>
                </div>

                <div class="form-group col-sm-12">
                  <label for="id_cliente">Cliente</label>
                  <select class="form-control" require id="id_cliente" name="id_cliente" style="width:100%;">
                    <option value="all">Seleccione...</option>
                    <?php
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

                <div class="form-group col-sm-12">
                  <label for="id_fundo">Fundo</label>
                  <select class="form-control" id="id_fundo" name="id_fundo">
                    <option value="all">Seleccione un cliente primero</option>
                  </select>
                </div>

                <?php
                if ($dataMaquinaria["error"] == "NO") {
                  foreach ($dataMaquinaria["data"] as $key) {
                ?>
                    <input type="hidden" id="json_maquinaria" name="json_maquinaria" value='<?= json_encode($dataMaquinaria["data"], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                  <?php
                  }
                } else {
                  ?>
                  <input type="hidden" id="json_maquinaria" name="json_maquinaria" value="{}">
                <?php
                }
                ?>

                <div class="form-group col-sm-12">
                  <label for="id_maquinaria">Maquinaria</label>
                  <select class="form-control" id="id_maquinaria" name="id_maquinaria">
                    <option value="">Seleccione...</option>
                    <?php
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

                <div class="form-group col-sm-12">
                  <label for="id_operador">Operador</label>
                  <select class="form-control" id="id_operador" name="id_operador">
                    <option value="all">Seleccione...</option>
                    <?php
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

                <div class="form-group col-sm-6">
                  <label for="fecha_ingreso">Fecha Ingreso</label>
                  <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required>
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

                <div class="form-group col-sm-6">
                  <label for="fecha_pago">Fecha de Pago</label>
                  <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="hora_pago">Hora de Pago</label>
                  <input type="time" id="hora_pago" name="hora_pago" class="form-control" required>
                </div>

                <div class="form-group col-sm-12">
                  <label for="estado_trabajo">Estado Trabajo</label>
                  <input type="text" id="estado_trabajo" name="estado_trabajo" value="REGISTRADO" class="form-control" readonly>
                </div>

                <!-- Campos adicionales -->
                <div class="form-group col-sm-6">
                  <label for="precio_hectarea" id="label_precio">Precio por </label>
                  <input type="number" id="precio_hectarea" name="precio_hectarea" class="form-control" value="0" min="0" step="0.01" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="total_hectareas" id="label_total">Total de </label>
                  <input type="number" id="total_hectareas" name="total_hectareas" class="form-control" value="0" min="0" step="0.01" required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="descuento">Descuento</label>
                  <input type="number" id="descuento" name="descuento" class="form-control" value="0" min="0" step="0.01">
                </div>

                <div class="form-group col-sm-6">
                  <label for="adelanto">Adelanto</label>
                  <input type="number" id="adelanto" name="adelanto" class="form-control" value="0" min="0" step="0.01">
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
            <button type="submit" name="btnSave" id="btnSave" class="btn btn-success"><i class="fa fa-check"></i> Guardar Cronograma</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal VER CRONOGRAMA -->
  <form action="#" method="post" id="frmCronogramaView" name="frmCronogramaView">
    <div class="modal fade" id="modal-calendario-show" tabindex="-1" role="dialog" aria-labelledby="modal-calendario-show-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Datos del Cronograma</h5>
            <div class="ml-auto">
              <button type="button" class="btn btn-danger btn-sm" id="btnExportarPDF">
                <i class="fa fa-file-pdf-o"></i> Exportar PDF
              </button>
            </div>
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

                <div class="form-group col-sm-12">
                  <label for="fecha_ingreso_show">Fecha Ingreso</label>
                  <input type="text" id="fecha_ingreso_show" class="form-control" readonly>
                </div>

                <div class="form-group col-sm-12">
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

                <div class="form-group col-sm-6">
                  <label for="cantidad_edit" id="label_total_vista">Total de </label>
                  <input type="number" id="cantidad_edit" name="cantidad" class="form-control">
                </div>

                <div class="form-group col-sm-6">
                  <label for="monto_unitario_edit" id="label_precio_vista">Precio por </label>
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


                <div class="form-group col-sm-12">
                  <label for="estado_trabajo_show">Estado del Trabajo</label>
                  <input type="text" id="estado_trabajo_show" class="form-control" readonly>
                </div>

              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Cerrar">
            <button type="button" id="btnAnularCronograma" class="btn btn-warning"><i class="fa fa-ban"></i> Anular</button>
            <button type="button" id="btnAprobarCronograma" class="btn btn-success" style="display: none;"><i class="fa fa-check"></i> Iniciar Trabajo</button>
            <button type="button" id="btnGuardarCambios" class="btn btn-info"><i class="fa fa-calendar"></i> Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php include("views/overall/js.php"); ?>
  <script src="resources/moment/min/moment.min.js"></script>
  <script src="resources/fullcalendar/fullcalendar.min.js"></script>
  <script src="resources/fullcalendar/locale/es.js"></script>

  <script src="resources/system/js/pages/citas/citas.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menucitas").addClass('active');
    $("#submenucitas").addClass('active');
  </script>
</body>

</html>