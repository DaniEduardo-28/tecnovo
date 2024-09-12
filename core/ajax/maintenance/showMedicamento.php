<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_tipo_medicamento = isset($_POST["id_tipo_medicamento"])	? $_POST["id_tipo_medicamento"]	: "";
    $id_sucursal = isset($_SESSION["id_sucursal"])	? $_SESSION["id_sucursal"]	: 0;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("medicamento"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassMedicamento.php";
    $DataCantidad = $OBJ_MEDICAMENTO->getCount("all",$id_tipo_medicamento,$valor,$id_sucursal);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_MEDICAMENTO->show("all",$id_tipo_medicamento,$valor,$offset,$limit,$id_sucursal);

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="activo") ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>' : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>' ;
        $flag_editar='';
        $flag_eliminar='';
        if ($access_options[0]['flag_editar']) {
          $flag_editar = '<a href="javascript:getDataEdit(' . $key['id_medicamento'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_medicamento'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['name_medicamento'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id_medicamento" => $key['id_medicamento'],
          "name_medicamento" => $key['name_medicamento'],
          "descripcion" => $key['descripcion'],
          "stock" => $key['stock'],
          "stock_minimo" => $key['stock_minimo'],
          "name_tipo" => $key['name_tipo'],
          "precio_compra" => $key['precio_compra'],
          "precio_venta" => $key['precio_venta'],
          "src_imagen" => $key['src_imagen'],
          "name_unidad" => $key['name_unidad'],
          "signo_moneda" => $key['signo_moneda'],
          "estado" => $estado,
          "flag_editar" => "$flag_editar",
          "flag_eliminar" => "$flag_eliminar"
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
