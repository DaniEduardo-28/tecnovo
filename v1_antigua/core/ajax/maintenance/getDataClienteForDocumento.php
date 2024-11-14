<?php

  try {

    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: "";
    $num_documento = isset($_POST["num_documento"])	? $_POST["num_documento"]	: "";

    if ($id_documento=="") {
      throw new Exception("No se recibió el parámetro id documento.");
    }

    require_once "core/models/ClassCliente.php";
    $Resultado = $OBJ_CLIENTE->getDataClienteForDocumento($id_documento,$num_documento);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "nombres" => $key['nombres'],
          "apellidos" => $key['apellidos'],
          "nickname" => $key['nickname'],
          "direccion" => $key['direccion'],
          "telefono" => $key['telefono'],
          "correo" => $key['correo'],
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
