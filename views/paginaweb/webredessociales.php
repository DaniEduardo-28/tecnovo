<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

  require_once "core/models/ClassOverall.php";

  $result = $OBJ_OVERALL->getOverall(19,22);

  if ($result['error']=="SI") {
    header('location: ?view=error');
  }

  $dataResult = $result['data'];

 ?>
<!DOCTYPE html>
<html>

  <head>
    <?php include("views/overall/header.php"); ?>
    <title>Redes Sociales - Página Web | <?=APP_TITLE;?> </title>
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
                                  Página Web
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">
                                  Redes Sociales
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
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title">Redes Sociales - Página Web</h4>
                                </div>
                            </div>
                            <div class="card-body">
                              <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                                <div class="row">

                                  <div class="form-group col-sm-6">
                                    <label for="link_1" class="label-control">Facebook</label>
                                    <input type="text" name="link_1" id="link_1" class="form-control"
                                    value="<?=$dataResult[0]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="link_2" class="label-control">Instagram</label>
                                    <input type="text" name="link_2" id="link_2" class="form-control"
                                    value="<?=$dataResult[1]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="link_3" class="label-control">Youtube</label>
                                    <input type="text" name="link_3" id="link_3" class="form-control"
                                    value="<?=$dataResult[2]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="link_4" class="label-control">Twitter</label>
                                    <input type="text" name="link_4" id="link_4" class="form-control"
                                    value="<?=$dataResult[3]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-12">
                                    <br>
                                    <?php
                                        $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webredessociales"));
                                        if ($access_options[0]['error']=="NO") {
                                          if ($access_options[0]['flag_editar']) {
                                            echo '<button type="submit" name="btnSave" id="btnSave" name="button" class="btn btn-primary btn-lg float-right"> <span class="fa fa-save"></span> Guardar Cambios</button>';
                                          }
                                        }
                                     ?>
                                  </div>
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
    <script src="resources/system/js/pages/paginaweb/webredessociales.js?v=<?=APP_VERSION;?>"></script>
    <script>
     $("#menupaginaweb").addClass('active');
     $("#menuwebredessociales").addClass('active');
    </script>
  </body>

</html>
