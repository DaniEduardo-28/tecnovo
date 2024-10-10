<?php

  try {

    $id_orden_gasto = isset($_POST["id_orden_gasto"])	? $_POST["id_orden_gasto"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para seleccionar este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_orden_gasto=="") {
      throw new Exception("No se recibió el parámetro id orden.");
    }

    require_once "core/models/ClassOrdenGasto.php";
    $Resultado = $OBJ_ORDEN_GASTO->getDataEditOrdenGastoIngreso($id_orden_gasto);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_orden_gasto" => $key['id_orden_gasto'],
          "id_proveedor" => $key['id_proveedor'],
          "name_proveedor" => $key['nombre_proveedor'],
          "src_imagen_proveedor" => $key['src_imagen_proveedor'],
          "id_gasto" => $key['id_gasto'],
          "fecha_gasto" => date('d/m/Y h:i a', strtotime($key['fecha_gasto'])),
          "estado" => $key['estado'],
          "cod_producto" => $key['cod_producto'],
          "name_tabla" => $key['name_tabla'],
          "name_producto" => $key['name_producto'],
          "name_metodo" => $key['name_metodo'],
          "cantidad_ingresada" => $key['cantidad_ingresada'],
          "cantidad_solicitada" => $key['cantidad_solicitada'],
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
