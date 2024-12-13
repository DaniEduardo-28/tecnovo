<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("proveedor"));

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
        $options="&nbsp;&nbsp;&nbsp;";
        if ($access_options[0]['flag_editar']) {
          $options.='<a href="javascript:getDataEdit(' . $key['id_proveedor'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $options.='&nbsp;&nbsp;<a href="javascript:deleteRegistro(' . $key['id_proveedor'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['apellidos'])) . ", " . str_replace('"',' ',str_replace("'",' ',$key['nombres'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-close"></i></a>';
        }

        $btnseleccionar = '&nbsp;&nbsp;<a href="javascript:seleccionarProveedor(' . $key['id_proveedor'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['apellidos'])) . ", " . str_replace('"',' ',str_replace("'",' ',$key['nombres'])) . "','" . $key['src_imagen'] . "'" . ')" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-check"></i></a>';

        $retorno_array[] =array(
          "num" => "$count",
          "id_persona" => $key['id_persona'],
          "id_documento" => $key['id_documento'],
          "name_documento" => $key['name_documento'],
          "num_documento" => $key['num_documento'],
          "nombres" => strtoupper($key['nombres']),
          "apellidos" => strtoupper($key['apellidos']),
          "apodo" => strtoupper($key['apodo']),
          "direccion" => strtoupper(substr($key['direccion'],0,30)),
          "direccion_completa" => strtoupper($key['direccion']),
          "telefono" => $key['telefono'],
          "correo" => strtoupper(substr($key['correo'],0,25)),
          "src_imagen" => $key['src_imagen'],
          "id_proveedor" => $key['id_proveedor'],
          "estado" => $estado,
          "options" => "$options",
          "btnseleccionar" => "$btnseleccionar"
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
