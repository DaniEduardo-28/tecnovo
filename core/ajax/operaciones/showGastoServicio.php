<?php

try {

  $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 10;
  $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
  $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
  $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : "";
  $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : "";
  $tipo_busqueda = isset($_POST["tipo_busqueda"]) ? $_POST["tipo_busqueda"] : "";
  $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
  $id_sucursal = isset($_SESSION["id_sucursal"]) ? $_SESSION["id_sucursal"] : 0;

  $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("gastoservicio"));
  if (!isset($access_options[0]) || $access_options[0]['error'] != "NO") {
    throw new Exception("Error al verificar los permisos.");
  }

  if ($access_options[0]['flag_buscar'] == false) {
    throw new Exception("No tienes permisos para realizar búsquedas.");
  }

  require_once "core/models/ClassGastoServicio.php";
  $DataCantidad = $OBJ_GASTO_SERVICIO->getCount($id_sucursal, $valor, $fecha_inicio, $fecha_fin, $tipo_busqueda);

  if ($DataCantidad["error"] == "NO") {
    $cantidad = $DataCantidad["data"][0]["cantidad"];
    $Resultado = $OBJ_GASTO_SERVICIO->show($id_sucursal, $valor, $fecha_inicio, $fecha_fin, $tipo_busqueda, $offset, $limit);

    $count = 1;
    $retorno_array = [];

    foreach ($Resultado["data"] as $key) {
      $estado = '';

      switch ($key['estado']) {
        case '0':
          $estado = '<span class="badge badge-warning-inverse px-2 py-1 mt-1">En proceso ...</span>';
          break;
        case '1':
          $estado = '<span class="badge badge-info-inverse px-2 py-1 mt-1"> En espera...</span>';
          break;
        case '2':
          $estado = '<span class="badge badge-success-inverse px-2 py-1 mt-1"> Recibido</span>';
          break;
        case '3':
          $estado = '<span class="badge badge-danger-inverse px-2 py-1 mt-1"> Anulado</span>';
          break;
        default:
          break;
      }

      $options = '';

      if ($access_options[0]['flag_ver']) {
        $options .= '<a href="javascript:verRegistro(' . $key['id_gasto_servicio'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-eye"></i></a>';
      }

      if ($tipo != 'reporte') {
        if ($key['estado'] == "0") {
          if ($access_options[0]['flag_editar']) {
            $options .= '&nbsp;<a href="javascript:getDataEdit(' . $key['id_gasto_servicio'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-pencil"></i></a>';
          }
          if ($access_options[0]['flag_anular']) {
            $options .= '&nbsp;<a href="javascript:deleteRegistro(' . $key['id_gasto_servicio'] . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-na"></i></a>';
          }
        } elseif ($key['estado'] == "3") { // Estado "Anulado"
          if ($access_options[0]['flag_eliminar']) {
            $options .= '&nbsp;<a href="javascript:eliminarRegistro(' . $key['id_gasto_servicio'] . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-trash"></i></a>';
          }
        }
      }


      $retorno_array[] = array(
        "num" => $count + $offset,
        "id_gasto_servicio" => $key['id_gasto_servicio'],
        "name_proveedor" => $key['nombre_proveedor'],
        "name_usuario" => $key['nombres_trabajador'],
        "fecha_emision" => date('d/m/Y H:i', strtotime($key['fecha_emision'])),
        "total" => $key['signo_moneda'] . ' ' . $key['total'],
        "estado" => $estado,
        "options" => $options
      );
      $count++;
    }

    $data["error"] = "NO";
    $data["message"] = "Success";
    $data["cantidad"] = $cantidad;
    $data["data"] = $retorno_array;
    echo json_encode($data);
  } else {
    throw new Exception($DataCantidad["message"]);
  }
} catch (\Exception $e) {
  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
  exit();
}
