<?php

  try {

    $id_gasto = isset($_POST["id_gasto"])	? $_POST["id_gasto"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("gasto"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_gasto=="") {
      throw new Exception("No se recibió el parámetro id gasto.");
    }

    require_once "core/models/ClassGasto.php";
    $Resultado = $OBJ_GASTO->getDataEditGasto($id_gasto);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_gasto" => $key['id_gasto'],
          "id_tipo_gasto" => $key['id_tipo_gasto'],
          "name_gasto" => $key['name_gasto'],
          "descripcion_gasto" => $key['descripcion_gasto'],
          "descripcion" => $key['descripcion'],
          "precio" => $key['precio'],
          "id_moneda" => $key['id_moneda'],
          "estado" => $key['estado'],
          "flag_igv" => $key['flag_igv']
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
