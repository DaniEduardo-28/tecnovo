<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }
  require_once "core/models/ClassEmpresa.php";
  require_once "core/models/ClassDocumentoIdentidad.php";
  $result = $OBJ_EMPRESA->getEmpresa();
  $result1 = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");//solo muestra activos
  $result2 = $OBJ_DOCUMENTO_IDENTIDAD->show("activo");//solo muestra activos
  if ($result['error']=="SI") {
    header('location: ?view=error');
  }
  if ($result1['error']=="SI") {
    header('location: ?view=error');
  }
  if ($result2['error']=="SI") {
    header('location: ?view=error');
  }
  $dataResult = $result['data'];
  $dataResult1 = $result1['data'];
  $dataResult2 = $result2['data'];

 ?>
<!DOCTYPE html>
<html>

  <head>
    <?php include("views/overall/header.php"); ?>
    <title>Mi Empresa | <?=APP_TITLE;?> </title>
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
                                  Configuración
                                </li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">Mi Empresa</li>
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
                                    <h4 class="card-title">Datos Empresa</h4>
                                </div>
                            </div>
                            <div class="card-body">
                              <form class="form-validate" action="#" method="post" id="frmDatos" name="frmDatos" enctype="multipart/form-data">

                                <input type="hidden" name="flag_imagen" id="flag_imagen" value="0">
                                <input type="hidden" name="id_empresa" id="id_empresa" value="<?=$dataResult[0]['id_empresa'];?>">

                                <div class="row">

                                  <div class="form-group col-sm-1">
                                    &nbsp;
                                  </div>

                                  <div class="form-group col-sm-4">
                                    <img id="img_destino" src="<?=$dataResult[0]['src_logo'];?>" alt="Logo Empresa" class="rounded"
                                      style="width:150px;height:150px;">
                                    <br>
                                    <label for="">Logo Empresa</label>
                                    <br>
                                    <div class="form-group">
                                      <input type="file" name="imagen" id="imagen" accept="image/jpeg"
                                      class="is-valid" aria-invalid="false">
                                    </div>
                                  </div>

                                  <div class="form-group col-sm-1">
                                    &nbsp;
                                  </div>

                                  <div class="form-group col-sm-6">

                                    <div class="form-group col-xs-12">
                                      <label for="id_documento" class="label-material">Tipo Documento</label>
                                      <select name="id_documento" id="id_documento" class="form-control">
                                        <option value="<?=$dataResult[0]['id_documento'];?>"><?=$dataResult[0]['name_documento_empresa'];?></option>
                                        <?php
                                          foreach ($dataResult1 as $key) {
                                            if ($key['id_documento']!=$dataResult[0]['id_documento']) {
                                              ?>
                                              <option value="<?=$key['id_documento'];?>"><?=$key['name_documento'];?></option>
                                              <?php
                                            }
                                          }
                                         ?>
                                      </select>
                                    </div>

                                    <div class="form-group col-xs-12">
                                      <label for="num_documento" class="label-control" id="labelNumeroDocumento">Número Documento</label>
                                      <input id="num_documento" type="text" name="num_documento" class="form-control"
                                      autocomplete="off" required data-msg="Campo obligatorio..." value="<?=$dataResult[0]['num_documento'];?>">
                                    </div>

                                    <div class="form-group col-xs-12">
                                      <label for="razon_social" class="label-control" id="labelRazonSocial">Razón Social</label>
                                      <input id="razon_social" type="text" name="razon_social" class="form-control"
                                      autocomplete="off" required data-msg="Campo obligatorio..." value="<?=$dataResult[0]['razon_social'];?>">
                                    </div>

                                  </div>


                                </div>

                                <div class="row">

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="nombre_comercial" class="label-control">Nombre Comercial</label>
                                    <input id="nombre_comercial" type="text" name="nombre_comercial" class="form-control"
                                    autocomplete="off" required data-msg="Campo obligatorio..." value="<?=$dataResult[0]['nombre_comercial'];?>">
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="direccion" class="label-control">Dirección</label>
                                    <input id="direccion" type="text" name="direccion" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['direccion'];?>">
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="correo01" class="label-control">Correo</label>
                                    <input id="correo01" type="email" name="correo01" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['correo01'];?>">
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="fono01" class="label-control">Teléfono</label>
                                    <input id="fono01" type="tel" name="fono01" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['fono01'];?>">
                                  </div>

                                  <div class="form-group col-md-12 col-sm-12">
                                    <label for="web" class="label-control">Web</label>
                                    <input id="web" type="url" name="web" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['web'];?>">
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="id_documento_representante" class="label-control">Tipo Documento Representante</label>
                                    <select name="id_documento_representante" id="id_documento_representante" class="form-control">
                                      <option value="<?=$dataResult[0]['id_documento_representante'];?>"><?=$dataResult[0]['name_documento_representante'];?></option>
                                      <?php
                                        foreach ($dataResult2 as $key) {
                                          if ($key['id_documento']!=$dataResult[0]['id_documento_representante']) {
                                            ?>
                                            <option value="<?=$key['id_documento'];?>"><?=$key['name_documento'];?></option>
                                            <?php
                                          }
                                        }
                                       ?>
                                    </select>
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="num_documento_representante" class="label-control">Número Documento Representante</label>
                                    <input id="num_documento_representante" type="text" name="num_documento_representante" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['num_documento_representante'];?>" required>
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="nombres_representante" class="label-control">Nombres Representante</label>
                                    <input id="nombres_representante" type="text" name="nombres_representante" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['nombres_representante'];?>" required>
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="apellidos_representante" class="label-control">Apellidos Representante</label>
                                    <input id="apellidos_representante" type="text" name="apellidos_representante" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['apellidos_representante'];?>" required>
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="correo02" class="label-control">Correo Representante</label>
                                    <input id="correo02" type="email" name="correo02" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['correo02'];?>">
                                  </div>

                                  <div class="form-group col-md-6 col-sm-6">
                                    <label for="fono02" class="label-control">Teléfono Representante</label>
                                    <input id="fono02" type="tel" name="fono02" class="form-control"
                                    autocomplete="off" value="<?=$dataResult[0]['fono02'];?>">
                                  </div>

                                  <div class="form-group col-md-12">
                                    <br>
                                    <?php
                                        $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("mybusiness"));
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
    <script src="resources/system/js/pages/configuration/mybusiness.js?v=<?=APP_VERSION;?>"></script>

    <script>
     function mostrarImagen(input) {
       if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $('#img_destino').attr('src', e.target.result);
           $("#flag_imagen").val("1");
         }
         reader.readAsDataURL(input.files[0]);
       }
     }
       $("#imagen").change(function(){
       mostrarImagen(this);
     });
   </script>
   <script>
     $("#menuconfiguration").addClass('active');
     $("#menumybusiness").addClass('active');
   </script>
  </body>

</html>
