<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("observacionesproveedor"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassProveedor.php";
    $DataCantidad = $OBJ_PROVEEDOR->getCount("all",$id_documento,$valor);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_PROVEEDOR->show("all",$id_documento,$valor,$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="1") ? '<span class="badge badge-success-inverse px-2 py-1 mt-1">Activo</span>' : '<span class="badge badge-danger-inverse px-2 py-1 mt-1">Inactivo</span>' ;
        $options="";
        if ($access_options[0]['flag_agregar']) {
          $options.='<a href="javascript:addObservacion(' . $key['id_proveedor'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['apellidos'])) . ", " . str_replace('"',' ',str_replace("'",' ',$key['nombres'])) . "'" . ')" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0 "><i class="fa fa-plus"></i></a>';
        }
        if ($access_options[0]['flag_ver']) {
          $options.='&nbsp;&nbsp;<a href="javascript:verObservaciones(' . $key['id_proveedor'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['apellidos'])) . ", " . str_replace('"',' ',str_replace("'",' ',$key['nombres'])) . "'" . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0 "><i class="fa fa-eye"></i></a>';
        }

        $retorno_array[] =array(
          "num" => "$count",
          "id_persona" => $key['id_persona'],
          "id_documento" => $key['id_documento'],
          "name_documento" => $key['name_documento'],
          "num_documento" => $key['num_documento'],
          "nombres" => $key['nombres'],
          "apellidos" => strtoupper($key['apellidos']) . ",<br>",
          "direccion" => strtoupper($key['direccion']),
          "telefono" => $key['telefono'],
          "correo" => strtoupper($key['correo']),
          "src_imagen" => $key['src_imagen'],
          "id_proveedor" => $key['id_proveedor'],
          "estado" => $estado,
          "options" => "$options"
        );
        $count++;
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["cantidad"] = $cantidad;
      $data["data"] = $retorno_array;
      echo json_encode($data);

    }else {
      throw new Exception($DataCantidad["message"]);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
