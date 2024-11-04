<?php

  try {

    $id_orden_compra = isset($_POST["id_orden_gasto"])	? $_POST["id_orden_gasto"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordengasto"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_editar']==false) {
        throw new Exception("No tienes permisos para editar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_orden_gasto=="") {
      throw new Exception("No se recibió el parámetro id orden gasto.");
    }

    require_once "core/models/ClassOrdenGasto.php";
    $Resultado = $OBJ_ORDEN_GASTO->getDataEditOrdenGasto($id_orden_gasto);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_orden_compra" => $key['id_orden_compra'],
          "id_proveedor" => $key['id_proveedor'],
          "name_proveedor" => $key['nombre_proveedor'],
          "src_imagen_proveedor" => $key['src_imagen_proveedor'],
          "fecha_gasto" => date('Y-m-d', strtotime($key['fecha_gasto'])),
          "cod_producto" => $key['cod_producto'],
          "name_producto" => $key['name_producto'],
          "cantidad" => $key['cantidad'],
          "name_tabla" => $key['name_tabla'],
          "descuento" => $key['descuento'],
          "sub_total" => $key['sub_total'],
          "igv" => $key['igv'],
          "total" => $key['total']
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
