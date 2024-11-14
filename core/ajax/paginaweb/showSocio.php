<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 6;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("websocio"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.", 1);
    }

    require_once "core/models/ClassSocio.php";
    //primer parametro estado
    //segundo parametro 1=tabla galeria
    $DataCantidad = $OBJ_SOCIO->getCount("all","2");

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_SOCIO->show("all","2",$offset,$limit);

      $count = 1;
      foreach ($Resultado["data"] as $key) {

        $estado = ($key['estado']=="activo") ? '<td><a href="javascript:void(0)" class="dot bg-success"></a><span>Activo</span></td>' : '<td><a href="javascript:void(0)" class="dot bg-danger"></a><span>Inactivo</span></td>' ;
        $flag_editar='';
        $flag_eliminar='';
        if ($access_options[0]['flag_editar']) {
          $flag_editar = '<a href="javascript:getDataEdit(' . $key['id'] . ')" class="btn btn-icon btn-outline-primary btn-round mr-2 mb-2 mb-sm-0 "><i class="ti ti-pencil"></i></a>';
        }
        if ($access_options[0]['flag_eliminar']) {
          $flag_eliminar = '<a href="javascript:deleteRegistro(' . $key['id'] . ",'" . str_replace('"',' ',str_replace("'",' ',$key['titulo'])) . "'" . ')" class="btn btn-icon btn-outline-danger btn-round"><i class="ti ti-close"></i></a>';
        }
        $retorno_array[] =array(
          "num" => "$count",
          "id" => $key['id'],
          "titulo" => $key['titulo'],
          "descripcion" => $key['descripcion'],
          "src_imagen" => $key['src'],
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
