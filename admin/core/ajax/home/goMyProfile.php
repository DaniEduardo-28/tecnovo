<?php

  $txtAddress = isset($_POST["txtAddress"]) ? $_POST["txtAddress"] : "";
  $txtDateNac = isset($_POST["txtDateNac"]) ? $_POST["txtDateNac"] : "";
  $txtEmail = isset($_POST["txtEmail"]) ? $_POST["txtEmail"] : "";
  $txtPhone = isset($_POST["txtPhone"]) ? $_POST["txtPhone"] : "";
  $id_persona = $_SESSION['id_persona'];
  $txtDateNac = formattodate($txtDateNac,"d/m/Y","Y-m-d");

  try {

    if ($txtEmail!="") {
      if (validar_email($txtEmail)==false) {
        throw new Exception("Formato de correo no válido.");
      }
    }

    if ($txtPhone!="") {
      if (validar_number($txtPhone)==false) {
        throw new Exception("Formato de teléfono no válido.");
      }
    }

    require_once "core/models/ClassUsuario.php";
    $VD = $OBJ_USUARIO->updateProfile($id_persona,$txtAddress,$txtDateNac,$txtEmail,$txtPhone);

    if ($VD=="OK") {

      $data["error"]="NO";
      $data["message"]="Datos actualizados correctamente.";
      $data["data"] = null;
      echo json_encode($data);
      exit();

    }else {

      $data["error"]="SI";
      $data["message"]=$VD;
      $data["data"] = null;
      echo json_encode($data);
      exit();

    }

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();

  }

 ?>
