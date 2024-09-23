<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $fecha_inicio = isset($_POST["fecha_inicio"])	? $_POST["fecha_inicio"]	: "";
    $fecha_fin = isset($_POST["fecha_fin"])	? $_POST["fecha_fin"]	: "";
    $tipo_busqueda = isset($_POST["tipo_busqueda"])	? $_POST["tipo_busqueda"]	: "";
    $tipo = isset($_POST["tipo"])	? $_POST["tipo"]	: "";
    $id_fundo = isset($_SESSION["id_fundo"])	? $_SESSION["id_fundo"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassIngreso.php";
    $DataCantidad = $OBJ_INGRESO->getCount($id_fundo,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_INGRESO->show($id_fundo,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {

        $estado = '';

        switch ($key['estado']) {
          case '0':
            $estado = '<span class="badge badge-danger-inverse px-2 py-1 mt-1">Anulado</span>';
            break;
          case '1':
            $estado = '<span class="badge badge-success-inverse px-2 py-1 mt-1"> Registrado</span>';
            break;
          default:
            // code...
            break;
        }

        $options = '';

        if ($access_options[0]['flag_ver']) {
          $options.='<a href="javascript:verRegistro(' . $key['id_ingreso'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-eye"></i></a>';
        }

        if ($tipo != 'reporte' ) {
          if ($key['estado']=="1") {
            if ($access_options[0]['flag_anular']) {
              $options.='&nbsp;<a href="javascript:deleteRegistro(' . $key['id_ingreso'] . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-na"></i></a>';
            }
          }
        }

        $retorno_array[] =array(
          "num" => $count + $offset,
          "id_orden_compra" => $key['id_orden_compra'],
          "id_ingreso" => $key['id_ingreso'],
          "name_proveedor" => $key['nombre_proveedor'],
          "name_usuario" => $key['nombres_trabajador'],
          "documento" => $key['documento'],
          "fecha_orden" => date('d/m/Y H:i', strtotime($key['fecha'])),
          "num_registros" => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $key['num_registros'],
          "estado" => $estado,
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
