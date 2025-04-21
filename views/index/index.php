<?php
if (isset($_SESSION['id_trabajador'])) {
    header('location: ?view=home');
}

$name_user = "";
$pass_user = "";
$recordar = "";
if (isset($_COOKIE['flag_save'])) {
    if ($_COOKIE['flag_save'] == true) {
        $name_user = $_COOKIE['name_user'];
        $pass_user = $_COOKIE['pass_user'];
        $recordar = "checked";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | <?= APP_TITLE; ?></title>
    <?php include("views/overall/header.php"); ?>
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap" style="background-color: #98f780; height: 100vh;">

            <!-- begin pre-loader -->
            <?php include("views/overall/loader.php"); ?>
            <!-- end pre-loader -->
            <!--start login contant-->
            <div class="app-contant">
                <div style="background-color:rgb(255, 255, 255); height: 100vh;">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <!-- Formulario a la izquierda -->
                            <div class="col-sm-6 col-lg-6 col-xxl-4 align-self-center order-1 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="login p-50" style="background-color:rgb(255, 255, 255);">
                                        <img src=" " alt="">
                                        <h1 class="mb-2" style="color: #000000; font-family: Arial, sans-serif;"><?= APP_TITLE; ?> Login</h1> <!-- Título azul, fuente Arial -->
                                        <p style="color: #000000">Bienvenido, por favor inicie sesión en su cuenta.</p>
                                        <form class="mt-3 mt-sm-5" id="frmLogin" onsubmit="goLogin(event);">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label" style="color: #000000">Nombre de Usuario*</label>
                                                        <input type="text" class="form-control" id="login-username" name="login-username"
                                                            placeholder="Nombre de usuario..." required value="<?= $name_user; ?>" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label" style="color: #000000">Contraseña*</label>
                                                        <input type="password" class="form-control" id="login-password" name="login-password"
                                                            placeholder="Contraseña..." required value="<?= $pass_user; ?>" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Sucursal*</label>
                                                        <select class="form-control" name="id_sucursal" id="id_sucursal" required>
                                                          <option value="">Selecione</option>
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
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-block d-sm-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="chkRemember"
                                                                name="chkRemember" <?= $recordar; ?> style="border-color: #E65000">
                                                            <label class="form-check-label" for="chkRemember" style="color: #000000">
                                                                Recuérdame
                                                            </label>
                                                        </div>
                                                        <a href="#" class="ml-auto mt-2 mt-sm-0" style="margin-left: 15px; color: #000000">¿Olvidaste tu Contraseña?</a>
                                                    </div>
                                                </div>
                                                <div id="__ajax__"></div>
                                                <div class="col-12 mt-3">
                                                    <input type="submit" class="btn btn-primary text-uppercase" value="Iniciar Sesión"
                                                        style="background-color: #E65000; border-color: #E65000; color: #ffffff;">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Imagen a la derecha -->
                            <div class="col-sm-6 col-xxl-8 col-lg-6 o-hidden order-2 order-sm-2" style="background-color: #E65000;">
                                <div class="row align-items-center h-100">
                                    <div class="col-10 mx-auto">
                                        <img class="img-fluid" src="resources/template/assets/img/bg/" alt="">
                                    </div>
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
    <script src="resources/system/js/pages/index/index.js?v=<?= APP_VERSION; ?>"></script>

</body>

</html>