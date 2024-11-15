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
    <title>Dashboard | <?=APP_TITLE;?> </title>
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
                            <h1>Dashboard</h1>
                          </div>
                          <div class="breadcrumb-bar align-items-center">
                            <nav>
                              <ol class="breadcrumb p-0 m-b-0">
                                <li class="breadcrumb-item">
                                  <a href="index.html"><i class="ti ti-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                  Dashboard
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">Inicio</li>
                              </ol>
                            </nav>
                          </div>

                        </div>
                                <!-- end page title -->
                      </div>
                    </div>

                      <!-- Notification -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="alert border-0 alert-primary bg-gradient m-b-30 alert-dismissible fade show border-radius-none" role="alert">
                            <strong>Hola <?=$_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];?></strong> Te damos la bienvenida al sistema <?=strtoupper(APP_TITLE); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="ti ti-close"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <!-- end row -->


                      <?php
                        $flag_estadisticas = false;
                        $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistaestadisticas"));
                        if ($access_options[0]['error']=="NO") {
                          if ($access_options[0]['flag_buscar']) {
                            $flag_estadisticas = true;
                          }
                        }
                       ?>

                      <?php if ($flag_estadisticas): ?>

                        <!-- begin row -->
                        <div class="row">

                            <div class="col-xs-12">
                              <div class="card card-statistics">
                                <div class="card-header d-flex justify-content-between">
                                  <div class="card-heading">
                                    <h4 class="card-title">Resumen de Ventas</h4>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <h4 class="card-title"><?=numbertomes(date("m")) . " - " . date("Y");?></h4>
                                  <div class="row">
                                    <?php
                                      include("core/models/ClassMoneda.php");
                                      $Resultado = $OBJ_MONEDA->show("1");
                                      if ($Resultado["error"]=="NO") {
                                        $x = 0;
                                        foreach ($Resultado['data'] as $key) {
                                          $color = ['bg-success','bg-danger','bg-warning','bg-default'];
                                          $mes = date("m");
                                          $anio = date("Y");
                                          $id_moneda = $key['id_moneda'];
                                          $monto = $OBJ_MONEDA->getMontoReporte($id_moneda,$mes,$anio);
                                            ?>
                                            <div class="col-12 col-md-3">
                                              <span><?=$key['abreviatura'];?> <b><?=$key['signo'];?> <?=$monto;?></b></span>
                                              <div class="progress my-3" style="height: 4px;">
                                                <div class="progress-bar <?=$color[$x];?>" role="progressbar"
                                                  style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                  aria-valuemax="100"></div>
                                              </div>
                                            </div>
                                            <?php
                                            $x++;
                                          }
                                        }
                                      ?>
                                  </div>
                                </div>
                              </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-xs-12">
                              <div class="card card-statistics">
                                <div class="card-header d-flex justify-content-between">
                                  <!-- <div class="card-heading">
                                    <h4 class="card-title">Resumen de Compras</h4>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <h4 class="card-title"><?=numbertomes(date("m")) . " - " . date("Y");?></h4>
                                  <div class="row">
                                    <?php
                                      $Resultado = $OBJ_MONEDA->show("1");
                                      if ($Resultado["error"]=="NO") {
                                        $x = 0;
                                        foreach ($Resultado['data'] as $key) {
                                          $color = ['bg-success','bg-danger','bg-warning','bg-default'];
                                          $mes = date("m");
                                          $anio = date("Y");
                                          $id_moneda = $key['id_moneda'];
                                          $monto = $OBJ_MONEDA->getMontoReporteCompras($id_moneda,$mes,$anio);
                                            ?>
                                            <div class="col-12 col-md-3">
                                              <span><?=$key['abreviatura'];?> <b><?=$key['signo'];?> <?=$monto;?></b></span>
                                              <div class="progress my-3" style="height: 4px;">
                                                <div class="progress-bar <?=$color[$x];?>" role="progressbar"
                                                  style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                  aria-valuemax="100"></div>
                                              </div>
                                            </div>
                                            <?php
                                            $x++;
                                          }
                                        }
                                      ?>
                                  </div>
                                </div> -->
                              </div>
                            </div>

                        </div>

                        <div class="row">

                          <div class="col-md-8">
                            <div class="card card-statistics">
                                <!-- <div class="card-header">
                                    <h4 class="card-title">Productos y Articulos Stock Mínimo</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th scope="col">Sucursal</th>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Stock Actual</th>
                                                    <th scope="col">Min</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                  include("core/models/ClassOverall.php");
                                                  $Resultado = $OBJ_OVERALL->getProductosAgotados();
                                                  if ($Resultado['error']=="NO") {
                                                    foreach ($Resultado['data'] as $key) {
                                                      ?>
                                                        <tr>
                                                          <td><?=$key['nombre_sucursal'];?></td>
                                                          <td><?=$key['descripcion_producto'];?></td>
                                                          <td><?=$key['stock'] . " " . $key['name_unidad'];?></td>
                                                          <td><?=$key['stock_minimo'] . " " . $key['name_unidad'];?></td>
                                                        </tr>
                                                      <?php
                                                    }
                                                  }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> -->
                            </div>
                          </div>

                          <!-- <?php
                            $Resultado = $OBJ_OVERALL->getTotalesReporte( $_SESSION['id_fundo']);
                            if ($Resultado['error']=="NO") {
                              ?>
                              <div class="col-md-4">
                                  <div class="card card-statistics widget-income-list">
                                      <div class="card-body d-flex align-itemes-center">
                                          <div class="media align-items-center w-100">
                                              <div class="text-left">
                                                  <h3 class="mb-0"><?=$Resultado['data'][0]['total_trabajadores'];?></h3>
                                                  <span>Trabajadores</span>
                                              </div>
                                              <div class="img-icon bg-pink ml-auto">
                                                  <i class="ti ti-user text-white"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body d-flex align-itemes-center">
                                          <div class="media align-items-center w-100">
                                              <div class="text-left">
                                                  <h3 class="mb-0"><?=$Resultado['data'][0]['total_clientes'];?></h3>
                                                  <span>Clientes</span>
                                              </div>
                                              <div class="img-icon bg-primary ml-auto">
                                                  <i class="ti ti-face-smile text-white"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body d-flex align-itemes-center">
                                          <div class="media align-items-center w-100">
                                              <div class="text-left">
                                                  <h3 class="mb-0"><?=$Resultado['data'][0]['total_accesorios'];?></h3>
                                                  <span>Productos</span>
                                              </div>
                                              <div class="img-icon bg-orange ml-auto">
                                                  <i class="ti ti-dropbox text-white"></i>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-body d-flex align-itemes-center">
                                          <div class="media align-items-center w-100">
                                              <div class="text-left">
                                                  <h3 class="mb-0"><?=$Resultado['data'][0]['total_medicamentos'];?></h3>
                                                  <span>Productos</span>
                                              </div>
                                              <div class="img-icon bg-info ml-auto">
                                                  <i class="ti ti-plus text-white"></i>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <?php
                            }
                          ?> -->

                        </div>

                      <?php else: ?>

                        <div class="row">
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                          <br>
                        </div>

                      <?php endif; ?>

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
    <script>
      $("#menuinicio").addClass('active');
      /*$("#tabmenuInicio1").addClass('show');*/
    </script>

  </body>

</html>
