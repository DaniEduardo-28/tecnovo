<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $id_doc_cliente = isset($_POST["id_doc_cliente"])	? $_POST["id_doc_cliente"]	: "";
    $id_doc_venta = isset($_POST["id_doc_venta"])	? $_POST["id_doc_venta"]	: "";
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $estado = isset($_POST["estado"])	? $_POST["estado"]	: "all";
    $id_sucursal = isset($_SESSION['id_sucursal']) ? $_SESSION['id_sucursal'] : 0;
    $id_trabajador = isset($_SESSION['id_trabajador']) ? $_SESSION['id_trabajador'] : "0";
    $fecha_inicio = isset($_POST["fecha_inicio"])	? $_POST["fecha_inicio"]	: date("Y-m-d");
    $fecha_fin = isset($_POST["fecha_fin"])	? $_POST["fecha_fin"]	: date("Y-m-d");

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordenventa"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
      if ($access_options[0]['flag_descargar']) {
        $id_trabajador = "all";
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenVenta.php";
    $DataCantidad = $OBJ_ORDEN_VENTA->getCount($id_sucursal,$id_trabajador,$id_doc_venta,$id_doc_cliente,$estado,$valor,$fecha_inicio,$fecha_fin);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_ORDEN_VENTA->show($id_sucursal,$id_trabajador,$id_doc_venta,$id_doc_cliente,$estado,$valor,$offset,$limit,$fecha_inicio,$fecha_fin);

      $count = 1 + $offset;
      foreach ($Resultado["data"] as $key) {
        $estado = "";
        $options = "";
        switch ($key['estado']) {
          case '1':
            $estado = '<span class="badge badge-warning-inverse px-2 py-1 mt-1">En Proceso</span>';
            break;
          case '2':
            $estado = '<span class="badge badge-success-inverse px-2 py-1 mt-1">Registrado</span>';
            break;
          case '3':
            $estado = '<span class="badge badge-danger-inverse px-2 py-1 mt-1">Anulado</span>';
            break;
          default:
            // code...
            break;
        }

        if ($key['estado']=="1") {
          if ($access_options[0]['flag_editar']) {
            $options.= '<a href="javascript:getDataEdit(' . $key['id_venta'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
          }
          if ($access_options[0]['flag_anular']) {
            $options.= '&nbsp;&nbsp;<a href="javascript:eliminarOperacion(' . $key['id_venta'] . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-close"></i></a>';
          }
        }elseif ($key['estado']=="2") {
          if ($access_options[0]['flag_anular']) {
            $options.= '&nbsp;&nbsp;<a href="javascript:anularOperacion(' . $key['id_venta'] . ",'" . $key['name_documento_venta'] . " " . $key['serie'] . "-" . substr("0000000" . $key['correlativo'],-8) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-na"></i></a>';
          }
        }

        if ($access_options[0]['flag_ver']) {
          $options.= '&nbsp;&nbsp;<a href="javascript:verRegistro(' . $key['id_venta'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-eye"></i></a>';
        }
        if (($key['estado']=="2" || $key['estado']=="3") && $key['flag_enviado']) {
          $options.= '&nbsp;&nbsp;<a href="?view=printvercomprobante&id_venta=' . $key['id_venta'] . '" target="_blank" class="btn btn-icon btn-outline-info btn-round mr-0 mb-1 mb-sm-0 "><i class="ti ti-printer"></i></a>';
        }

        $retorno_array[] =array(
          "num" => "$count",
          "id_venta" => $key['id_venta'],
          "id_sucursal" => $key['id_sucursal'],
          "id_trabajador" => $key['id_trabajador'],
          "name_documento_venta" => $key['name_documento_venta'],
          "codigo_documento_venta" => $key['codigo_documento_venta'],
          "serie" => $key['serie'],
          "correlativo" => substr('0000000' . $key['correlativo'],-8),
          "name_documento_cliente" => $key['name_documento_cliente'],
          "codigo_documento_cliente" => $key['codigo_documento_cliente'],
          "numero_documento_cliente" => $key['numero_documento_cliente'],
          "codigo_forma_pago" => $key['codigo_forma_pago'],
          "name_forma_pago" => $key['name_forma_pago'],
          "cliente" => $key['cliente'],
          "direccion" => $key['direccion'],
          "telefono" => $key['telefono'],
          "correo" => $key['correo'],
          "fecha" => date('d/m/Y', strtotime($key['fecha'])),
          "fecha_vencimiento" => date('d/m/Y', strtotime($key['fecha_vencimiento'])),
          "sub_total" => $key['sub_total'],
          "igv" => $key['igv'],
          "total" => $key['total'],
          "pdf" => $key['pdf'],
          "xml" => $key['xml'],
          "cdr" => $key['cdr'],
          "flag_doc_interno" => $key['flag_doc_interno'],
          "monto_recibido" => $key['monto_recibido'],
          "vuelto" => $key['vuelto'],
          "codigo_moneda" => $key['codigo_moneda'],
          "signo_moneda" => $key['signo_moneda'],
          "abreviatura_moneda" => $key['abreviatura_moneda'],
          "signo_moneda_cambio" => $key['signo_moneda_cambio'],
          "monto_tipo_cambio" => $key['monto_tipo_cambio'],
          "observaciones" => $key['observaciones'],
          "flag_enviado" => $key['flag_enviado'],
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
