<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: "";
    $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : "todos"; // Nuevo parámetro

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("cliente"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassCliente.php";
    $DataCantidad = $OBJ_CLIENTE->getCount("all",$id_documento,$valor, $tipo_busqueda);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_CLIENTE->show("all",$id_documento,$valor,$tipo_busqueda,$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="activo") ? '<span class="badge badge-success-inverse px-2 py-1 mt-1">Activo</span>' : '<span class="badge badge-danger-inverse px-2 py-1 mt-1">Inactivo</span>' ;
        $options="&nbsp;&nbsp;&nbsp;";
        if ($access_options[0]['flag_editar']) {
          $options.='<a href="javascript:getDataEdit(' . $key['id_cliente'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $options.='&nbsp;&nbsp;<a href="javascript:deleteRegistro(' . $key['id_cliente'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['apellidos'])) . ", " . str_replace('"',' ',str_replace("'",' ',$key['nombres'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-close"></i></a>';
        }
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
          "telefono" => $key['telefono'],
          "correo" => strtoupper(substr($key['correo'],0,25)),
          "fecha_nacimiento" => $key['fecha_nacimiento'],
          "sexo" => $key['sexo'],
          "src_imagen" => $key['src_imagen'],
          "id_cliente" => $key['id_cliente'],
          "name_user" => $key['name_user'],
          "pass_user" => $key['pass_user'],
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
