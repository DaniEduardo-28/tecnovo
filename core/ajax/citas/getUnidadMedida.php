<?php
try {
    require_once "core/models/ClassCronograma.php";

    $id_cronograma = isset($_POST['id_cronograma']) ? $_POST['id_cronograma'] : null;

    if ($id_cronograma && is_numeric($id_cronograma)) {
        $resultado = $OBJ_CRONOGRAMA->getUnidadMedidaByServicio($id_cronograma);

        if ($resultado['error'] === 'NO') {
            echo json_encode([
                'error' => 'NO',
                'data' => $resultado['data']
            ]);
        } else {
            echo json_encode([
                'error' => 'SI',
                'message' => $resultado['message']
            ]);
        }
    } else {
        echo json_encode([
            'error' => 'SI',
            'message' => 'ID de cronograma no válido o faltante.'
        ]);
    }
} catch (\Exception $e) {
    echo json_encode([
        'error' => 'SI',
        'message' => $e->getMessage()
    ]);
}
