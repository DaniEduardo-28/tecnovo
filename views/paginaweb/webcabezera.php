<?php

  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }

  require_once "core/models/ClassOverall.php";

  $result = $OBJ_OVERALL->getOverall(1,15);

  if ($result['error']=="SI") {
    header('location: ?view=error');
  }

  $dataResult = $result['data'];

 ?>
<!DOCTYPE html>
<html>

  <head>
    <?php include("views/overall/header.php"); ?>
    <title>Cabezera - Página Web | <?=APP_TITLE;?> </title>
    <style media="screen">
      .hr{
        margin-top: 2rem;
        margin-bottom: 1rem;
        border: 2;
        border-top: 3px solid rgba(213, 15, 199, 0.48);
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
                                  Página Web
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">
                                  Cabezera
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
                                    <h4 class="card-title">Datos Cabezera - Página Web</h4>
                                </div>
                            </div>
                            <div class="card-body">
                              <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                                <div class="row">

                                  <div class="form-group col-sm-12">
                                    <input type="hidden" name="flag_imagen_1" id="flag_imagen_1" value="0">
                                    <img id="img_destino_1" src="<?=$dataResult[0]['valor_string'];?>" alt="Banner 01"
                                      style="width:100%;height:500px;">
                                    <br>
                                    <label for="">Banner 1</label>
                                    <br>
                                    <div class="form-group">
                                      <input type="file" name="imagen_1" id="imagen_1" accept="image/jpeg"
                                      class="is-valid" aria-invalid="false">
                                    </div>
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="titulo_1" class="label-control">Título</label>
                                    <input type="text" name="titulo_1" id="titulo_1" class="form-control"
                                    value="<?=$dataResult[3]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="boton_1" class="label-control">Texto de Boton</label>
                                    <input type="text" name="boton_1" id="boton_1" class="form-control"
                                    value="<?=$dataResult[9]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="enlace_1" class="label-control">Enlace</label>
                                    <input type="text" name="enlace_1" id="enlace_1" class="form-control"
                                    value="<?=$dataResult[12]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-xs-12">
                                    <label for="descripcion_1" class="label-control">Descripción</label>
                                    <input type="text" name="descripcion_1" id="descripcion_1" class="form-control"
                                    value="<?=$dataResult[6]['valor_string'];?>">
                                  </div>

                                  <div class="col-xs-12">
                                    <div class="hr"></div>
                                    <br><br>
                                  </div>

                                  <div class="form-group col-sm-12">
                                    <input type="hidden" name="flag_imagen_2" id="flag_imagen_2" value="0">
                                    <img id="img_destino_2" src="<?=$dataResult[1]['valor_string'];?>" alt="Banner 02"
                                      style="width:100%;height:500px;">
                                    <br>
                                    <label for="">Banner 2</label>
                                    <br>
                                    <div class="form-group">
                                      <input type="file" name="imagen_2" id="imagen_2" accept="image/jpeg"
                                      class="is-valid" aria-invalid="false">
                                    </div>
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="titulo_2" class="label-control">Título</label>
                                    <input type="text" name="titulo_2" id="titulo_2" class="form-control"
                                    value="<?=$dataResult[4]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="boton_2" class="label-control">Texto de Boton</label>
                                    <input type="text" name="boton_2" id="boton_2" class="form-control"
                                    value="<?=$dataResult[10]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="enlace_2" class="label-control">Enlace</label>
                                    <input type="text" name="enlace_2" id="enlace_2" class="form-control"
                                    value="<?=$dataResult[13]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-xs-12">
                                    <label for="descripcion_2" class="label-control">Descripción</label>
                                    <input type="text" name="descripcion_2" id="descripcion_2" class="form-control"
                                    value="<?=$dataResult[7]['valor_string'];?>">
                                  </div>

                                  <div class="col-xs-12">
                                    <div class="hr"></div>
                                    <br><br>
                                  </div>

                                  <div class="form-group col-sm-12">
                                    <input type="hidden" name="flag_imagen_3" id="flag_imagen_3" value="0">
                                    <img id="img_destino_3" src="<?=$dataResult[2]['valor_string'];?>" alt="Banner 03"
                                      style="width:100%;height:500px;">
                                    <br>
                                    <label for="">Banner 3</label>
                                    <br>
                                    <div class="form-group">
                                      <input type="file" name="imagen_3" id="imagen_3" accept="image/jpeg"
                                      class="is-valid" aria-invalid="false">
                                    </div>
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="titulo_3" class="label-control">Título</label>
                                    <input type="text" name="titulo_3" id="titulo_3" class="form-control"
                                    value="<?=$dataResult[5]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="boton_3" class="label-control">Texto de Boton</label>
                                    <input type="text" name="boton_3" id="boton_3" class="form-control"
                                    value="<?=$dataResult[11]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-4 col-sm-6">
                                    <label for="enlace_3" class="label-control">Enlace</label>
                                    <input type="text" name="enlace_3" id="enlace_3" class="form-control"
                                    value="<?=$dataResult[14]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-xs-12">
                                    <label for="descripcion_3" class="label-control">Descripción</label>
                                    <input type="text" name="descripcion_3" id="descripcion_3" class="form-control"
                                    value="<?=$dataResult[8]['valor_string'];?>">
                                  </div>

                                  <div class="form-group col-md-12">
                                    <br>
                                    <?php
                                        $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("webcabezera"));
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
    <script src="resources/system/js/pages/paginaweb/webcabezera.js?v=<?=APP_VERSION;?>"></script>

    <script>

     function mostrarImagen_1(input) {
       if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $('#img_destino_1').attr('src', e.target.result);
           $("#flag_imagen_1").val("1");
         }
         reader.readAsDataURL(input.files[0]);
       }
     }

     function mostrarImagen_2(input) {
       if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $('#img_destino_2').attr('src', e.target.result);
           $("#flag_imagen_2").val("1");
         }
         reader.readAsDataURL(input.files[0]);
       }
     }

     function mostrarImagen_3(input) {
       if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $('#img_destino_3').attr('src', e.target.result);
           $("#flag_imagen_3").val("1");
         }
         reader.readAsDataURL(input.files[0]);
       }
     }

     $("#imagen_1").change(function(){
       mostrarImagen_1(this);
     });

     $("#imagen_2").change(function(){
       mostrarImagen_2(this);
     });

     $("#imagen_3").change(function(){
       mostrarImagen_3(this);
     });

   </script>
   <script>
     $("#menupaginaweb").addClass('active');
     $("#menuwebcabezera").addClass('active');
   </script>
  </body>

</html>
