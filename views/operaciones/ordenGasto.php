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
  <title>Registro de Gastos | <?= APP_TITLE; ?> </title>
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
                          Operaciones
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                          Registro de Gastos
                        </li>
                      </ol>
                    </nav>
                  </div>


                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions"
                    name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordencompra"));
                    if ($access_options[0]['error'] == "NO") {
                      if ($access_options[0]['flag_agregar']) {
                        ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="Nueva Orden" id="btnAdd">
                          <i class="fe fe-plus-circle btn btn-icon text-primary"></i>
                        </a>
                        <?php
                      }
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

            require("core/models/ClassDocumentoIdentidad.php");
            require("core/models/ClassMetodoEnvio.php");

            ?>

            <div class="row">

              <div class="col-xl-12">
                <div class="card card-statistics">
                  <div class="card-header">
                    <div class="card-heading">
                      <h4 class="card-title">Registro de Gastos</h4>
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
                              <h5>Proveedor</h5>
                            </div>

                            <input type="hidden" name="id_proveedor" id="id_proveedor" value="0">
                            <input type="hidden" name="id_orden_compra" id="id_orden_compra" value="0">
                            <input type="hidden" name="accion" id="accion">

                            <div class="col-md-6 col-sm-8">
                              <div class="d-flex align-items-center">
                                <div class="bg-img mr-4">
                                  <img src="resources/global/images/sin_imagen.png" class="img-fluid" alt="Proveedor"
                                    id="img_proveedor">
                                </div>
                                <p class="font-weight-bold" id="name_proveedor" style="font-size: 1.15em;">No
                                  seleccionado</p> <!-- Tamaño de texto más grande -->
                              </div>
                              <button type="button" class="btn btn-info btn-lg mt-2" id="btnSeleccionarProveedor"
                                style="font-size: 1em; padding: 5px 10px;">
                                Seleccionar&nbsp;<span class="fa fa-ellipsis-h"></span>
                              </button>
                            </div>
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="codigo_documento_venta">Doc. Compra(*)</label>
                              <select class="form-control" name="codigo_documento_venta" id="codigo_documento_venta"
                                required>
                                <option value="">Seleccione</option>
                                <?php
                                include('core/models/ClassDocumentoVenta.php');
                                $dataDocuVenta = $OBJ_DOCUMENTO_VENTA->show("1");
                                if ($dataDocuVenta["error"] == "NO") {
                                  foreach ($dataDocuVenta["data"] as $key) {
                                    if ($key['cod_sunat'] != "07" && $key['cod_sunat'] != "08") {
                                      echo '<option value="' . $key['id_documento_venta'] . '">' . $key['nombre'] . '</option>';
                                    }
                                  }
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="codigo_moneda">Moneda(*)</label>
                              <select class="form-control" name="codigo_moneda" id="codigo_moneda" required>
                                <option value="">Seleccione</option>
                                <?php
                                include('core/models/ClassMoneda.php');
                                $dataMoneda = $OBJ_MONEDA->show("1");
                                if ($dataMoneda["error"] == "NO") {
                                  foreach ($dataMoneda["data"] as $key) {
                                    if ($key['flag_principal']) {
                                      echo '<option value="' . $key['id_moneda'] . '" selected>' . $key['name_moneda'] . '</option>';
                                    } else {
                                      echo '<option value="' . $key['id_moneda'] . '">' . $key['name_moneda'] . '</option>';
                                    }
                                  }
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-sm-12">
                              &nbsp;
                            </div>
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="txtFechaEntregaForm" class="label-control">Fecha Gasto</label>
                              <input type="date" name="txtFechaEntregaForm" id="txtFechaEntregaForm"
                                class="form-control" value="<?= date("Y-m-d"); ?>">
                            </div>
                            <!-- <div class="form-group col-md-3 col-sm-4">
                              <label for="txtObservacionesForm" class="label-control">Observaciones</label>
                              <input type="text" name="txtObservacionesForm" id="txtObservacionesForm"
                                class="form-control">
                            </div> -->
                            <div class="form-group col-md-2 col-sm-3">
                              <label for="txtSerieform" class="label-control">Serie</label>
                              <input type="text" name="txtSerieForm" id="txtSerieForm"
                              class="form-control">
                            </div>
                            <div class="form-group col-md-2 col-sm-3">
                              <label for="txtCorrelativoForm" class="label-control">Correlativo</label>
                              <input type="text" name="txtCorrelativoForm" id="txtCorrelativoForm" 
                              class="form-control">
                            </div>
                          </div>
                          <!-- END HEADER -->

                          <!-- STAR BODY -->
                          <div class="row">

                            <div class="table-responsive">
                              <table class="table table-bordered" id="table_form">
                                <thead>
                                  <tr>
                                    <!-- <th style="width:50px; text-align: center;">#</th>
                                    <th>Id Producto</th>
                                    <th>Producto</th>
                                    <th style="width:20px;">Stock</th>
                                    <th style="width:40px; text-align:right;">Precio Compra</th>
                                    <th style="width:100px;">Cantidad</th>
                                    <th>Notas</th>
                                    <th style="width:60px;">Total</th>
                                    <th style="width:20px;">Eliminar</th> -->
                                    <th style="width:50px; text-align: center;">#</th>
                                    <th>Id Producto</th>
                                    <th>Nombre Tabla</th>
                                    <th style="width:100px;">Producto</th>
                                    <th style="width:100px; text-align:left;">Producto</th>
                                    <th style="width:100px;">Cantidad</th>
                                    <th style="width:40px;">Precio Unit.</th>
                                    <th style="width:40px;">Descuento</th>
                                    <th style="width:40px;">Sub Total</th>
                                    <th style="width:40px;">Tipo IGV</th>
                                    <th style="width:40px;">IGV</th>
                                    <th style="width:60px;">Total</th>
                                    <th style="width:20px;">X</th>
                                  </tr>
                                </thead>

                              </table>
                            </div>

                          </div>
                          <!-- END BODY -->

                          <!-- START FOOTER -->
                          <div class="row">
                            <div class="form-group col-sm-5">
                              <div class="form-group col-md-12">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                  <label class="btn btn-info active">
                                    <input checked type="radio" name="opcion_busqueda" value="accesorio"
                                      id="opcion_accesorio" autocomplete="off"> Servicio
                                  </label>
                                  <label class="btn btn-info">
                                    <input type="radio" name="opcion_busqueda" value="medicamento"
                                      id="opcion_medicamento" autocomplete="off"> Producto
                                  </label>
                                </div>
                                <button type="button" name="btnAgregarDetalle" id="btnAgregarDetalle"
                                  class="btn btn-success"><span class="fa fa-plus"></span></button>
                              </div>
                              <br>
                                              <!-- <button type="button" class="btn btn-primary" id="btnSeleccionarProducto">
                                                 <span class="fa fa-plus"></span> Agregar Producto&nbsp;
                                              </button> -->
                            </div>
                            
                              <br><br>
                              <div class="col-sm-8">
                                <label for="">&nbsp;</label>
                              </div>
                              <div class="col-sm-4">
                                <div class="form-group row">
                                  <label for="txtTotalDescuento" class="col-sm-4 col-form-label">Descuento Total</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtTotalDescuento" readonly style="text-align:right;">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="txtGravada" class="col-sm-4 col-form-label">Gravada</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtGravada" readonly style="text-align:right;">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="txtIgv" class="col-sm-4 col-form-label">IGV</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtIgv" readonly style="text-align:right;">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="txtTotal" class="col-sm-4 col-form-label">Total</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtTotal" readonly style="text-align:right;">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="txtMontoRecibido" class="col-sm-4 col-form-label">Monto Recibido</label>
                                  <div class="col-sm-8">
                                    <input type="number" class="form-control" id="txtMontoRecibido"
                                      style="text-align:right;" value="0.00" min="0">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="txtVuelto" class="col-sm-4 col-form-label">Vuelto</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtVuelto"
                                      style="text-align:right;" value="0.00" readonly>
                                  </div>
                                </div>

                              </div>
                            
                            <div class="form-group col-md-12">
                              <br>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-success float-right" id="btnSaveForm">
                                <span class="fa fa-save"></span> Guardar
                              </button>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-warning float-right" id="btnSaveBorradorForm">
                                <span class="fa fa-save"></span> Guardar Borrador
                              </button>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-danger float-right" id="btnCancelForm">
                                <span class="fa fa-arrow-left"></span> Volver
                              </button>&nbsp;&nbsp;&nbsp;
                            </div>
                          </div>
                          <!-- END FOOTER -->

                        </form>

                      </div>
                      <!-- END CONTENT FORM -->

                      <!-- START CONTENT PROVEEDOR -->
                      <div class="col-md-12" id="contenedor_proveedor">

                        <div class="row">

                          <div class="col-md-4 col-sm-4">
                            <label for="cboDocuProveedor" class="label-control">Documento</label>
                            <select class="form-control" name="cboDocuProveedor" id="cboDocuProveedor">
                              <?php
                              $resultDocumentos = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                              if ($resultDocumentos['error'] == "NO") {
                                foreach ($resultDocumentos['data'] as $key) {
                                  ?>
                                  <option value="<?= $key['id_documento']; ?>"><?= $key['name_documento']; ?></option>
                                  <?php
                                }
                              }
                              ?>
                            </select>
                          </div>

                          <div class="col-md-6 col-sm-4">
                            <label for="">&nbsp;</label>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control"
                                placeholder="Número documento, nombres, razón social..."
                                aria-label="Recipient's username" aria-describedby="basic-addon2"
                                id="txtBuscarProveedor" name="txtBuscarProveedor">
                              <div class="input-group-append">
                                <button class="btn btn-outline-primary" id="btnSearchProveedor"
                                  type="button">Buscar</button>
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-2 col-sm-4">
                            <br>
                            <label for="btnCancelarProveedor">&nbsp;</label>
                            <button type="button" class="btn btn-danger" id="btnCancelarProveedor">
                              <span class="fa fa-mail-reply"></span> &nbsp; Volver
                            </button>
                          </div>

                        </div>

                        <div class="card-body py-0 table-responsive">
                          <table class="table clients-contant-table mb-0" id="tabla_proveedor">
                            <thead>
                              <tr>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Documento</th>
                                <th scope="col">Número Documento</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Seleccionar</th>
                              </tr>
                            </thead>
                            <tbody id="tbody_proveedor">

                            </tbody>
                          </table>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <ul class="pagination pagination-split" id="paginador_proveedor">

                          </ul>
                        </div>

                      </div>
                      <!-- END CONTENT PROVEEDOR -->

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

                          <div class="form-group col-md-3 col-sm-6">
                            <label for="cboTipoDocVentaBuscar" class="label-control">Registro de Gastos</label>
                            <select name="cboTipoDocVentaBuscar" id="cboTipoDocVentaBuscar" class="form-control">
                              <option value="">Todos</option>
                              <?php
                              $dataDocuVenta = $OBJ_DOCUMENTO_VENTA->show("all");
                              if ($dataDocuVenta["error"] == "NO") {
                                foreach ($dataDocuVenta["data"] as $key) {
                                  if ($key['cod_sunat'] != "07" && $key['cod_sunat'] != "08") {
                                    echo '<option value="' . $key['id_documento_venta'] . '">' . $key['nombre'] . '</option>';
                                  }
                                }
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group col-md-3 col-sm-6">
                            <label for="cboTipoDocuClieBuscar">Documento de Proveedor</label>
                            <select class="form-control" id="cboTipoDocuClieBuscar" name="cboTipoDocuClieBuscar">
                              <option value="">Todos</option>
                              <?php
                              $dataDocuCliente = $OBJ_DOCUMENTO_IDENTIDAD->show("all");
                              if ($dataDocuCliente["error"] == "NO") {
                                foreach ($dataDocuCliente["data"] as $key) {
                                  echo '<option value="' . $key['id_documento'] . '">' . $key['name_documento'] . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>

                          <div class="col-xs-12">
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
                                <!-- <th>#</th>
                                <th>Id Orden</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Fecha Orden</th>
                                <th>Fecha Entrega</th>
                                <th>Forma de Envío</th>
                                <th># Productos</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th> -->
                                <th>#</th>
                                <th>Id Orden</th>
                                <th>Doc. Compra</th>
                                <th>Doc. Identidad</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Moneda</th>
                                <th>Sub total</th>
                                <th>IGV</th>
                                <th>Total</th>
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

                      <!-- START CONTENT PRODUCTOS -->
                      <div class="col-md-12" id="contenedor_productos">

                        <h4 id="title_modal">Productos</h4>

                        <div class="row">

                          <div class="col-md-10">
                            <label for="">&nbsp;</label>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder="Buscar..." aria-label="Producto...."
                                aria-describedby="basic-addon2" id="txtBuscarProducto" name="txtBuscarProducto">
                              <div class="input-group-append">
                                <button class="btn btn-outline-primary" id="btnSearchProducto"
                                  type="button">Buscar</button>
                              </div>
                            </div>
                          </div>

                          <div class="form-group col-md-2">
                            <label for="btnSiguienteProductos">&nbsp;</label>
                            <button type="button" class="btn btn-success float-right" id="btnSiguienteProductos">
                              <span class="fa fa-next"></span> &nbsp; Siguiente
                            </button>
                          </div>

                        </div>

                        <div class="card-body py-0 table-responsive">
                          <table class="table table-bordered" id="tabla_productos">
                            <thead>
                              <tr>
                                <!-- <th style="width:20px;">#</th>
                                <th>Id Producto</th>
                                <th>Producto</th>
                                <th style="width:60px;">Stock</th>
                                <th style="width:40px;">Precio Unitario</th>
                                <th style="width:90px;">Cantidad</th>
                                <th style="width:10px;">Seleccionar</th>
                                <th>Nombre Producto</th> -->
                                <th style="width:20px;">#</th>
                                <th>Id Producto</th>
                                <th>Producto</th>
                                <th style="width:60px;">1</th>
                                <th style="width:40px;">2</th>
                                <th style="width:90px;">3</th>
                                <th style="width:10px;">Seleccionar</th>
                                <th>Nombre Producto</th>
                              </tr>
                            </thead>
                            <tbody id="tbody_productos">

                            </tbody>
                          </table>
                        </div>
                        <div class="col-sm-12">
                          &nbsp;
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <ul class="pagination pagination-split" id="paginador_productos">

                          </ul>
                        </div>

                      </div>
                      <!-- END CONTENT PRODUCTOS -->

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
  <script src="resources/system/js/pages/operaciones/ordengasto.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menuoperaciones").addClass('active');
    $("#submenuordengasto").addClass('active');
  </script>

</body>

</html>