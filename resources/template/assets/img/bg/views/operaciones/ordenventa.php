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
    <title>Facturación | <?=APP_TITLE;?> </title>
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
                                      Facturación
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                              <div class="ml-auto align-items-center secondary-menu text-center" id="panelOptions" name="panelOptions">
                                <?php
                                    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));
                                    if ($access_options[0]['error']=="NO") {
                                      if ($access_options[0]['flag_agregar']) {
                                        ?>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top"
                                          title="" data-original-title="Nueva Orden" id="btnAdd">
                                          <i class="fe fe-plus-circle btn btn-icon text-primary"></i>
                                        </a>
                                        <?php
                                      }
                                      if ($access_options[0]['flag_descargar']) {
                                        ?>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                                         data-original-title="Descargar reporte en pdf">
                                          <i class="fa fa-file-pdf-o btn btn-icon text-danger"></i>
                                        </a>
                                        <a href="#" class="tooltip-wrapper" data-toggle="tooltip" data-placement="top" title=""
                                          data-original-title="Descargar reporte en excel">
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
                                        <h4 class="card-title">Facturación</h4>
                                    </div>
                                </div>
                                <div class="card-body">

                                  <div class="row">

                                    <div class="col-md-12" id="panelForm"> <!-- d-none -->

                                      <div class="ser-block block">

                                        <div class="row">
                                          <div class="form-group col-sm-12">
                                            <button type="button" name="button" class="btn btn-primary float-right disabled" disabled>
                                              <span class="fa fa-print"></span>
                                            </button>
                                          </div>
                                        </div>

                                        <form id="frmDatos" name="frmDatos">

                                          <input type="hidden" name="id_venta" id="id_venta" value="">
                                          <input type="hidden" name="accion" id="accion" value="add">

                                          <div class="row">

                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="codigo_documento_venta">Doc. Venta(*)</label>
                                              <select class="form-control" name="codigo_documento_venta"
                                                    id="codigo_documento_venta" required>
                                                <option value="">Seleccione</option>
                                                <?php
                                                  include('core/models/ClassDocumentoVenta.php');
                                                  $dataDocuVenta = $OBJ_DOCUMENTO_VENTA->show($_SESSION['id_sucursal'],"1");
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
                                            <div class="form-group col-md-2 col-sm-3">
                                              <label for="serie">Serie</label>
                                              <input type="text" id="serie" name="serie" readonly class="form-control">
                                            </div>
                                            <div class="form-group col-md-2 col-sm-3">
                                              <label for="correlativo">Correlativo</label>
                                              <input type="text" name="correlativo" id="correlativo" readonly class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="codigo_documento_cliente">Doc. Cliente (*)</label>
                                              <select class="form-control" name="codigo_documento_cliente"
                                                    id="codigo_documento_cliente" required>
                                                <option value="">Seleccione</option>
                                                <?php
                                                  include('core/models/ClassDocumentoIdentidad.php');
                                                  $dataDocuCliente = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");
                                                  if ($dataDocuCliente["error"]=="NO") {
                                                    foreach ($dataDocuCliente["data"] as $key) {
                                                      echo '<option value="' . $key['id_documento'] . '">' . $key['name_documento'] . '</option>';
                                                    }
                                                  }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="numero_documento_cliente">N° Documento(*)</label>
                                              <input type="text" name="numero_documento_cliente" id="numero_documento_cliente"
                                              class="form-control" required autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="nombres" id="lblNombres">Nombres(*)</label>
                                              <input type="text" name="nombres" id="nombres"
                                              class="form-control" required autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="apellidos" id="lblApellidos">Apellidos</label>
                                              <input type="text" name="apellidos" id="apellidos"
                                              class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="direccion">Dirección (Obigatorio para RUC)</label>
                                              <input type="text" name="direccion" id="direccion"
                                              class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="telefono">Teléfono</label>
                                              <input type="tel" name="telefono" id="telefono"
                                              class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="correo">E-mail</label>
                                              <input type="email" name="correo" id="correo"
                                              class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="fecha">Fecha(*)</label>
                                              <input type="date" name="fecha" id="fecha"
                                              class="form-control" required value="<?=date("Y-m-d");?>">
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="codigo_moneda">Moneda(*)</label>
                                              <select class="form-control" name="codigo_moneda"
                                                    id="codigo_moneda" required>
                                                <option value="">Seleccione</option>
                                                <?php
                                                  include('core/models/ClassMoneda.php');
                                                  $dataMoneda = $OBJ_MONEDA->show("1");
                                                  if ($dataMoneda["error"]=="NO") {
                                                    foreach ($dataMoneda["data"] as $key) {
                                                      if ($key['flag_principal']) {
                                                        echo '<option value="' . $key['id_moneda'] . "|" . $key['cod_sunat'] . '" selected>' . $key['name_moneda'] . '</option>';
                                                      } else {
                                                        echo '<option value="' . $key['id_moneda'] . "|" . $key['cod_sunat'] . '">' . $key['name_moneda'] . '</option>';
                                                      }
                                                    }
                                                  }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6">
                                              <label for="codigo_forma_pago">Método de Pago(*)</label>
                                              <select class="form-control" name="codigo_forma_pago"
                                                    id="codigo_forma_pago" required>
                                                <option value="">Seleccione</option>
                                                <?php
                                                  include('core/models/ClassMetodoPago.php');
                                                  $dataMetodoPago = $OBJ_METODO_PAGO->show("1");
                                                  if ($dataMetodoPago["error"]=="NO") {
                                                    foreach ($dataMetodoPago["data"] as $key) {
                                                      echo '<option value="' . $key['codigo_sunat'] . '">' . $key['name_forma_pago'] . '</option>';
                                                    }
                                                  }
                                                ?>
                                              </select>
                                            </div>

                                          </div>

                                          <div class="row">

                                            <div class="form-group col-md-12">
                                              &nbsp;
                                            </div>

                                            <div class="form-group col-md-12">
                                              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-info active">
                                                  <input type="radio" name="opcion_busqueda" value="servicio" id="opcion_servicio" autocomplete="off" checked> Servicio
                                                </label>
                                                <label class="btn btn-info">
                                                  <input type="radio" name="opcion_busqueda" value="accesorio" id="opcion_accesorio" autocomplete="off"> Producto
                                                </label>
                                                <label class="btn btn-info">
                                                  <input type="radio" name="opcion_busqueda" value="medicamento" id="opcion_medicamento" autocomplete="off"> Producto
                                                </label>
                                              </div>
                                              <button type="button" name="btnAgregarDetalle" id="btnAgregarDetalle" class="btn btn-success"><span class="fa fa-plus"></span></button>
                                            </div>

                                          </div>

                                          <div class="row">
                                            <div class="col-md-12">
                                              <div class="table-responsive">
                                                <table id="example1" class="table table-bordered">
                                                  <thead>
                                                    <tr>
                                                      <th>Nombre Tabla</th>
                                                      <th>Código</th>
                                                      <th>Descripción</th>
                                                      <th>Cantidad</th>
                                                      <th>Precio Unit.</th>
                                                      <th>Descuento</th>
                                                      <th>Sub Total</th>
                                                      <th>Tipo IGV</th>
                                                      <th>IGV</th>
                                                      <th>Total</th>
                                                      <th style="width:30px;">&nbsp;&nbsp;X&nbsp;&nbsp;</th>
                                                    </tr>
                                                  </thead>
                                                </table>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="form-group col-md-12">
                                              <button type="submit" name="btnSave" id="btnSave" name="button" class="btn btn-success float-right"> <span class="fa fa-save"></span> Guardar</button>
                                              <button type="reset" name="btnCancel" id="btnCancel" name="button" class="btn btn-danger float-right"> <span class="fa fa-arrow-left"></span> Volver</button>
                                            </div>
                                          </div>

                                        </form>
                                      </div>
                                    </div>

                                    <div class="col-md-12" id="panelTabla">

                                      <div class="row">
                                        <div class="form-group col-md-3 col-sm-6">
                                          <label for="cboTipoDocVentaBuscar" class="label-control">Documento de Venta</label>
                                          <select name="cboTipoDocVentaBuscar" id="cboTipoDocVentaBuscar" class="form-control">
                                            <option value="">Todos</option>
                                            <?php
                                              $dataDocuVenta = $OBJ_DOCUMENTO_VENTA->show($_SESSION['id_sucursal'],"all");
                                              if ($dataDocuVenta["error"]=="NO") {
                                                foreach ($dataDocuVenta["data"] as $key) {
                                                  if ($key['cod_sunat']!="07" && $key['cod_sunat']!="08") {
                                                    echo '<option value="' . $key['cod_sunat'] . '">' . $key['nombre_corto'] . '</option>';
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
                                              $dataDocuCliente = $OBJ_DOCUMENTO_IDENTIDAD->show("all");
                                              if ($dataDocuCliente["error"]=="NO") {
                                                foreach ($dataDocuCliente["data"] as $key) {
                                                  echo '<option value="' . $key['codigo_sunat'] . '">' . $key['name_documento'] . '</option>';
                                                }
                                              }
                                            ?>
                                          </select>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
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
                                                <th>Doc. Venta</th>
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

    <div class="modal fade" id="modalAgregarDetalle" tabindex="-1" role="dialog" aria-labelledby="modalAgregarDetalleTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="title_modal">Agregar Servicio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="sucursal_buscar">Sucursal</label>
                <select class="form-control" name="sucursal_buscar" id="sucursal_buscar">
                  <?php
                    include("core/models/ClassSucursal.php");
                    $dataSucursal = $OBJ_SUCURSAL->show(ID_EMPRESA,"1");
                    if ($dataSucursal["error"]=="NO") {
                      foreach ($dataSucursal["data"] as $key) {
                        if ($_SESSION['id_sucursal']==$key['id_sucursal']) {
                          echo '<option value="' . $key['id_sucursal'] . '" selected>' . $key['nombre'] . '</option>';
                        }else {
                          echo '<option value="' . $key['id_sucursal'] . '">' . $key['nombre'] . '</option>';
                        }
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-8">
                <label for="">&nbsp;</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Search..." aria-label="Recipient's username"
                  aria-describedby="basic-addon2" id="txtBuscarDetalle" name="txtBuscarDetalle">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="btnSearchDetalle" type="button">Buscar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table id="example2" class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="text-align:center;">#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Cantidad</th>
                      <th>Precio Unit.</th>
                      <th>Precio Unit.</th>
                      <th style="width:30px;">Seleccionar</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="col-md-12 col-sm-12 col-xs-12 text-center" id="divPaginador_Modal">
                <ul class="pagination pagination-split" id="paginador_modal">

                </ul>
              </div>
            </div>
          </div>
          <div class="modal-footer">

          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/operaciones/ordenventa.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menuoperaciones").addClass('active');
      $("#submenuordenventa").addClass('active');
    </script>

  </body>
</html>
