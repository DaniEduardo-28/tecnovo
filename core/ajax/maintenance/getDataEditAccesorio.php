<?php

  try {

    $id_accesorio = isset($_POST["id_accesorio"])	? $_POST["id_accesorio"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesorio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_accesorio=="") {
      throw new Exception("No se recibió el parámetro id accesorio.");
    }

    require_once "core/models/ClassAccesorio.php";
    $Resultado = $OBJ_ACCESORIO->getDataEditAccesorio($id_accesorio);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_accesorio" => $key['id_accesorio'],
          "id_categoria" => $key['id_categoria'],
          "name_accesorio" => $key['name_accesorio'],
          "descripcion" => $key['descripcion'],
          "stock" => $key['stock'],
          "name_categoria" => $key['name_categoria'],
          "stock_minimo" => $key['stock_minimo'],
          "precio_compra" => $key['precio_compra'],
          "precio_venta" => $key['precio_venta'],
          "estado" => $key['estado'],
          "id_sucursal" => $key['id_sucursal'],
          "id_moneda" => $key['id_moneda'],
          "id_unidad_medida" => $key['id_unidad_medida'],
          "signo_moneda" => $key['signo_moneda'],
          "flag_igv" => $key['flag_igv'],
          "flag_consumo" => $key['flag_consumo'],
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
