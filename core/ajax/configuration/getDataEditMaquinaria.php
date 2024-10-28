<?php

  try {

    $id_maquinaria = isset($_POST["id_maquinaria"])	? $_POST["id_maquinaria"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("maquinaria"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_maquinaria=="") {
      throw new Exception("No se recibió el parámetro id maquinaria.");
    }

    require_once "core/models/ClassMaquinaria.php";
    $Resultado = $OBJ_MAQUINARIA->getDataEditMaquinaria($id_maquinaria);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_maquinaria" => $key['id_maquinaria'],
          "descripcion" => $key['descripcion'],
          "observaciones" => $key['observaciones'],
          "estado" => $key['estado'],
          "id_operador" => $key['id_operador'],
          "nombre_proveedor" => $key['nombre_proveedor']
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
