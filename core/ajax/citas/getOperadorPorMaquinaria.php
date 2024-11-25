<?php
if ($_GET['accion'] === 'getOperadorPorMaquinaria') {
    require_once "core/models/ClassCita.php";

    $id_maquinaria = isset($_POST['id_maquinaria']) ? $_POST['id_maquinaria'] : null;

    if (!$id_maquinaria) {
        echo json_encode([
            'error' => 'SI',
            'message' => 'ID de maquinaria no proporcionado'
        ]);
        exit;
    }

    $resultado = $OBJ_CITA->getOperadorPorMaquinaria($id_maquinaria);

    if ($resultado['error'] === 'NO') {
        echo json_encode([
            'error' => 'NO',
            'message' => 'Operador encontrado',
            'data' => $resultado['data']
        ]);
    } else {
        echo json_encode([
            'error' => 'SI',
            'message' => $resultado['message']
        ]);
    }
}

