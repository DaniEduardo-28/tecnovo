<?php
try {
    // Capturar parámetros desde POST
    $estado = isset($_POST["estado"]) ? $_POST["estado"] : "all";
    $cliente = isset($_POST["cliente"]) ? $_POST["cliente"] : "all";
    $fundo = isset($_POST["fundo"]) ? $_POST["fundo"] : "all";
    $maquinaria = isset($_POST["maquinaria"]) ? $_POST["maquinaria"] : "all";
    $operador = isset($_POST["operador"]) ? $_POST["operador"] : "all";
    $unidadNegocio = isset($_POST["unidadNegocio"]) ? $_POST["unidadNegocio"] : "all";

    // Importar clase que contiene la lógica
    require_once "core/models/ClassCronograma.php";
    $OBJ_CRONOGRAMA = new ClassCronograma();

    // Llamar a la función `showreporte` para obtener los datos
    $Resultado = $OBJ_CRONOGRAMA->showreporte($estado, $cliente, $fundo, $maquinaria, $operador, $unidadNegocio);

    if ($Resultado["error"] === "NO") {
        $retorno_array = [];
        $count = 1;

        foreach ($Resultado["data"] as $key) {
            $retorno_array[] = array(
                "num" => $count,
                "codigo" => $key['codigo'],
                "total" => number_format($key['total'], 2),
                "gastos" => number_format($key['gastos'], 2),
                "ganancia" => number_format($key['ganancia'], 2),
                "nombre_fundo" => $key['nombre_fundo'],
                "nombre_cliente" => $key['nombre_cliente'],
                "nombre_servicio" => $key['nombre_servicio'],
                "nombre_operador" => $key['nombre_operador'],
                "fecha_ingreso" => $key['fecha_ingreso'],
                "fecha_salida" => $key['fecha_salida'],
                "estado_trabajo" => $key['estado_trabajo'],
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
?>
