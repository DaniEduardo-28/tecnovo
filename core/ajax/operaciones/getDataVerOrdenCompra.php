<?php

  try {

    $id_orden_compra = isset($_POST["id_orden_compra"])	? $_POST["id_orden_compra"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordencompra"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permisos para ver este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_orden_compra=="") {
      throw new Exception("No se recibió el parámetro id orden compra.");
    }

    require_once "core/models/ClassOrdenCompra.php";
    $Resultado = $OBJ_ORDEN_COMPRA->getDataVerOrdenCompra($id_orden_compra);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_orden_compra" => $key['id_orden_compra'],
          "id_proveedor" => $key['id_proveedor'],
          "name_proveedor" => $key['nombre_proveedor'],
          "src_imagen_proveedor" => $key['src_imagen_proveedor'],
          "id_metodo_envio" => $key['id_metodo_envio'],
          "fecha_orden" => date('Y-m-d', strtotime($key['fecha_orden'])),
          "fecha_entrega" => date('Y-m-d', strtotime($key['fecha_entrega'])),
          "observaciones" => $key['observaciones'],
          "estado" => $key['estado'],
          "cod_producto" => $key['cod_producto'],
          "id_moneda" => $key['id_moneda'],
          "name_producto" => $key['name_producto'],
          "name_tabla" => $key['name_tabla'],
          "stock" => $key['stock'],
          "precio_unitario" => $key['precio_unitario'],
          "cantidad_solicitada" => $key['cantidad_solicitada'],
          "notas" => $key['notas'],
          "total" => $key['total'],
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
