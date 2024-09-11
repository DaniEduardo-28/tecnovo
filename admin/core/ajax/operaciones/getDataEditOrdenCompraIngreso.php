<?php

  try {

    $id_orden_compra = isset($_POST["id_orden_compra"])	? $_POST["id_orden_compra"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para seleccionar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_orden_compra=="") {
      throw new Exception("No se recibió el parámetro id orden compra.");
    }

    require_once "core/models/ClassOrdenCompra.php";
    $Resultado = $OBJ_ORDEN_COMPRA->getDataEditOrdenCompraIngreso($id_orden_compra);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_orden_compra" => $key['id_orden_compra'],
          "id_proveedor" => $key['id_proveedor'],
          "name_proveedor" => $key['nombre_proveedor'],
          "src_imagen_proveedor" => $key['src_imagen_proveedor'],
          "id_metodo_envio" => $key['id_metodo_envio'],
          "fecha_orden" => date('d/m/Y h:i a', strtotime($key['fecha_orden'])),
          "estado" => $key['estado'],
          "cod_producto" => $key['cod_producto'],
          "name_tabla" => $key['name_tabla'],
          "name_producto" => $key['name_producto'],
          "name_metodo" => $key['name_metodo'],
          "cantidad_ingresada" => $key['cantidad_ingresada'],
          "cantidad_solicitada" => $key['cantidad_solicitada'],
          "src_imagen_producto" => $key['src_imagen_producto']
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
