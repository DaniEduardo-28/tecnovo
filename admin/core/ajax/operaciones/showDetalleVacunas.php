<?php

  try {

    $id_mascota = isset($_POST["id_mascota"])	? $_POST["id_mascota"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("fichamascota"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassMascotaVacuna.php";
    $Resultado = $OBJ_MASCOTA_VACUNA->showDetalleVacunas($id_mascota);

    if ($Resultado["error"]=="SI") {
      throw new Exception($Resultado["message"]);
    }

    $count = 1;

    foreach ($Resultado["data"] as $key) {
      $flag_ver = '';
      $fecha_aplicacion = date('d/m/Y H:i', strtotime($key['fecha_aplicacion']));
      $flag_vacuna = $key['flag_vacuna'];
      $observaciones = $key['observaciones'];
      if ($flag_vacuna=="0") {
        if ($access_options[0]['flag_editar']) {
          $flag_ver = '<button id="btnVacunar" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-check"></i></button>';
        }
        $flag_vacuna = '<label class="badge badge-warning">NO VACUNADO</label>';
        $fecha_aplicacion = '';
        $observaciones = '<input type="text" class="form-control" style="width:250px;" value="' . $observaciones . '"/>';
        if (strtotime($key['fecha_maxima'])<strtotime(date('Y-m-d H:i'))) {
          $flag_vacuna = '<label class="badge badge-danger">VACUNA VENCIDA</label>';
        }
      }else {
        $flag_vacuna = '<label class="badge badge-success">VACUNADO</label>';
      }
      $retorno_array[] =array(
        "num" => "$count",
        "id_mascota_vacuna" => $key['id_mascota_vacuna'],
        "id_vacuna" => $key['id_vacuna'],
        "name_vacuna" => $key['name_vacuna'],
        "fecha_minima" => date('d/m/Y', strtotime($key['fecha_minima'])),
        "fecha_maxima" => date('d/m/Y', strtotime($key['fecha_maxima'])),
        "observaciones" => $observaciones,
        "name_sucursal" => $key['name_sucursal'],
        "name_user" => $key['name_user'],
        "fecha_aplicacion" => $fecha_aplicacion,
        "flag_vacuna" => $flag_vacuna,
        "options" => $flag_ver
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
