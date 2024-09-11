<?php

  $txtAddress = isset($_POST["txtAddress"]) ? $_POST["txtAddress"] : "";
  $txtDateNac = isset($_POST["txtDateNac"]) ? $_POST["txtDateNac"] : date('Y-m-d');
  $txtPhone = isset($_POST["txtPhone"]) ? $_POST["txtPhone"] : "";
  $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "";
  $id_persona = $_SESSION['id_persona_cliente'];
  $txtDateNac = formattodate($txtDateNac,"d/m/Y","Y-m-d");

  try {

    if (!isset($_SESSION['id_cliente'])) {
      throw new Exception("Para realizar esta operación tiene que iniciar sesión.");
    }

    if ($sexo=="") {
      throw new Exception("Seleccione su sexo.");
    }

    if ($txtPhone!="") {
      if (validar_number($txtPhone)==false) {
        throw new Exception("Formato de teléfono no válido.");
      }
    }

    require_once "admin/core/models/ClassUsuario.php";
    $VD = $OBJ_USUARIO->updateProfileCliente($id_persona,$txtAddress,$txtDateNac,$sexo,$txtPhone);

    if ($VD=="OK") {

      $data["error"]="NO";
      $data["message"]="Datos actualizados correctamente.";
      $data["data"] = null;
      echo json_encode($data);
      exit();

    }else {
      throw new Exception($VD);
    }

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();

  }

 ?>
