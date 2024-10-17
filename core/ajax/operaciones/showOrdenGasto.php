<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $fecha_gasto = isset($_POST["fecha_gasto"])	? $_POST["fecha_gasto"]	: "";
    $tipo_busqueda = isset($_POST["tipo_busqueda"])	? $_POST["tipo_busqueda"]	: "";
    $tipo = isset($_POST["tipo"])	? $_POST["tipo"]	: "";
    $id_gasto = isset($_SESSION["id_gasto"])	? $_SESSION["id_gasto"]	: 0;


    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordengasto"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenGasto.php";
    $DataCantidad = $OBJ_ORDEN_GASTO->getCount($id_gasto,$valor,$fecha_gasto,$tipo_busqueda);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_ORDEN_GASTO->show($id_gasto,$valor,$fecha_gasto,$tipo_busqueda,$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {


        $options = '';

        if ($access_options[0]['flag_ver']) {
          $options.='<a href="javascript:verRegistro(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-eye"></i></a>';
        }

        if ($tipo != 'reporte') {

          if ($key['estado']=="0") {
            if ($access_options[0]['flag_editar']) {
              $options.='&nbsp;<a href="javascript:getDataEdit(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
            }
            if ($access_options[0]['flag_anular']) {
              $options.='&nbsp;<a href="javascript:deleteRegistro(' . $key['id_orden_gasto'] . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-na"></i></a>';
            }
          }

        }

        if ($access_options[0]['flag_ver']) {
          $options.='<a href="?view=printordengasto&id_orden_gasto=' . $key['id_orden_gasto'] . '" class="btn btn-icon btn-outline-info btn-round mr-0 mb-1 mb-sm-0 " target="_blank"><i class="ti ti-printer"></i></a>';
        }

        $retorno_array[] =array(
          "num" => $count + $offset,
          "id_orden_gasto" => $key['id_orden_gasto'],
          "nombre_proveedor" => $key['nombre_proveedor'],
          "name_usuario" => $key['nombres_trabajador'],
          "fecha_gasto" => date('d/m/Y H:i', strtotime($key['fecha_gasto'])),
          "num_registros" => '&nbsp;&nbsp;&nbsp;' . $key['num_registros'],
          "total" => $key['signo_moneda'] . ' ' . $key['total'],
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
