<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: logout');
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

    <?php include("views/overall/topnav.php"); ?>

    <div class="d-flex align-items-stretch">

      <?php include("views/overall/leftNav.php"); ?>

      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Mi Perfil</h2>
          </div>
        </div>

        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <div class="user-block block">
                  <div class="col-xs-12">
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
                  <br><br>
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
              <div class="col-md-6">
                <div class="user-block block ">
                  <div class="col-xs-12">
                    <form onsubmit="UpdateDataProfile(event);" method="post" id="frmDatos" name="frmDatos">

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

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <?php include("views/overall/footer.php"); ?>

      </div>

    </div>

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
      $("#tabmenuInicio").attr("aria-expanded",true);
      $("#tabmenuInicio1").addClass('show');
      $("#tabmenuInicio1").parent().addClass('active');
      $("#myprofile").addClass('active');
    </script>

  </body>
</html>
