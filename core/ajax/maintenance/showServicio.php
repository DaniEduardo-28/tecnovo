<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_tipo_servicio = isset($_POST["id_tipo_servicio"])	? $_POST["id_tipo_servicio"]	: "";
    $id_maquinaria = isset($_POST["id_maquinaria"])	? $_POST["id_maquinaria"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("servicio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassServicio.php";
    $DataCantidad = $OBJ_SERVICIO->getCount("all",$id_tipo_servicio,$id_maquinaria,$valor);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_SERVICIO->show("all",$id_tipo_servicio,$id_maquinaria,$valor,$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="activo") ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>' : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>' ;
        $flag_editar='';
        $flag_eliminar='';
        if ($access_options[0]['flag_editar']) {
          $flag_editar = '<a href="javascript:getDataEdit(' . $key['id_servicio'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_servicio'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['name_servicio'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id_servicio" => $key['id_servicio'],
          "name_servicio" => $key['name_servicio'],
          "descripcion_breve" => $key['descripcion_breve'],
          "descripcion_larga" => $key['descripcion_larga'],
          "name_tipo" => $key['name_tipo'],
          "descripcion" => $key['maquinaria_descripcion'],
          "precio" => $key['precio'],
          "signo_moneda" => $key['signo_moneda'],
          "src_imagen" => $key['src_imagen'],
          "estado" => $estado,
          "flag_editar" => "$flag_editar",
          "flag_eliminar" => "$flag_eliminar"
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
