<?php
  try {  
    
    $estado = isset($_POST["estado"])	? $_POST["estado"]	: "all";
    $val = isset($_POST["valor"])	? $_POST["valor"]	: "";
    $tipobusqueda = isset($_POST["tipobusqueda"])	? $_POST["tipobusqueda"]	: "-1";
    $cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "all";
    $fundo = isset($_POST["id_fundo"]) ? $_POST["id_fundo"] : "all";
    $maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "all";
    $operador = isset($_POST["id_trabajador"]) ? $_POST["id_trabajador"] : "all";
    
    require_once "core/models/ClassCronograma.php";
    $Resultado = $OBJ_CRONOGRAMA->showreporte($estado, $cliente, $fundo, $maquinaria, $operador);

    if ($Resultado["error"] == "NO" && count($Resultado["data"]) > 0) {

      $count = 1;
      foreach ($Resultado["data"] as $key) {
        // Inicializar la variable $options en cada iteración
        $options = '';
    
        if ($key['estado_trabajo'] === 'TERMINADO' || $key['estado_trabajo'] === 'ANULADO') {
            $options = ''; // No mostrar ningún botón en estos estados
        } else {
            $options .= '&nbsp;<a href="javascript:showModalOperador(' . $key['id_cronograma'] . ')" class="btn btn-icon btn-outline-info btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-user"></i></a>';
            $options .= '&nbsp;<a href="javascript:showModalMaquinaria(' . $key['id_cronograma'] . ')" class="btn btn-icon btn-outline-success btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-harddrives"></i></a>';
        }
      $retorno_array[] =array(
          "options" => "$options",
          "num" => "$count",
          "total" => number_format($key['total'], 2),
          "gastos" => number_format($key['gastos'], 2),
          "ganancia" => number_format($key['ganancia'], 2),
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