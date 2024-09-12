<?php

  $fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : date('Y-m-d') ;
  $fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : date('Y-m-d') ;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipocambio"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para consultar datos.");
      }
    }else {
      throw new Exception("Error al obtener los permisos de acceso.");
    }

    require_once "core/models/ClassTipoCambio.php";
    $Resultado = $OBJ_TIPO_CAMBIO->show($fecha_inicio,$fecha_fin);

    if ($Resultado["error"]=="NO") {

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "num" => "$count",
          "id_moneda" => $key['id_moneda'],
          "name_moneda" => $key['name_moneda'],
          "name_user" => $key['name_user'],
          "fecha" => date('d/m/Y H:i', strtotime($key['fecha'])),
          "tipo_cambio" => $key['tipo_cambio']
        );
        $count++;
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["data"] = $retorno_array;
      echo json_encode($data);
      exit();

    }else {

      $data["error"] = "SI";
      $data["message"] = $Resultado["message"];
      $data["data"] = null;
      echo json_encode($data);

    }

  } catch (\Exception $e) {

    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);

  }

 ?>
