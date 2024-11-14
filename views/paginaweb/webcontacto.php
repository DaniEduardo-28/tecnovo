<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

  require_once "core/models/ClassOverall.php";

  $result = $OBJ_OVERALL->getOverall(1,50);

  if ($result['error']=="SI") {
    header('location: ?view=error');
  }

  $dataResult = $result['data'];

 ?>
<!DOCTYPE html>
<html>

  <head>
    <?php include("views/overall/header.php"); ?>
    <title>Datos de Contacto - Página Web | <?=APP_TITLE;?> </title>
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
                                  Datos de Contacto
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
                                    <h4 class="card-title">Datos de Contacto - Página Web</h4>
                                </div>
                            </div>
                            <div class="card-body">
                              <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                                <div class="row">

                                  <div class="form-group col-sm-6">
                                    <label for="horario_top_nav" class="label-control">Horario Top Nav y Footer</label>
                                    <input type="text" name="horario_top_nav" id="horario_top_nav" class="form-control"
                                    value="<?=$dataResult[15]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="correo" class="label-control">Correo Soporte Técnico</label>
                                    <input type="email" name="correo" id="correo" class="form-control"
                                    value="<?=$dataResult[16]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="telefono" class="label-control">Teléfono</label>
                                    <input type="tel" name="telefono" id="telefono" class="form-control"
                                    value="<?=$dataResult[17]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="direccion" class="label-control">Dirección Footer</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control"
                                    value="<?=$dataResult[23]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="number_clientes" class="label-control">Clientes Felices</label>
                                    <input type="number" min="1" name="number_clientes" id="number_clientes" class="form-control"
                                    value="<?=$dataResult[24]['valor_int'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="number_proyectos" class="label-control">Proyectos</label>
                                    <input type="number" min="1" name="number_proyectos" id="number_proyectos" class="form-control"
                                    value="<?=$dataResult[25]['valor_int'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="number_premios" class="label-control">Premios</label>
                                    <input type="number" min="1" name="number_premios" id="number_premios" class="form-control"
                                    value="<?=$dataResult[26]['valor_int'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="number_horas" class="label-control">Horas Trabajadas</label>
                                    <input type="number" min="1" name="number_horas" id="number_horas" class="form-control"
                                    value="<?=$dataResult[27]['valor_int'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_1" class="label-control">Horario Lunes</label>
                                    <input type="text" name="horario_1" id="horario_1" class="form-control"
                                    value="<?=$dataResult[28]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_2" class="label-control">Horario Martes</label>
                                    <input type="text" name="horario_2" id="horario_2" class="form-control"
                                    value="<?=$dataResult[29]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_3" class="label-control">Horario Miércoles</label>
                                    <input type="text" name="horario_3" id="horario_3" class="form-control"
                                    value="<?=$dataResult[30]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_4" class="label-control">Horario Jueves</label>
                                    <input type="text" name="horario_4" id="horario_4" class="form-control"
                                    value="<?=$dataResult[31]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_5" class="label-control">Horario Viernes</label>
                                    <input type="text" name="horario_5" id="horario_5" class="form-control"
                                    value="<?=$dataResult[32]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_6" class="label-control">Horario Sábado</label>
                                    <input type="text" name="horario_6" id="horario_6" class="form-control"
                                    value="<?=$dataResult[33]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-6 col-md-3">
                                    <label for="horario_7" class="label-control">Horario Domingo</label>
                                    <input type="text" name="horario_7" id="horario_7" class="form-control"
                                    value="<?=$dataResult[34]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-sm-12">
                                    <label for="descripcion_footer" class="label-control">Descripción Footer</label>
                                    <textarea name="descripcion_footer" id="descripcion_footer" class="form-control"
                                    rows="8" cols="80"><?=$dataResult[35]['valor_string'];?></textarea>
                                  </div>

                                  <div class="form-group col-sm-12">
                                    <label for="mapa" class="label-control">Mapa de Contacto (google)</label>
                                    <textarea name="mapa" id="mapa" class="form-control"
                                    rows="8" cols="80"><?=$dataResult[36]['valor_string'];?></textarea>
                                  </div>

                                  <div class="form-group col-md-12">
                                    <br>
                                    <?php
                                        $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webcontacto"));
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
    <script src="resources/system/js/pages/paginaweb/webcontacto.js?v=<?=APP_VERSION;?>"></script>
    <script>
     $("#menupaginaweb").addClass('active');
     $("#menuwebcontacto").addClass('active');
    </script>
  </body>

</html>
