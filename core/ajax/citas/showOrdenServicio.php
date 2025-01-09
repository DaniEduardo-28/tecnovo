<?php
  try {  
    
    $estado = isset($_POST["estado"])	? $_POST["estado"]	: "all";
    $val = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $tipobusqueda = isset($_POST["tipobusqueda"])	? $_POST["tipobusqueda"]	: "-1";
    $cliente = isset($_POST["cliente"]) ? $_POST["cliente"] : "all";
    $fundo = isset($_POST["fundo"]) ? $_POST["fundo"] : "all";
    $maquinaria = isset($_POST["maquinaria"]) ? $_POST["maquinaria"] : "all";
    $operador = isset($_POST["operador"]) ? $_POST["operador"] : "all";
    
    require_once "core/models/ClassCronograma.php";
    $Resultado = $OBJ_CRONOGRAMA->showreporte();

    if ($Resultado["error"]=="NO") {

      $options="";
      $count = 1;
      foreach ($Resultado["data"] as $key) {
        $retorno_array[] =array(
          "num" => "$count",
          "id_cronograma" => $key['id_cronograma'],
          "nombre_fundo" => $key['nombre_fundo'],
          "nombre_cliente" => $key['nombre_cliente'],
          "nombre_servicio" => $key['nombre_servicio'],
          "nombre_operador" => $key['nombre_operador'],
          "nombre_maquinaria" => $key['nombre_maquinaria'],
          "fecha_ingreso" => $key['fecha_ingreso'],
          "fecha_salida" => $key['fecha_salida'],
          "estado_trabajo" => $key['estado_trabajo']
        );
        $count++;
      }
      $data["error"] = "NO";
      $data["message"] = "Success";
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