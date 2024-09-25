<?php
  ini_set('display_errors', 0);
  ini_set('log_errors', 1);
  error_reporting(E_ALL);

  try {

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("tipocosecha"));
    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassTipoCosecha.php";
    $Resultado = $OBJ_TIPO_COSECHA->show("all");

    if ($Resultado["error"]=="NO") {

      $options = '';
      if (!empty($access_options[0]['flag_editar']) && $access_options[0]['flag_editar']) {
          $options .= '<a href="javascript:void(0)" id="btnEdit" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0"><i class="ti ti-pencil"></i></a>';
      }
      if (!empty($access_options[0]['flag_eliminar']) && $access_options[0]['flag_eliminar']) {
          $options .= '<a href="javascript:void(0)" id="btnDelete" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
      }

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = isset($key['estado']) && $key['estado'] == "activo"
            ? '<label class="badge badge-success">Activo</label>'
            : '<label class="badge badge-danger">Inactivo</label>';
        
        $retorno_array[] =array(
            "num" => "$count",
            "id_tipo_cosecha" => isset($key['id_tipo_cosecha']) ? $key['id_tipo_cosecha'] : 'N/A',
            "descripcion" => isset($key['descripcion']) ? $key['descripcion'] : 'N/A',
            "estado" => $estado,
            "options" => $options
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

  ini_set('error_log', 'path/to/php-error.log');
 ?>

