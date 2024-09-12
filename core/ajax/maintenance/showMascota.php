<?php

  try {

    $id_tipo_mascota = isset($_POST["id_tipo_mascota"])	? $_POST["id_tipo_mascota"]	: "";
    $id_documento = isset($_POST["id_documento"])	? $_POST["id_documento"]	: "";
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("mascota"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassMascota.php";
    $Resultado = $OBJ_MASCOTA->show($id_tipo_mascota,$id_documento,$valor);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $count = 1;

    foreach ($Resultado["data"] as $key) {
      $estado = ($key['estado']=="activo") ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>' : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>' ;
      $flag_editar='';
      $flag_eliminar='';
      if ($access_options[0]['flag_editar']) {
        $flag_editar = '<a href="javascript:getDataEdit(' . $key['id_mascota'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
      }
      if ($access_options[0]['flag_eliminar']) {
        $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_mascota'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['nombre'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
      }
      $retorno_array[] =array(
        "num" => "$count",
        "id_mascota" => $key['id_mascota'],
        "cliente" => $key['nombres'] . ' ' . $key['apellidos'],
        "name_tipo" => $key['name_tipo'],
        "nombre" => $key['nombre'],
        "raza" => $key['raza'],
        "color" => $key['color'],
        "peso" => $key['peso'],
        "fecha_nacimiento" => date('d/m/Y', strtotime($key['fecha_nacimiento'])),
        "estado" => $estado,
        "options" => $flag_editar . ' ' . $flag_eliminar
      );
      $count++;
    }

    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["data"] = $retorno_array;
    echo json_encode($data);

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
