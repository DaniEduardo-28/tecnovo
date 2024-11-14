<?php

  $txtPassOld = isset($_POST["txtPassOld"]) ? encript($_POST["txtPassOld"]) : "";
  $txtNewPass = isset($_POST["txtNewPass"]) ? encript($_POST["txtNewPass"]) : "";
  $txtNewPass1 = isset($_POST["txtNewPass1"]) ? encript($_POST["txtNewPass1"]) : "";
  $id_cliente = $_SESSION['id_cliente'];

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

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }
    
    if ($contador != 0) {
      throw new Exception("Faltan llenar campos obligatorios.");
    }

    if ($txtNewPass!=$txtNewPass1) {
      throw new Exception("Las contraseñas no coinciden.");
    }

    require_once "admin/core/models/ClassUsuario.php";
    $VD = $OBJ_USUARIO->UpdatePasswordCliente($id_cliente,$txtPassOld,$txtNewPass);

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
