<?php

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesogrupo"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    $id_modulo = isset($_POST["id_modulo"]) ? $_POST["id_modulo"] : "";
    $id_grupo = isset($_POST["id_grupo"]) ? $_POST["id_grupo"] : "";

    if ($id_modulo=="") {
      throw new Exception("No se recibió el parámetro id módulo.");
    }

    if ($id_grupo=="") {
      throw new Exception("No se recibió el parámetro id grupo.");
    }

    $Resultado = $OBJ_ACCESO_OPCION->getOpcionesSistema($id_modulo,$id_grupo);

    if ($Resultado["error"]=="NO") {
      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "num" => "$count",
          "id_opcion" => $key['id_opcion'],
          "name_opcion" => $key['name_opcion'],
          "flag_ver" => $key['flag_ver'],
          "flag_editar" => $key['flag_editar'],
          "flag_anular" => $key['flag_anular'],
          "flag_buscar" => $key['flag_buscar'],
          "flag_agregar" => $key['flag_agregar'],
          "flag_eliminar" => $key['flag_eliminar'],
          "flag_descargar" => $key['flag_descargar']
        );
        $count++;
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
