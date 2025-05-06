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
    <title>Acceso Denegado | <?=APP_TITLE;?> </title>
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
                                      Error
                                    </li>
                                    <li class="breadcrumb-item active text-primary" aria-current="page">
                                      Acceso Denegado
                                    </li>
                                  </ol>
                                </nav>
                              </div>

                            </div>
                                    <!-- end page title -->
                          </div>
                        </div>

                        <div class="row">

                            <div class="col-xl-12">
                              <div class="card card-statistics">
                                <div class="card-body">

                                  <div class="row">

                                    <!-- START CONTENT -->

                                    <div class="container">
                                      <div class="row justify-content-center align-items-center">
                                        <div class="col-md-8 text-center">
                                          <div class="error-text">
                                            <img src="resources/global/images/401.jpg" alt="Acceso Denegado"
                                            style="width:400px;height:400px;">
                                            <h3 class="m-t-30">¡Acceso Denegado!</h3>
                                            <p>Usted no cuenta con permisos para acceder a esta página. Si cree que es un error comunicarse con el área de sistemas.</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- END CONTENT -->

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
    <script>
      $("#menuinicio").addClass('active');
    </script>

  </body>

</html>
