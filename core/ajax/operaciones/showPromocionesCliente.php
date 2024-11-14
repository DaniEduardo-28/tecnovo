<?php

  $id_cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : 0;

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("promocion"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permisos para ver esta información.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassCliente.php";
    $Resultado = $OBJ_CLIENTE->showPromocionesCliente($id_cliente);

    if ($Resultado["error"]=="NO") {
      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $options="";
        if ($access_options[0]['flag_eliminar']) {
          $options.='<a href="javascript:eliminarPromocion(' . $key['id_promocion'] . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id_promocion" => $key['id_promocion'],
          "id_cliente" => $key['id_cliente'],
          "titulo" => $key['titulo'],
          "descripcion" => $key['descripcion'],
          "precio" => $key['precio'],
          "fecha_inicio" => date('d/m/Y', strtotime($key['fecha_inicio'])),
          "fecha_fin" => date('d/m/Y', strtotime($key['fecha_fin'])),
          "options" => "$options"
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
