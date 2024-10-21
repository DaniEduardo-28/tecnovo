<?php

  try {

    $id_ingreso_gasto = isset($_POST["id_ingreso_gasto"])	? $_POST["id_ingreso_gasto"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingresogasto"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_ver']==false) {
        throw new Exception("No tienes permisos para ver este registro.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    if ($id_ingreso_gasto=="") {
      throw new Exception("No se recibió el parámetro id ingreso.");
    }

    require_once "core/models/ClassIngresoGasto.php";
    $Resultado = $OBJ_INGRESO_GASTO->getDataVerIngreso($id_ingreso_gasto);

    if ($Resultado["error"]=="NO") {

      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "id_ingreso_gasto" => $key['id_ingreso_gasto'],
          "id_orden_gasto" => $key['id_orden_gasto'],
          "id_tipo_docu" => $key['id_tipo_docu'],
          "num_documento" => $key['num_documento'],
          "name_proveedor" => $key['nombre_proveedor'],
          "src_imagen_proveedor" => $key['src_imagen_proveedor'],
          "fecha_gasto" => date('d/m/Y h:i a', strtotime($key['gasto'])),
          "observaciones" => $key['observaciones'],
          "observaciones_detalle" => $key['observaciones_detalle'],
          "cod_gasto" => $key['cod_gasto'],
          "name_tabla" => $key['name_tabla'],
          "name_gasto" => $key['name_gasto'],
          "cantidad" => $key['cantidad'],
          "src_imagen_gasto" => $key['src_imagen_gasto']
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
