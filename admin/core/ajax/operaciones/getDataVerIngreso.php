<?php

  try {

    $id_ingreso = isset($_POST["id_ingreso"])	? $_POST["id_ingreso"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permisos para ver este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_ingreso=="") {
      throw new Exception("No se recibió el parámetro id ingreso.");
    }

    require_once "core/models/ClassIngreso.php";
    $Resultado = $OBJ_INGRESO->getDataVerIngreso($id_ingreso);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_ingreso" => $key['id_ingreso'],
          "id_orden_compra" => $key['id_orden_compra'],
          "id_tipo_docu" => $key['id_tipo_docu'],
          "num_documento" => $key['num_documento'],
          "name_proveedor" => $key['nombre_proveedor'],
          "src_imagen_proveedor" => $key['src_imagen_proveedor'],
          "fecha_orden" => date('d/m/Y h:i a', strtotime($key['fecha'])),
          "name_metodo" => $key['name_metodo'],
          "observaciones" => $key['observaciones'],
          "observaciones_detalle" => $key['observaciones_detalle'],
          "estado" => $key['estado'],
          "cod_producto" => $key['cod_producto'],
          "name_tabla" => $key['name_tabla'],
          "name_producto" => $key['name_producto'],
          "cantidad" => $key['cantidad'],
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
