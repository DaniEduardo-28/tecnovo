<?php

  $id_cliente = isset($_POST['id_cliente']) ? intval($_POST['id_cliente']) : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesofundo"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    // Verificar si id_cliente es válido (mayor a 0)
    if ($id_cliente <= 0) {
      throw new Exception("ID Cliente inválido.");
    }

    require_once "core/models/ClassAccesoFundo.php";
    $Resultado = $OBJ_ACCESO_FUNDO->getPermisosFundo($id_cliente);

    if ($Resultado["error"]=="NO") {
      $retorno_array = [];
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =[
          "id_fundo" => $key['id_fundo'],
          "nombre_fundo" => $key['nombre_fundo'],
          "cantidad_hc" => $key['cantidad_hc'],
          ];
      }
      $data = [
        "error" => "NO",
        "message" => "Success",
        "data" => $retorno_array
              ];
      echo json_encode($data);

    }else {
      throw new Exception($Resultado["message"]);
    }

  } catch (\Exception $e) {
    $data = [
      "error" => "SI",
      "message" => $e->getMessage(),
      "data" => null
        ];
    echo json_encode($data);
    exit();
  }

 ?>
