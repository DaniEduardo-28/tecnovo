<?php
  if (!isset($_SESSION['id_trabajador'])) {
    header('location: logout');
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

    <?php include("views/overall/topnav.php"); ?>

    <div class="d-flex align-items-stretch">

      <?php include("views/overall/leftNav.php"); ?>

      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Cambiar Contraseña</h2>
          </div>
        </div>

        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12">
                <div class="user-block block">
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
          </div>
        </section>

        <?php include("views/overall/footer.php"); ?>

      </div>

    </div>

    <!-- JavaScript files-->
    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/home/changepassword.js?v=<?=APP_VERSION;?>"></script>
    <script>
      $("#tabmenuInicio").attr("aria-expanded",true);
      $("#tabmenuInicio1").addClass('show');
      $("#tabmenuInicio1").parent().addClass('active');
      $("#changepassword").addClass('active');
    </script>

  </body>
</html>
