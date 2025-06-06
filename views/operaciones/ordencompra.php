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
  <title>Orden de Compra | <?= APP_TITLE; ?> </title>
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
                          Orden de Compra
                        </li>
                      </ol>
                    </nav>
                  </div>

                  <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions" name="panelOptions">
                    <?php
                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordencompra"));
                    if ($access_options[0]['error'] == "NO") {

                      if ($access_options[0]['flag_agregar']) {
                    ?>
                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top"
                          title="" data-original-title="Agregar" id="btnAdd">
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

            ?>

            <div class="row">

              <div class="col-xl-12">
                <div class="card card-statistics">
                  <div class="card-header">
                    <div class="card-heading">
                      <h4 class="card-title">Orden de Compra</h4>
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
                                  <img src="resources/global/images/sin_imagen.png" class="img-fluid"
                                    alt="Proveedor" id="img_proveedor">
                                </div>
                                <p class="font-weight-bold" id="name_proveedor">No seleccionado</p>
                              </div>
                              <button type="button" class="btn btn-info btn-xs" id="btnSeleccionarProveedor">
                                Seleccionar&nbsp;<span class="fa fa-ellipsis-h"></span>
                              </button>
                            </div>
                            <div class="form-group col-md-3 col-sm-4 d-none">
                              <label for="" class="label-control">Forma de Envío</label>
                              <select class="form-control" name="cboFormaEnvioForm"
                                id="cboFormaEnvioForm">
                                <?php
                                $resultMetodo = $OBJ_METODO_ENVIO->show("1");
                                if ($resultMetodo['error'] == "NO") {
                                  foreach ($resultMetodo['data'] as $key) {
                                ?>
                                    <option value="<?= $key['id_metodo_envio']; ?>"><?= $key['name_metodo']; ?></option>
                                <?php
                                  }
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="codigo_moneda">Moneda(*)</label>
                              <select class="form-control" name="codigo_moneda"
                                id="codigo_moneda" required>
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
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="txtFechaOrdenForm" class="label-control">Fecha Orden</label>
                              <input type="date" name="txtFechaOrdenForm" id="txtFechaOrdenForm"
                                class="form-control" readonly value="<?= date("Y-m-d"); ?>">
                            </div>
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="txtFechaEntregaForm" class="label-control">Fecha Entrega</label>
                              <input type="date" name="txtFechaEntregaForm" id="txtFechaEntregaForm"
                                class="form-control" value="<?= date("Y-m-d"); ?>" min="<?= date("Y-m-d"); ?>">
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                              <label for="txtObservacionesForm" class="label-control">Observaciones</label>
                              <input type="text" name="txtObservacionesForm" id="txtObservacionesForm"
                                class="form-control">
                            </div>
                            <div class="form-group col-md-3 col-sm-4">
                              <label for="txtEstadoForm" class="label-control">Estado</label>
                              <input type="text" name="txtEstadoForm" id="txtEstadoForm"
                                class="form-control" readonly>
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
                                    <th style="width:20px;">Stock</th>
                                    <th style="width:40px; text-align:right;">Precio Compra</th>
                                    <th style="width:100px;">Cantidad</th>
                                    <th>Notas</th>
                                    <th style="width:60px;">Total</th>
                                    <th style="width:20px;">Eliminar</th>
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
                                    <input checked type="radio" name="opcion_busqueda" value="accesorio" id="opcion_accesorio" autocomplete="off"> Producto
                                  </label>
                                  <!-- <label class="btn btn-info">
                                                    <input type="radio" name="opcion_busqueda" value="medicamento" id="opcion_medicamento" autocomplete="off"> Producto
                                                  </label> -->
                                </div>
                                <button type="button" name="btnAgregarDetalle" id="btnAgregarDetalle" class="btn btn-success"><span class="fa fa-plus"></span></button>
                              </div>
                              <!--<br>
                                              <button type="button" class="btn btn-primary" id="btnSeleccionarProducto">
                                                 <span class="fa fa-plus"></span> Agregar Producto&nbsp;
                                              </button>-->
                            </div>
                            <div class="form-group col-sm-5">
                              <br>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-success float-right"
                                id="btnSaveForm">
                                <span class="fa fa-save"></span> Guardar
                              </button>&nbsp;&nbsp;&nbsp;
                              <button type="button" class="btn btn-danger float-right"
                                id="btnCancelForm">
                                <span class="fa fa-close"></span> Cancelar
                              </button>&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group col-sm-2">
                              <label for="txtTotalForm" class="label-control">Total Orden</label>
                              <input type="text" name="txtTotalForm" id="txtTotalForm"
                                value="S/ 0.00" class="form-control" readonly>
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
                              <option value="">Todos</option>
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
                              <input type="text" class="form-control" placeholder="Número documento, nombres, razón social..."
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
                            <?php
                              $primerDiaMes = date('Y-m-01');
                            ?>
                            <input id="txtFechaInicioBuscarListado" type="date" name="txtFechaInicioBuscarListado"
                              class="form-control" autocomplete="off" value="<?= $primerDiaMes; ?>">
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
                              <input type="text" class="form-control" placeholder="Search..."
                                aria-label="Search..." aria-describedby="basic-addon2"
                                id="txtBuscarListado" name="txtBuscarListado">
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
                                <th>Id Orden</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Fecha Orden</th>
                                <th>Fecha Entrega</th>
                                <!-- <th>Forma de Envío</th> -->
                                <th># Productos</th>
                                <th>Total</th>
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

                      <!-- START CONTENT PRODUCTOS -->
                      <div class="col-md-12" id="contenedor_productos">

                        <h4 id="title_modal">Productos</h4>

                        <div class="row">

                          <div class="col-md-10">
                            <label for="">&nbsp;</label>
                            <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder="Buscar..."
                                aria-label="Producto...." aria-describedby="basic-addon2"
                                id="txtBuscarProducto" name="txtBuscarProducto">
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
                                <th style="width:20px;">Num</th>
                                <th>Id Producto</th>
                                <th>Producto</th>
                                <th style="width:60px;">Stock</th>
                                <th style="width:40px;">Precio Unitario</th>
                                <th style="width:90px;">Cantidad</th>
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
  <script src="resources/system/js/pages/operaciones/ordencompra.js?v=<?= APP_VERSION; ?>"></script>
  <script>
    $("#menuoperaciones").addClass('active');
    $("#submenuordencompra").addClass('active');
  </script>

</body>

</html>