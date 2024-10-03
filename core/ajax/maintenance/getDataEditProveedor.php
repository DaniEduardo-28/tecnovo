<?php

  try {

    $id_proveedor = isset($_POST["id_proveedor"])	? $_POST["id_proveedor"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("proveedor"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_proveedor=="") {
      throw new Exception("No se recibió el parámetro id proveedor.");
    }

    require_once "core/models/ClassProveedor.php";
    $Resultado = $OBJ_PROVEEDOR->getDataEditProveedor($id_proveedor);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_persona" => $key['id_persona'],
          "id_documento" => $key['id_documento'],
          "num_documento" => $key['num_documento'],
          "nombres" => $key['nombres'],
          "apellidos" => $key['apellidos'],
          "direccion" => $key['direccion'],
          "telefono" => $key['telefono'],
          "correo" => $key['correo'],
          "src_imagen" => $key['src_imagen'],
          "id_proveedor" => $key['id_proveedor'],
          "estado" => $key['estado']
        );
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["data"] = $retorno_array;
      echo json_encode($data);

    }else {
      throw new Exception($Resultado["message"]);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
