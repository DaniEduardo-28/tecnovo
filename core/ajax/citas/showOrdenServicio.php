
<?php
try {

  $estado = isset($_POST["estado"])  ? $_POST["estado"]  : "all";
  $val = isset($_POST["valor"])  ? $_POST["valor"]  : "";
  $tipobusqueda = isset($_POST["tipobusqueda"])  ? $_POST["tipobusqueda"]  : "-1";
  $cliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : "all";
  $fundo = isset($_POST["id_fundo"]) ? $_POST["id_fundo"] : "all";
  $maquinaria = isset($_POST["id_maquinaria"]) ? $_POST["id_maquinaria"] : "all";
  $operador = isset($_POST["id_trabajador"]) ? $_POST["id_trabajador"] : "all";
  $unidadNegocio = isset($_POST["id_tipo_servicio"]) ? $_POST["id_tipo_servicio"] : "all";

  require_once "core/models/ClassCronograma.php";
  $Resultado = $OBJ_CRONOGRAMA->showreporte($estado, $cliente, $fundo, $maquinaria, $operador, $unidadNegocio);

  if ($Resultado["error"] == "NO") {

    $count = 1;
    foreach ($Resultado["data"] as $key) {
      // Inicializar la variable $options en cada iteración
      $options = '';

      if ($key['estado_trabajo'] !== 'TERMINADO' && $key['estado_trabajo'] !== 'ANULADO') {
        $options .= '&nbsp;<a href="javascript:showModalOperadorMaquinaria(' . $key['id_cronograma'] . ')" class="btn btn-icon btn-outline-warning btn-round mr-0 mb-1 mb-sm-0"><i class="ti ti-user"></i></a>';
      }
        $options .= '&nbsp;<a href="javascript:generarResumenCompras(' . $key['id_cronograma'] . ')"  class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0"><i class="fa fa-file-pdf-o"></i></a>'; 

        //$options .= '&nbsp;<a href="javascript:generarInformeCliente(' . $key['id_cronograma'] . ')"  class="btn btn-icon btn-outline-danger btn-round mr-0 mb-1 mb-sm-0"><i class="fa fa-file-pdf-o"></i></a>'; 

      $retorno_array[] = array(
        "num" => "$count",
        "options" => "$options",
        "codigo" => $key['codigo'],
        "total" => number_format(floatval($key['total']), 2),
        "gastos" => number_format(floatval($key['gastos']), 2),
        "ganancia" => number_format(floatval($key['ganancia']), 2),
        "id_cronograma" => $key['id_cronograma'],
        "nombre_fundo" => $key['nombre_fundo'],
        "nombre_cliente" => $key['nombre_cliente'],
        "nombre_servicio" => $key['nombre_servicio'],
        "cant_medida" => $key['cant_medida'],
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
  } else {
    throw new Exception($Resultado["message"]);
  }
} catch (\Exception $e) {
  $data["error"] = "SI";
  $data["message"] = $e->getMessage();
  $data["data"] = null;
  echo json_encode($data);
  exit();
}
