<?php

$name_user = isset($_POST["login-username"]) ? $_POST["login-username"] : "";
$pass_user  = isset($_POST["login-password"]) ? encript($_POST["login-password"]) : "";
$recordar  = isset($_POST["chkRemember"]) ? $_POST["chkRemember"] : "";
$id_sucursal  = isset($_POST["id_sucursal"]) ? $_POST["id_sucursal"] : "";

try {

  if (empty($name_user)) {
    throw new Exception("Campo usuario, obligatorio.");
  }

  if (empty($pass_user)) {
    throw new Exception("Campo contraseña, obligatorio.");
  }

  if (empty($id_sucursal)) {
    throw new Exception("Seleccionar una sucursal.");
  }

  require_once "core/models/ClassUsuario.php";
  $Resultado = $OBJ_USUARIO->getLogin($name_user);

  if ($Resultado["error"] == "NO") {

    $result = $Resultado["data"];

    if ($result[0]["pass_user"] != $pass_user) {
      throw new Exception("Contraseña Incorrecta");
    }

    if ($result[0]["estado"] == "0") {
      throw new Exception("Su cuenta se encuentra deshabilitada.");
    }

    if ($result[0]["estado_grupo"] == "0") {
      throw new Exception("El grupo al que pertenece esta deshabilitado.");
    }
  } else {

    throw new Exception($Resultado["message"]);
  }

  if (!empty($recordar)) {
    setcookie("flag_save", true, time() + (60 * 60 * 24 * 365));
    setcookie("name_user", $name_user, time() + (60 * 60 * 24 * 365));
    setcookie("pass_user", $_POST['login-password'], time() + (60 * 60 * 24 * 365));
  } else {
    setcookie("flag_save", false, time() + (60 * 60 * 24 * 365));
    setcookie("name_user", null, time() + (60 * 60 * 24 * 365));
    setcookie("pass_user", null, time() + (60 * 60 * 24 * 365));
  }

  $Resultado1 = $OBJ_USUARIO->getImageProfile($result[0]["id_trabajador"]);
  $srcImg = "resources/global/images/default-profile.png";
  if ($Resultado1['error'] == "NO") {
    $srcImg = $Resultado1['data'];
  }

  $id_trabajador = $result[0]["id_trabajador"];
  require_once "core/models/ClassAccesoSucursal.php";
  $flag_permiso = $OBJ_ACCESO_SUCURSAL->verificarPermiso($id_trabajador, $id_sucursal);
  if ($flag_permiso == false) {
    throw new Exception("No tienes permiso para acceder a esta sucursal.");
  }

  require_once "core/models/ClassSucursal.php";
  $ResultadoSucursal = $OBJ_SUCURSAL->getSucursalForId($id_sucursal);
  if ($ResultadoSucursal["error"] == "SI") {
    throw new Exception($ResultadoSucursal["message"]);
  }

  $resultSucursal = $ResultadoSucursal["data"];

  $_SESSION['id_persona'] = $result[0]["id_persona"];
  $_SESSION['id_trabajador'] = $result[0]["id_trabajador"];
  $_SESSION['id_grupo'] = $result[0]["id_grupo"];
  $_SESSION['id_especialidad'] = $result[0]["id_especialidad"];
  $_SESSION['name_user'] = $result[0]["name_user"];
  $_SESSION['nombres'] = $result[0]["nombres"];
  $_SESSION['apellidos'] = $result[0]["apellidos"];
  $_SESSION['name_grupo'] = $result[0]["name_grupo"];
  $_SESSION['name_especialidad'] = $result[0]["name_especialidad"];
  $_SESSION['src_image'] = $srcImg;
  $_SESSION["id_sucursal"] = $resultSucursal[0]["id_sucursal"];
  $_SESSION["id_empresa"] = $resultSucursal[0]["id_empresa"];
  $_SESSION["nombre_sucursal"] = $resultSucursal[0]["nombre"];

  $data["error"] = "NO";
  $data["message"] = "Acceso Correcto.";
  $data["data"] = null;
  echo json_encode($data);
  exit();
} catch (\Exception $e) {

  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
}
