<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: ?view=logout');
    exit();
  }
  require_once "core/models/ClassUsuario.php";
  $result = $OBJ_USUARIO->getUserByCode($_SESSION['id_persona']);
  if ($result['error']=="SI") {
    header('location: ?view=error');
  }
  $dataUser = $result['data'];

 ?>
<!DOCTYPE html>
<html>

  <head>
    <?php include("views/overall/header.php"); ?>
    <title>Mi Perfil | <?=APP_TITLE;?> </title>
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
                                <li class="breadcrumb-item active text-primary" aria-current="page">Mi Perfil</li>
                              </ol>
                            </nav>
                          </div>

                        </div>
                                <!-- end page title -->
                      </div>
                    </div>

                    <div class="row">

                        <div class="col-xl-6">
                          <div class="card card-statistics">
                            <div class="card-header">
                                <div class="card-heading">
                                    <h4 class="card-title">Datos Personales</h4>
                                </div>
                            </div>
                            <div class="card-body">
                              <div class="form-group">
                                <form id="frmSubirImagen" enctype="multipart/form-data" name="frmSubirImagen"
                                  onsubmit="UpdateImageProfile(event);" action="post">
                                  <img id="img_destino" src="<?=$_SESSION['src_image'];?>" alt="Imagen de Perfil" class="img-fluid rounded-circle"
                                  width="200" height="200" style="width:200px;height:200px;">
                                  <br>
                                  <label for="">Imagen de Perfil</label>
                                  <br>
                                  <div class="form-group">
                                    <input type="file" name="txtImgProfile" id="txtImgProfile" accept="image/jpeg"
                                    class="is-valid" aria-invalid="false" required>
                                  </div>
                                  <button type="submit" class="btn btn-primary">Guardar Foto</button>
                                </form>
                              </div>

                              <br>

                              <div class="row">
                                <div class="form-group col-sm-6">
                                  <label for="tipo_docu" class="label-control">Documento</label>
                                  <input id="tipo_docu" type="text" name="tipo_docu" class="form-control"
                                  readonly value="<?=strtoupper($dataUser[0]['name_documento']);?>">
                                </div>
                                <div class=" form-group col-sm-6">
                                  <label for="num_documento" class="label-control">Número</label>
                                  <input id="num_documento" type="text" name="num_documento" class="form-control"
                                  readonly value="<?=$dataUser[0]['num_documento'];?>">
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-sm-12">
                                  <label for="txtNombres" class="label-control">Nombres</label>
                                  <input id="txtNombres" type="text" name="txtNombres" class="form-control"
                                  readonly value="<?=strtoupper($dataUser[0]['nombres']);?>">
                                </div>
                                <div class=" form-group col-sm-12">
                                  <label for="txtApellidos" class="label-control">Apellidos</label>
                                  <input id="txtApellidos" type="text" name="txtApellidos" class="form-control"
                                  readonly value="<?=strtoupper($dataUser[0]['apellidos']);?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">

                          <form onsubmit="UpdateDataProfile(event);" method="post" id="frmDatos" name="frmDatos">

                            <div class="card card-statistics">
                              <div class="card-header">
                                  <div class="card-heading">
                                      <h4 class="card-title">Actualización de Datos</h4>
                                  </div>
                              </div>
                              <div class="card-body">

                                  <div class="row">
                                    <div class="form-group col-sm-12">
                                      <label for="txtAddress" class="label-control">Dirección</label>
                                      <input id="txtAddress" type="text" name="txtAddress" class="form-control"
                                      value="<?=strtoupper($dataUser[0]['direccion']);?>" autocomplete="off">
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="form-group col-sm-12">
                                      <label for="txtEmail" class="label-control">Correo</label>
                                      <input id="txtEmail" type="email" name="txtEmail" class="form-control" autocomplete="off"
                                      value="<?=strtoupper($dataUser[0]['correo']);?>" data-msg="Por favor ingrese un correo válido.">
                                    </div>
                                    <div class="form-group col-sm-6">
                                      <label for="txtPhone" class="label-control">Teléfono</label>
                                      <input id="txtPhone" type="tel" name="txtPhone" class="form-control"
                                      value="<?=strtoupper($dataUser[0]['telefono']);?>" autocomplete="off">
                                    </div>
                                    <div class="form-group col-sm-6">
                                      <label for="txtDateNac" class="label-control">Fecha Nacimiento</label>
                                      <input id="txtDateNac" type="text" name="txtDateNac" class="form-control date-picker-default"
                                      value="<?=date("d/m/Y", strtotime($dataUser[0]['fecha_nacimiento']))?>" autocomplete="off">
                                    </div>
                                  </div>

                                  <br>

                                  <div class="row col-sm-12">
                                    <input type="submit" name="btnGuardar" id="btnGuardar" value="Actualizar Datos"
                                    class="btn btn-primary">
                                  </div>

                              </div>

                            </div>

                          </form>
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
    <script src="resources/system/js/pages/home/myprofile.js?v=<?=APP_VERSION;?>"></script>

    <script>
     function mostrarImagen(input) {
       if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
           $('#img_destino').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
       }
     }
       $("#txtImgProfile").change(function(){
       mostrarImagen(this);
     });
   </script>
   <script>
     $("#menuinicio").addClass('active');
     $("#menumyprofile").addClass('active');
   </script>
  </body>

</html>
