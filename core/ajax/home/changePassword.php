<?php

  $txtPassOld = isset($_POST["txtPassOld"]) ? encript($_POST["txtPassOld"]) : "";
  $txtNewPass = isset($_POST["txtNewPass"]) ? encript($_POST["txtNewPass"]) : "";
  $txtNewPass1 = isset($_POST["txtNewPass1"]) ? encript($_POST["txtNewPass1"]) : "";
  $id_trabajador = $_SESSION['id_trabajador'];

  $contador = 0;
  //validamos campos obligatorios
  if (empty($txtPassOld)) {
      $contador++;
  }
  if (empty($txtNewPass)) {
      $contador++;
  }
  if (empty($txtNewPass1)) {
      $contador++;
  }

  try {

    if ($contador != 0) {
      throw new Exception("Faltan llenar campos obligatorios.");
    }

    if ($txtNewPass!=$txtNewPass1) {
      throw new Exception("Las contraseñas no coinciden.");
    }

    require_once "core/models/ClassUsuario.php";
    $VD = $OBJ_USUARIO->UpdatePassword($id_trabajador,$txtPassOld,$txtNewPass);

    if ($VD!="OK") {
      throw new Exception($VD);
    }

    $data["error"]="NO";
    $data["message"]="Operación realizada correctamente.";
    $data["data"] = null;
    echo json_encode($data);
    exit();

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();

  }

 ?>
