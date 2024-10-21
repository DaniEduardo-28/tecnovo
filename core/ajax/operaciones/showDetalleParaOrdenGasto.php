<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    
    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("ordengasto"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenGasto.php";
    $DataCantidad = $OBJ_ORDEN_GASTO->getCountDetalleParaOrden($valor);

    if ($DataCantidad["error"]=="NO") {

      $cantidad = $DataCantidad["data"][0]["cantidad"];
      $Resultado = $OBJ_ORDEN_GASTO->showDetalleParaOrden($valor,$offset,$limit)  ;

      $count = 1 + $offset;
      /* $tipo_cambio_moneda_a_convertir = 1;
      $signo_moneda = "SN "; */


      foreach ($Resultado["data"] as $key) {


        $flag_seleccionar = '<button class="btn btn-success" id="btnCheckProducto"><span class="fa fa-check"></span></button>';

        $retorno_array[] =array(
          "num" => "$count",
          "descripcion" => $key['descripcion'],
          "cod_gasto" => $key['cod_gasto'],
          "seleccionar" => "$flag_seleccionar",
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
