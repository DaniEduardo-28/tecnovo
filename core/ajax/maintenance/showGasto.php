<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_tipo_gasto = isset($_POST["id_tipo_gasto"])	? $_POST["id_tipo_gasto"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("gasto"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassGasto.php";
    $DataCantidades = $OBJ_GASTO->getCount("all",$id_tipo_gasto,$valor);

    if ($DataCantidades["error"]=="NO") {

      $cantidades = $DataCantidades["data"][0]["cantidades"];
      $Resultado = $OBJ_GASTO->show("all",$id_tipo_gasto,$valor,$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="activo") ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>' : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>' ;
        $flag_editar='';
        $flag_eliminar='';
        if ($access_options[0]['flag_editar']) {
          $flag_editar = '<a href="javascript:getDataEdit(' . $key['id_gasto'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_gasto'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['name_gasto'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id_gasto" => $key['id_gasto'],
          "name_gasto" => $key['name_gasto'],
          "descripcion_gasto" => $key['descripcion_gasto'],
          "descripcion" => $key['descripcion'],
          "precio_unit" => $key['precio_unit'],
          "cantidad" => $key['cantidad'],
          "signo_moneda" => $key['signo_moneda'],
          "estado" => $estado,
          "flag_editar" => "$flag_editar",
          "flag_eliminar" => "$flag_eliminar"
        );
        $count++;
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["cantidades"] = $cantidades;
      $data["data"] = $retorno_array;
      echo json_encode($data);

    }else {
      throw new Exception($DataCantidades["message"]);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
