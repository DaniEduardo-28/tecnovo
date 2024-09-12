<?php

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("monedas"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para consultar datos.");
      }
    }else {
      throw new Exception("Error al obtener los permisos de acceso.");
    }

    require_once "core/models/ClassMoneda.php";
    $Resultado = $OBJ_MONEDA->show("all");

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
        $flag_principal = ($key['flag_principal']=="1") ? 'SI' : 'NO' ;
        $retorno_array[] =array(
          "num" => "$count",
          "id_moneda" => $key['id_moneda'],
          "name_moneda" => $key['name_moneda'],
          "cod_sunat" => $key['cod_sunat'],
          "signo" => $key['signo'],
          "abreviatura" => $key['abreviatura'],
          "tipo_cambio" => $key['tipo_cambio'],
          "estado" => $estado,
          "flag_principal" => $flag_principal,
          "options" => "$options"
        );
        $count++;
      }
      $data["error"] = "NO";
      $data["message"] = "Success";
      $data["data"] = $retorno_array;
      echo json_encode($data);
      exit();

    }else {

      $data["error"] = "SI";
      $data["message"] = $Resultado["message"];
      $data["data"] = null;
      echo json_encode($data);
      exit();

    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
