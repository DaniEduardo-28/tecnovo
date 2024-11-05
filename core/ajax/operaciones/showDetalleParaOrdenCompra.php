<?php

try {
    // obtiene los valores para realizar la paginacion
    $limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"]) : 10;
    $offset = isset($_POST["offset"]) && intval($_POST["offset"]) >= 0 ? intval($_POST["offset"]) : 0;
    $id_fundo = isset($_POST["id_fundo"]) ? $_POST["id_fundo"] : (isset($_SESSION['id_fundo']) ? $_SESSION['id_fundo'] : null);
    $id_moneda = isset($_POST["id_moneda"]) ? $_POST["id_moneda"] : 0;
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";

    $access_options = $OBJ_ACCESO_OPCION->getPermitsOptions($_SESSION['id_grupo'], printCodeOption("ordencompra"));

    if ($access_options[0]['error'] == "NO") {
        if ($access_options[0]['flag_buscar'] == false) {
            throw new Exception("No tienes permisos para realizar búsquedas.");
        }
    } else {
        throw new Exception("Error al verificar los permisos.");
    }

    require_once "core/models/ClassOrdenCompra.php";
    require_once "core/models/ClassMoneda.php";

    $DataCantidad = $OBJ_ORDEN_COMPRA->getCountDetalleParaOrden($id_fundo, $tipo, $valor);

    if ($DataCantidad["error"] == "NO") {

        $cantidad = $DataCantidad["data"][0]["cantidad"];
        $Resultado = $OBJ_ORDEN_COMPRA->showDetalleParaOrden($id_fundo, $tipo, $valor, $offset, $limit);

        $count = 1 + $offset;
        $tipo_cambio_moneda_a_convertir = 1;
        $signo_moneda = "SN ";

        $dataMoneda = $OBJ_MONEDA->show("1");
        foreach ($dataMoneda["data"] as $key) {
            $tipo_cambio = $key['flag_principal'] == 1 ? 1.00 : $OBJ_MONEDA->getTipoCambio($key['id_moneda']);
            if ($key['id_moneda'] == $id_moneda) {
                $tipo_cambio_moneda_a_convertir = $tipo_cambio;
                $signo_moneda = $key['signo'];
            }
            $retorno_moneda[] = array(
                "id_moneda" => $key['id_moneda'],
                "signo" => $key['signo'],
                "flag_principal" => $key['flag_principal'],
                "tipo_cambio" => $tipo_cambio,
            );
        }

        foreach ($Resultado["data"] as $key) {

            $precio_unitario = 1;

            foreach ($retorno_moneda as $key1) {

                if ($key1['id_moneda'] == $key['id_moneda']) {

                    $precio_unitario = $key['precio_unitario'];
                    $tipo_cambio_moneda = $key1['tipo_cambio'];
                    $precio_unitario = $precio_unitario * $tipo_cambio_moneda / $tipo_cambio_moneda_a_convertir;
                    $precio_unitario = number_format((float)$precio_unitario, 2, '.', '');

                }

            }

            $flag_seleccionar = '<button class="btn btn-success" id="btnCheckProducto"><span class="fa fa-check"></span></button>';

            $retorno_array[] = array(
                "num" => "$count",
                "descripcion" => $key['descripcion'],
                "cod_producto" => $key['cod_producto'],
                "id_moneda" => $key['id_moneda'],
                "src_imagen" => $key['src_imagen'],
                "stock" => $key['stock'],
                "precio_unitario" => $precio_unitario,
                "precio_unitario_string" => $signo_moneda . " " . $precio_unitario,
                "seleccionar" => "$flag_seleccionar",
            );
            $count++;

        }

        $data["error"] = "NO";
        $data["message"] = "Success";
        $data["cantidad"] = $cantidad;
        $data["data"] = $retorno_array;
        header('Content-Type: application/json');
        echo json_encode($data);

    } else {
        throw new Exception($DataCantidad["message"]);
    }

} catch (\Exception $e) {
    $data["error"] = "SI";
    $data["message"] = $e->getMessage();
    $data["data"] = null;

    // Registro del error y asegurarse de que el contenido sea JSON
    error_log("Error en showDetalleParaOrdenCompra: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();

    
}

ini_set('display_errors', 0);
error_reporting(0);


?>
