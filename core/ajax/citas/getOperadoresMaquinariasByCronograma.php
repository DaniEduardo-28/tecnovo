<?php
try {
    require_once "core/models/ClassCronograma.php";

    // Validar que el ID del cronograma sea válido
    $id_cronograma = isset($_POST['id_cronograma']) ? $_POST['id_cronograma'] : null;

    if ($id_cronograma && is_numeric($id_cronograma)) {
        // Llamar a la función del modelo para obtener los datos
        $resultado = $OBJ_CRONOGRAMA->getOperadoresMaquinariasByCronograma($id_cronograma);

        if ($resultado['error'] === 'NO' && !empty($resultado['data'])) {
            echo json_encode([
                'error' => 'NO',
                'data' => $resultado['data']
            ]);
        } else {
            echo json_encode([
                'error' => 'SI',
                'message' => 'No se encontraron operadores o maquinarias para este cronograma.'
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
