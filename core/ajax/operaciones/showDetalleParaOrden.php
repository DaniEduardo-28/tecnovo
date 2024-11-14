<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $id_sucursal = isset($_POST["id_sucursal"])	? $_POST["id_sucursal"]	: 0;
    $id_moneda = isset($_POST["id_moneda"])	? $_POST["id_moneda"]	: 0;
    $tipo = isset($_POST["tipo"])	? $_POST["tipo"]	: "";
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    require_once "core/models/ClassMoneda.php";
    $DataCantidad = $OBJ_ORDEN_VENTA->getCountDetalleParaOrden($id_sucursal,$tipo,$valor);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_ORDEN_VENTA->showDetalleParaOrden($id_sucursal,$tipo,$valor,$offset,$limit);

      $count = 1 + $offset;
      $tipo_cambio_moneda_a_convertir = 1;
      $signo_moneda = "SN ";

      $dataMoneda = $OBJ_MONEDA->show("1");
      foreach ($dataMoneda["data"] as $key) {
        $tipo_cambio = $key['flag_principal'] == 1 ? 1.00 : $OBJ_MONEDA->getTipoCambio($key['id_moneda']);
        if ($key['id_moneda']==$id_moneda) {
          $tipo_cambio_moneda_a_convertir = $tipo_cambio;
          $signo_moneda = $key['signo'];
        }
        $retorno_moneda[] = array(
          "id_moneda" => $key['id_moneda'],
          "signo" => $key['signo'],
          "flag_principal" => $key['flag_principal'],
          "tipo_cambio" => $tipo_cambio,
        );
      }

      foreach ($Resultado["data"] as $key) {

        $precio_unitario = 1;

        foreach ($retorno_moneda as $key1) {

          if ($key1['id_moneda']==$key['id_moneda']) {

            $precio_unitario = $key['precio_unitario'];
            $tipo_cambio_moneda = $key1['tipo_cambio'];
            $precio_unitario = $precio_unitario*$tipo_cambio_moneda/$tipo_cambio_moneda_a_convertir;
            $precio_unitario = number_format((float)$precio_unitario, 2, '.', '');

          }

        }

        $options = '<a id="btnSeleccionar" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-check"></i></a>';
        $retorno_array[] =array(
          "num" => "$count",
          "descripcion" => $key['descripcion'],
          "cod_producto" => $key['cod_producto'],
          "id_moneda" => $key['id_moneda'],
          "precio_unitario" => $precio_unitario,
          "precio_unitario_string" => $signo_moneda . " " . $precio_unitario,
          "seleccionar" => "$options",
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
