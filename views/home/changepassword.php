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
    <title>Cambiar Contraseña | <?=APP_TITLE;?> </title>
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
                                  Inicio
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">Cambiar Contraseña</li>
                              </ol>
                            </nav>
                          </div>

                        </div>
                                <!-- end page title -->
                      </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                          &nbsp;
                        </div>

                        <div class="col-md-6 col-sm-12">
                          <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title">Actualización de Clave</h4>
                                </div>
                            </div>
                            <div class="card-body">
                              <form onsubmit="UpdatePassword(event);" method="post" id="frmDatos" name="frmDatos">

                                <div class="row">

                                  <div class="form-group col-md-3"></div>
                                  <div class="form-group col-md-6">
                                    <label for="txtPassOld" class="label-control">Clave Actual</label>
                                    <input id="txtPassOld" type="password" name="txtPassOld" class="form-control"
                                    autocomplete="off" required data-msg="Por favor ingrese su clave actual.">
                                  </div>
                                  <div class="form-group col-md-3"></div>

                                  <div class="form-group col-md-3"></div>
                                  <div class="form-group col-md-6">
                                    <label for="txtNewPass" class="label-control">Nueva Clave</label>
                                    <input id="txtNewPass" type="password" name="txtNewPass" class="form-control"
                                    autocomplete="off" data-msg="Por favor ingrese una nueva clave de acceso." required>
                                  </div>
                                  <div class="form-group col-md-3"></div>

                                  <div class="form-group col-md-3"></div>
                                  <div class="form-group col-md-6">
                                    <label for="txtNewPass1" class="label-control">Repetir Clave</label>
                                    <input id="txtNewPass1" type="password" name="txtNewPass1" class="form-control" required
                                    autocomplete="off" data-msg="Por favor repita su nueva clave de acceso.">
                                  </div>
                                  <div class="form-group col-md-3"></div>

                                  <div class="form-group col-md-3"></div>
                                  <div class="form-group col-md-6">
                                    <input type="submit" name="btnGuardar" id="btnGuardar" value="Actualizar Clave"
                                    class="btn btn-primary form-control" style="color:#fff;">
                                  </div>
                                  <div class="form-group col-md-3"></div>

                                </div>

                              </form>
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
    <script src="resources/system/js/pages/home/changepassword.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#menuinicio").addClass('active');
      $("#menuchangepassword").addClass('active');
    </script>
  </body>

</html>
