<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $id_categoria = isset($_POST["id_categoria"])	? $_POST["id_categoria"]	: "";
    $id_fundo = isset($_SESSION["id_fundo"])	? $_SESSION["id_fundo"]	: 0;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("accesorio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassAccesorio.php";
    $DataCantidad = $OBJ_ACCESORIO->getCount("all",$id_categoria,$valor,$id_fundo);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_ACCESORIO->show("all",$id_categoria,$valor,$offset,$limit,$id_fundo);

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $estado = ($key['estado']=="activo") ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>' : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>' ;
        $flag_editar='';
        $flag_eliminar='';
        if ($access_options[0]['flag_editar']) {
          $flag_editar = '<a href="javascript:getDataEdit(' . $key['id_accesorio'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id_accesorio'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['name_accesorio'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id_accesorio" => $key['id_accesorio'],
          "name_accesorio" => $key['name_accesorio'],
          "descripcion" => $key['descripcion'],
          "stock" => $key['stock'],
          "stock_minimo" => $key['stock_minimo'],
          "name_categoria" => $key['name_categoria'],
          "precio_compra" => $key['precio_compra'],
          "precio_venta" => $key['precio_venta'],
          "name_unidad" => $key['name_unidad'],
          "signo_moneda" => $key['signo_moneda'],
          "flag_igv" => $key['flag_igv'],
          "precio_venta" => $key['precio_venta'],
          "src_imagen" => $key['src_imagen'],
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
