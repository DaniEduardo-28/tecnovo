<?php

  try {

    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
    $valor = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $estado = isset($_POST["estado"])	? $_POST["estado"]	: "all";
    $id_documento = isset($_SESSION['id_documento']) ? $_SESSION['id_documento'] : 0;
    $id_cliente = isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : "0";
    $fecha_inicio = isset($_POST["fecha_inicio"])	? $_POST["fecha_inicio"]	: date("Y-m-d");
    $fecha_fin = isset($_POST["fecha_fin"])	? $_POST["fecha_fin"]	: date("Y-m-d");
    $tipo_busqueda = isset($_POST["id_sucursal"])	? $_POST["id_sucursal"]	: "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'],printCodeOption("vistareportecliente"));

    if ($access_options[0]['error']=="NO") {
      if ($access_options[0]['flag_buscar']==false) {
        throw new Exception("No tienes permisos para realizar busquedas.");
      }
      if ($access_options[0]['flag_descargar']) {
        $id_cliente = "all";
      }
    }else {
      throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassCliente.php";
    $Resultado = $OBJ_CLIENTE->showreporte("all","","");

    if ($Resultado["error"]=="NO") {

        $options="";
        $count = 1;
      foreach ($Resultado["data"] as $key) {

        $retorno_array[] =array(
          "num" => $count + $offset,
          "id_cliente" => $key['id_cliente'],
          "numero_documento" => $key['numero_documento'],
          "nombre_cliente" => $key['nombre_cliente'],
          "direccion" => $key['direccion'],
          "telefono" => $key['telefono'],
          "cant_fundos" => $key['cant_fundos'],
          "estado" => $key['estado']
        );
        $count++;
      }

      $data["error"] = "NO";
      $data["message"] = "Success";
 /*      $data["cantidad"] = $cantidad; */
      $data["data"] = $retorno_array;
      echo json_encode($data);

    }else {
      throw new Exception($Resultado["message"]);
    }

  } catch (\Exception $e) {
    $data["error"]="SI";
    $data["message"]=$e->getMessage();
    $data["data"] = null;
    echo json_encode($data);
    exit();
  }

 ?>
