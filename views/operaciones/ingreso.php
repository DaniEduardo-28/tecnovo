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
  <title>Ingresos | <?= APP_TITLE; ?> </title>
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

    #grupoPago .form-group {
      margin-bottom: 15px;
      /* Ajusta el espacio entre los elementos */
    }

    .modal-lg-custom {
      max-width: 70%;
      /* Ajusta el ancho a tu necesidad */
    }

    #nuevoPagoContainer input[type="file"] {
      width: 100%;
      /* Asegura que el campo ocupe todo el espacio disponible */
    }

    #nuevoPagoContainer .btn {
      width: 100%;
      /* Ajusta el ancho de los botones si es necesario */
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
                          Operaciones
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                          Ingresos
                        </li>
                      </ol>
                    </nav>
                  </div>

                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions"
                    name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ingreso"));
                    if ($access_options[0]['error'] == "NO") {

                      if ($access_options[0]['flag_agregar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="Agregar" id="btnAdd">
                          <i class="fe fe-plus-circle btn btn-icon text-success"></i>
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

            require("core/models/ClassDocumentoIdentidad.php");
            require("core/models/ClassMetodoEnvio.php");
            require("core/models/ClassDocumentoVenta.php");

            ?>

            <div class="row">

              <div class="col-xl-12">
                <div class="card card-statistics">
                  <div class="card-header">
                    <div class="card-heading">
                      <h4 class="card-title">Ingresos</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">

                      <!-- START CONTENT FORM -->
                      <div class="col-md-12" id="contenedor_formulario">

                        <form method="post" id="form_datos">

                          <!-- START HEADER -->
                          <div class="row">

                            <div class="col-xs-12">
                              <h5 id="title_form">Datos de la Orden</h5>
                            </div>

                            <input type="hidden" name="id_ingreso" id="id_ingreso" value="0">
                            <input type="hidden" name="id_orden_compra" id="id_orden_compra" value="0">
                            <input type="hidden" name="accion" id="accion">

                            <div class="col-md-6 col-sm-8">
                              <div class="d-flex align-items-center">
                                <div class="bg-img mr-4">
                                  <img src="resources/global/images/sin_imagen.png" class="img-fluid" alt="Proveedor"
                                    id="img_proveedor">
                                </div>
                                <p class="font-weight-bold" id="name_proveedor">No seleccionado</p>
                              </div>
                            </div>

                            <div class="form-group col-md-3 col-sm-4">
                              <label for="" class="label-control">Forma de Envío</label>
                              <input type="text" id="txtNameMetodo" readonly name="txtNameMetodo" value=""
                                class="form-control">
                            </div>

                            <div class="form-group col-md-3 col-sm-4">
                              <label for="txtFechaOrdenForm" class="label-control">Fecha y Hora</label>
                              <input type="text" name="txtFechaOrdenForm" id="txtFechaOrdenForm" class="form-control"
                                readonly value="">
                            </div>

                            <div class="col-sm-12">
                              &nbsp;
                            </div>

                            <div class="form-group col-md-3 col-sm-4">
                              <label for="" class="label-control">Documento</label>
                              <select class="form-control" id="id_tipo_docu_form" name="id_tipo_docu_form">
                                <?php
                                $resultTipoDocu = $OBJ_DOCUMENTO_VENTA->show($_SESSION['id_sucursal'], 1);
                                if ($resultTipoDocu['error'] == "NO") {
                                  foreach ($resultTipoDocu['data'] as $key) {
                                    ?>
                                    <option value="<?= $key['id_documento_venta']; ?>"><?= $key['nombre_corto']; ?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                            </div>

                            <div class="form-group col-md-3 col-sm-4">
                              <label for="" class="label-control">Número Documento</label>
                              <input type="text" id="txtNumDocumento" required autocomplete="off" name="txtNumDocumento"
                                value="" class="form-control">
                            </div>

                            <div class="form-group col-sm-3">
                              <label for="txtEstadoForm" class="label-control">Estado</label>
                              <input type="text" name="txtEstadoForm" id="txtEstadoForm" class="form-control" readonly>
                            </div>

                          </div>
                          <!-- END HEADER -->

                          <!-- STAR BODY -->
                          <div class="row">

                            <div class="table-responsive">
                              <table class="table table-bordered" id="table_form">
                                <thead>
                                  <tr>
                                    <th style="width:50px; text-align: center;">#</th>
                                    <th>Id Producto</th>
                                    <th>Producto</th>
                                    <th style="width:20px;">C. Solicitada</th>
                                    <th style="width:30px;">C. Ingresada</th>
                                    <th style="width:100px;">Cantidad</th>
                                    <th>Observaciones</th>
                                  </tr>
                                </thead>

                              </table>
                            </div>

                          </div>
                          <!-- END BODY -->

                          <!-- START FOOTER -->
                          <div class="row">

                            <div class="form-group col-sm-7">
                              <label for="txtObservacionesForm" class="label-control">Observaciones</label>
                              <input type="text" name="txtObservacionesForm" id="txtObservacionesForm"
                                class="form-control">
                            </div>

                            <div class="form-group col-md-3 col-sm-4">
                              <label for="">Boleta / Factura</label>
                              <br>
                              <div class="form-group">
                                <input type="file" name="src_evidencia" id="src_evidencia"
                                  accept="application/pdf,image/jpeg,image/png" class="is-valid" aria-invalid="false">
                              </div>
                            </div>

                            <div class="form-group col-md-3 col-sm-4">
                              <label for="txtTotal_ingForm" class="label-control">Total</label>
                              <input type="number" name="txtTotal_ingForm" id="txtTotal_ingForm" class="form-control"
                                min="0" step="1.00">
                            </div>

                            <div class="form-group col-md-2 col-sm-3">
                              <div class="form-check">
                                <input id="flag_pagado" name="flag_pagado" type="checkbox" class="form-check-input">
                                <label for="flag_pagado" class="form-check-label">¿Añadir un pago?</label>
                              </div>
                            </div>

                            <!-- Grupo de campos que se ocultarán -->
                            <div id="grupoPago" style="display: none;">
                              <div class="row">
                                <div id="camposPago" class="form-group col-md-3 col-sm-4">
                                  <label for="txtTotalPagadoForm" class="label-control">Total Pagado</label>
                                  <input type="number" name="txtTotalPagadoForm" id="txtTotalPagadoForm"
                                    class="form-control">
                                </div>

                                <!-- <div class="form-group col-md-3 col-sm-4">
                                  <label for="id_forma_pago" class="label-material">Forma de Pago</label>
                                  <select name="id_forma_pago" id="id_forma_pago" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <?php
                                    include("core/models/ClassMetodoPago.php");
                                    $dataPago = $OBJ_METODO_PAGO->show(1);
                                    if ($dataPago["error"] == "NO") {
                                      foreach ($dataPago["data"] as $key) {
                                        echo '<option value="' . $key['id_forma_pago'] . '">' . $key['name_forma_pago'] . '</option>';
                                      }
                                    }
                                    ?>
                                  </select>
                                </div> -->

                                <div id="totalPendiente" class="form-group col-md-3 col-sm-4">
                                  <label for="txtTotalPendienteForm" class="label-control">Total Pendiente</label>
                                  <input type="number" name="txtTotalPendienteForm" id="txtTotalPendienteForm"
                                    class="form-control">
                                </div>
                              </div>
                            </div>


                            <div class="form-group col-sm-5">
                              <br>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-success float-right" id="btnSaveForm">
                                <span class="fa fa-save"></span> Registrar Ingreso
                              </button>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-danger float-right" id="btnCancelForm">
                                <span class="fa fa-close"></span> Cancelar
                              </button>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-danger float-right d-none" id="btnCancelFormVer">
                                <span class="fa fa-close"></span> Cancelar
                              </button>&nbsp;&nbsp;&nbsp;
                            </div>

                          </div>
                          <!-- END FOOTER -->

                        </form>

                      </div>
                      <!-- END CONTENT FORM -->

                      <!-- START CONTENT ORDEN DE COMPRA -->
                      <div class="col-md-12" id="contenedor_orden">

                        <div class="row">

                          <div class="form-group col-md-2 col-sm-4">
                            <label for="txtFechaInicioBuscarOrden" class="label-control">Fecha Inicio</label>
                            <input id="txtFechaInicioBuscarOrden" type="date" name="txtFechaInicioBuscarOrden"
                              class="form-control" autocomplete="off" value="<?= date("Y-m-d"); ?>">
                          </div>

                          <div class="form-group col-md-2 col-sm-4">
                            <label for="txtFechaFinBuscarOrden" class="label-control">Fecha Fin</label>
                            <input id="txtFechaFinBuscarOrden" type="date" name="txtFechaFinBuscarOrden"
                              class="form-control" autocomplete="off" value="<?= date("Y-m-d"); ?>">
                          </div>

                          <div class="form-group col-md-2 col-sm-4">
                            <label for="cboTipoBuscarOrden" class="label-control">Tipo Busqueda</label>
                            <select class="form-control" id="cboTipoBuscarOrden" name="cboTipoBuscarOrden">
                              <option value="1">Documento</option>
                              <option value="2">Nombres / Razón Social</option>
                              <option value="2">Apellidos / Nombre Comercial</option>
                            </select>
                          </div>

                          <div class="col-md-4 col-sm-10">
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

                          <div class="col-sm-2">
                            <label for="" class="label-control">&nbsp;</label>
                            <br>
                            <button type="button" name="button" class="btn btn-danger" id="btnVolverOrden"
                              name="btnVolverOrden">
                              <span class="fa fa-mail-reply"></span> Volver
                            </button>
                          </div>

                        </div>

                        <div class="card-body py-0 table-responsive">
                          <table class="table clients-contant-table mb-0" id="tabla_orden">
                            <thead>
                              <tr>
                                <th>Num</th>
                                <th>Id Orden</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Fecha Orden</th>
                                <th>Fecha Entrega</th>
                                <th>Forma de Envío</th>
                                <th># Productos</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Seleccionar</th>
                              </tr>
                            </thead>
                            <tbody id="tbody_orden">

                            </tbody>
                          </table>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <ul class="pagination pagination-split" id="paginador_orden">

                          </ul>
                        </div>

                      </div>
                      <!-- END CONTENT ORDEN DE COMPRA -->

                      <!-- START CONTENT LISTADO -->
                      <div class="col-md-12" id="contenedor_listado">

                        <div class="row">

                          <div class="form-group col-md-3 col-sm-4">
                            <label for="txtFechaInicioBuscarListado" class="label-control">Fecha Inicio</label>
                            <input id="txtFechaInicioBuscarListado" type="date" name="txtFechaInicioBuscarListado"
                              class="form-control" autocomplete="off" value="<?= date("Y-m-d"); ?>">
                          </div>

                          <div class="form-group col-md-3 col-sm-4">
                            <label for="txtFechaFinBuscarListado" class="label-control">Fecha Fin</label>
                            <input id="txtFechaFinBuscarListado" type="date" name="txtFechaFinBuscarListado"
                              class="form-control" autocomplete="off" value="<?= date("Y-m-d"); ?>">
                          </div>

                          <div class="form-group col-md-2 col-sm-4">
                            <label for="cboTipoBuscarListado" class="label-control">Tipo Busqueda</label>
                            <select class="form-control" id="cboTipoBuscarListado" name="cboTipoBuscarListado">
                              <option value="1">Documento</option>
                              <option value="2">Nombres / Razón Social</option>
                              <option value="2">Apellidos / Nombre Comercial</option>
                            </select>
                          </div>

                          <div class="col-md-4 col-sm-12">
                            <label for="">&nbsp;</label>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                                aria-describedby="basic-addon2" id="txtBuscarListado" name="txtBuscarListado">
                              <div class="input-group-append">
                                <button class="btn btn-outline-primary" id="btnBuscarListado"
                                  type="button">Buscar</button>
                              </div>
                            </div>
                          </div>

                        </div>

                        <div class="card-body py-0 table-responsive">
                          <table class="table table-bordered" id="tabla_listado">
                            <thead>
                              <tr>
                                <th>Num</th>
                                <th>Id Ingreso</th>
                                <th>Documento</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Fecha Ingreso</th>
                                <th># Productos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                          </table>
                        </div>

                        <div class="col-sm-12">
                          &nbsp;
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <ul class="pagination pagination-split" id="paginador_listado">

                          </ul>
                        </div>

                      </div>
                      <!-- END CONTENT LISTADO -->

                      <div class="modal fade" id="modalPagos" tabindex="-1" role="dialog"
                        aria-labelledby="modalPagosLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg-custom" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalPagosLabel">Pagos del Ingreso</h5>
                              <div class="col text-right">
                                <button id="btnNuevoPago" class="btn btn-success">+ Nuevo</button>
                              </div>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                            <div id="nuevoPagoContainer" class="mt-3" style="display: none;">
                                <form id="frmPago" name="frmPago" enctype="multipart/form-data">
                                  <input type="hidden" name="id_ingreso_pago" id="id_ingreso_pago" value="0">
                                  <div class="row">
                                    <div class="col-md-1 d-none">
                                      <label>#</label>
                                      <input type="text" class="form-control" readonly value="AUTO">
                                    </div>
                                    <div class="col-md-2">
                                      <label>Fecha de Pago</label>
                                      <input type="date" id="fecha_pago" name="fecha_pago" class="form-control"
                                      value="<?=date("Y-m-d",strtotime(date("Y-m-d"))); ?>">
                                    </div>
                                    <div class="col-md-3">
                                      <label>Método de Pago</label>
                                      <select id="id_forma_pago" name="id_forma_pago" class="form-control">
                                        <?php
                                        $dataPago = $OBJ_METODO_PAGO->show(1);
                                        if ($dataPago["error"] == "NO") {
                                          foreach ($dataPago["data"] as $key) {
                                            echo '<option value="' . $key['id_forma_pago'] . '">' . $key['name_forma_pago'] . '</option>';
                                          }
                                        }
                                        ?>
                                      </select>
                                    </div>

                                    <div class="col-md-2">
                                      <label>Monto</label>
                                      <input type="number" id="monto_pagado" name="monto_pagado" class="form-control"
                                        min="0" step="1.00">
                                    </div>
                                    <div class="col-md-4">
                                      <label>Archivo</label>
                                      <input type="file" id="src_factura" name="src_factura" class="form-control">
                                    </div>
                                    <div class="col-md-1 text-center mt-4">
                                      <button type="submit" class="btn btn-success btn-sm btnGuardarPago"><i
                                          class="fa fa-check"></i></button>
                                      <button type="reset" class="btn btn-danger btn-sm btnCancelarPago"><i
                                          class="fa fa-trash"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                              <!-- Tablas de pagos -->
                              <div class="table-responsive">
                                <table class="table table-bordered" id="tablaPagos">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Fecha de Pago</th>
                                      <th>Método de Pago</th>
                                      <th>Monto</th>
                                      <th>Evidencia</th>
                                      <th>Acción</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <!-- <tr>
                                      <td colspan="6" class="text-center">No hay pagos registrados aún.</td>
                                    </tr> -->
                                  </tbody>
                                </table>
                              </div>
                              <div class="row mt-3 text-right">
                                <div class="col-md-12">
                                  <label id="lblTotalPagar"><strong>Total a Pagar:</strong> S/ 0.00</label><br>
                                  <label id="lblTotalPagado"><strong>Total Pagado:</strong> S/ 0.00</label><br>
                                  <label id="lblPendientePago"><strong>Pendiente de Pago:</strong> S/ 0.00</label>
                                </div>
                              </div>

                            </div>
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
  <script src="resources/system/js/pages/operaciones/ingreso.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menuoperaciones").addClass('active');
    $("#submenuingreso").addClass('active');
  </script>

</body>

</html>