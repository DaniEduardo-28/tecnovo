<?php

  try {

    $id_medicamento = isset($_POST["id_medicamento"])	? $_POST["id_medicamento"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("medicamento"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_medicamento=="") {
      throw new Exception("No se recibió el parámetro id medicamento.");
    }

    require_once "core/models/ClassMedicamento.php";
    $Resultado = $OBJ_MEDICAMENTO->getDataEditMedicamento($id_medicamento);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_medicamento" => $key['id_medicamento'],
          "id_tipo_medicamento" => $key['id_tipo_medicamento'],
          "name_medicamento" => $key['name_medicamento'],
          "descripcion" => $key['descripcion'],
          "stock" => $key['stock'],
          "name_tipo" => $key['name_tipo'],
          "stock_minimo" => $key['stock_minimo'],
          "precio_compra" => $key['precio_compra'],
          "precio_venta" => $key['precio_venta'],
          "estado" => $key['estado'],
          "id_fundo" => $key['id_fundo'],
          "id_moneda" => $key['id_moneda'],
          "id_unidad_medida" => $key['id_unidad_medida'],
          "flag_igv" => $key['flag_igv'],
          "src_imagen" => $key['src_imagen']
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
