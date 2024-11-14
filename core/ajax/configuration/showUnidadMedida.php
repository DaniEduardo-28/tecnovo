<?php

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("unidadmedida"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassUnidadMedida.php";
    $Resultado = $OBJ_UNIDAD_MEDIDA->show("all");

    if ($Resultado["error"]=="NO") {

      $options="";
      if ($access_options[0]['flag_editar']) {
        $options.='<a href="javascript:void(0)" id="btnEdit" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0"><i class="ti ti-pencil"></i></a>';
      }
      if ($access_options[0]['flag_eliminar']) {
        $options.='<a href="javascript:void(0)" id="btnDelete" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
      }

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="1") ? '<label class="badge badge-success">Activo</label>' : '<label class="badge badge-danger">Inactivo</label>' ;
        $retorno_array[] =array(
          "num" => "$count",
          "id_unidad_medida" => $key['id_unidad_medida'],
          "name_unidad" => $key['name_unidad'],
          "cod_sunat" => $key['cod_sunat'],
          "estado" => $estado,
          "options" => "$options"
        );
        $count++;
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
