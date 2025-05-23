<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $fecha_inicio = isset($_POST["fecha_inicio"])	? $_POST["fecha_inicio"]	: "";
    $fecha_fin = isset($_POST["fecha_fin"])	? $_POST["fecha_fin"]	: "";
    $tipo_busqueda = isset($_POST["tipo_busqueda"])	? $_POST["tipo_busqueda"]	: "";
    $id_sucursal = isset($_SESSION["id_sucursal"])	? $_SESSION["id_sucursal"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ingreso"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_agregar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenCompra.php";
    $DataCantidad = $OBJ_ORDEN_COMPRA->getCount1($id_sucursal,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_ORDEN_COMPRA->show1($id_sucursal,$valor,$fecha_inicio,$fecha_fin,$tipo_busqueda,$offset,$limit);
      $count = 1;

      foreach ($Resultado["data"] as $key) {

        $estado = '';

        switch ($key['estado']) {
          case '0':
            $estado = '<span class="badge badge-warning-inverse px-2 py-1 mt-1">En proceso ...</span>';
            break;
          case '1':
            $estado = '<span class="badge badge-info-inverse px-2 py-1 mt-1"> En espera...</span>';
            break;
          default:

            break;
        }

        $options = '<a href="javascript:seleccionarOrden(' . $key['id_orden_compra'] . ')" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-check"></i></a>';

        $retorno_array[] =array(
          "num" => $count + $offset,
          "id_orden_compra" => $key['id_orden_compra'],
          "name_proveedor" => $key['nombre_proveedor'],
          "name_usuario" => $key['nombres_trabajador'],
          "fecha_orden" => date('d/m/Y H:i', strtotime($key['fecha_orden'])),
          "fecha_entrega" => date('d/m/Y', strtotime($key['fecha_entrega'])),
          "name_forma_envio" => $key['name_metodo'],
          "num_registros" => '&nbsp;&nbsp;' . $key['num_registros'],
          "total" => $key['signo_moneda'] . ' ' . $key['total'],
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
