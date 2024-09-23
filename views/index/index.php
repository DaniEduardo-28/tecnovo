<?php
  if (isset($_SESSION['id_trabajador'])) {
    header('location: ?view=home');
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
<html lang="en">
<head>
    <title>Login | <?=APP_TITLE; ?></title>
    <?php include("views/overall/header.php"); ?>
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">

            <!-- begin pre-loader -->
            <?php include("views/overall/loader.php"); ?>
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="login p-50">
                                        <h1 class="mb-2"><?=APP_TITLE; ?> Login</h1>
                                        <p>Bienvenido, por favor inicie sesión en su cuenta.</p>
                                        <form class="mt-3 mt-sm-5" id="frmLogin" onsubmit="goLogin(event);">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre de Usuario*</label>
                                                        <input type="text" class="form-control" id="login-username" name="login-username"
                                                         placeholder="Nombre de usuario..." required value="<?=$name_user;?>" autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Contraseña*</label>
                                                        <input type="password" class="form-control" id="login-password" name="login-password"
                                                         placeholder="Contraseña..." required value="<?=$pass_user;?>" autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="col-12">
<!--                                                     <div class="form-group">
                                                        <label class="control-label">Sucursal*</label>
                                                        <select class="form-control" name="id_fundo" id="id_fundo" required>
                                                          <option value="">Selecione</option>
                                                          <?php
                                                            include("core/models/ClassSucursal.php");
                                                            $dataSucursal = $OBJ_SUCURSAL->show(ID_EMPRESA,"1");
                                                            if ($dataSucursal["error"]=="NO") {
                                                              foreach ($dataSucursal["data"] as $key) {
                                                                echo '<option value="' . $key['id_fundo'] . '">' . $key['nombre'] . '</option>';
                                                              }
                                                            }
                                                          ?>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-12">
                                                    <div class="d-block d-sm-flex  align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="chkRemember"
                                                            name="chkRemember" <?=$recordar;?>>
                                                            <label class="form-check-label" for="chkRemember">
                                                                Recuérdame
                                                            </label>
                                                        </div>
                                                        <a href="#" class="ml-auto">¿Olvidaste tu Contraseña?</a>
                                                    </div>
                                                </div>
                                                <div id="__ajax__">

                                                </div>
                                                <div class="col-12 mt-3">
                                                  <input type="submit" class="btn btn-primary text-uppercase" value="Iniciar Sesión">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-9 col-lg-7 bg-gradient o-hidden order-1 order-sm-2">
                                <div class="row align-items-center h-100">
                                    <div class="col-7 mx-auto ">
                                        <img class="img-fluid" src="resources/template/assets/img/bg/petspace.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end login contant-->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <?php include("views/overall/js.php"); ?>
    <script src="resources/system/js/pages/index/index.js?v=<?=APP_VERSION;?>"></script>

</body>

</html>
