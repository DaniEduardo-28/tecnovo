<?php

  $id_tipo_mascota = (isset($_POST['id_tipo_mascota'])) ? $_POST['id_tipo_mascota'] : "all";

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vacuna"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para consultar datos.");
      }
    }else {
      throw new Exception("Error al obtener los permisos de acceso.");
    }

    require_once "core/models/ClassVacuna.php";
    $Resultado = $OBJ_VACUNA->show($id_tipo_mascota,"all");

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
        $estado = ($key['estado']=="activo") ? '<label class="badge badge-success">Activo</label>' : '<label class="badge badge-danger">Inactivo</label>' ;
        $retorno_array[] =array(
          "num" => "$count",
          "id_vacuna" => $key['id_vacuna'],
          "name_vacuna" => $key['name_vacuna'],
          "descripcion" => $key['descripcion'],
          "edad_maxima" => $key['edad_maxima'],
          "edad_minima" => $key['edad_minima'],
          "id_tipo_mascota" => $key['id_tipo_mascota'],
          "name_tipo" => $key['name_tipo'],
          "tipo_vacuna" => $key['tipo'],
          "estado" => $estado,
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
