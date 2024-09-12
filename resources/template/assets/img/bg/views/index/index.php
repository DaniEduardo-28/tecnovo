<?php
  if (isset($_SESSION['id_trabajador'])) {
    header('location: home');
  }
  $name_user="";
  $pass_user="";
  $recordar="";
  if (isset($_COOKIE['flag_save'])) {
    if ($_COOKIE['flag_save']==true) {
      $name_user = $_COOKIE['name_user'];
      $pass_user = $_COOKIE['pass_user'];
      $recordar = "checked";
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>

    <title>Login | <?=APP_TITLE; ?></title>
    <?php include("views/overall/header.php"); ?>

  </head>
  <body>
    <div class="login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1><?=APP_TITLE; ?> Login</h1>
                  </div>
                  <p>
                    Bienvenido, por favor inicie sesión en su cuenta.
                  </p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form class="form-validate" id="frmLogin" onsubmit="goLogin(event);">
                    <div class="form-group">
                      <input type="text" class="input-material" id="login-username" name="login-username"
                       required value="<?=$name_user;?>" autocomplete="off" data-msg="Por favor ingrese el nombre de usuario"/>
                      <label for="login-username" class="label-material">Nombre de Usuario</label>
                    </div>
                    <div class="form-group">
                      <input type="password" class="input-material" id="login-password" name="login-password"
                       required value="<?=$pass_user;?>" autocomplete="off" data-msg="Por favor ingrese su contraseña."/>
                      <label for="login-password" class="label-material">Contraseña</label>
                    </div>
                    <div class="form-group">
                      <label for="id_sucursal">Sucursal</label>
                      <select id="id_sucursal" required class="form-control mb-3 mb-3"
                        data-msg="Por favor seleccione una sucursal." name="id_sucursal">
                        <option value="">Seleccione...</option>
                        <?php
                          include("core/models/ClassSucursal.php");
                          $dataSucursal = $OBJ_SUCURSAL->show(ID_EMPRESA,"1");
                          if ($dataSucursal["error"]=="NO") {
                            foreach ($dataSucursal["data"] as $key) {
                              echo '<option value="' . $key['id_sucursal'] . '">' . $key['nombre'] . '</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <div class="i-checks">
                        <input id="chkRemember" name="chkRemember" type="checkbox"
                        value="" <?=$recordar;?> class="checkbox-template">
                        <label for="chkRemember">Recuérdame</label>
                      </div>
                    </div>
                    <div id="__ajax__" class="form-group">

                    </div>

                    <input id="login" type="submit" class="btn btn-primary float-right" value="Iniciar Sesión">
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
         <p><?=APP_COPY;?></p>
      </div>
    </div>

    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/index/index.js?v=<?=APP_VERSION;?>"></script>

  </body>
</html>
