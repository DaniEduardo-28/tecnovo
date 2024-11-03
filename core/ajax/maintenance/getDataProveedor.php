<?php
require_once "core/models/ClassProveedor.php"; // Suponiendo que tienes una clase para proveedores

try {
    $numero_documento = isset($_POST['numero_documento']) ? $_POST['numero_documento'] : '';

    if (empty($numero_documento)) {
        throw new Exception("El número de documento es obligatorio.");
    }

    $OBJ_PROVEEDOR = new ClassProveedor();
    $resultado = $OBJ_PROVEEDOR->getProveedorPorDocumento($numero_documento);

    if ($resultado['error'] === "NO" && !empty($resultado['data'])) {
        $data = $resultado['data'][0];
        $response = [
            "error" => "NO",
            "data" => [
                "nombre_proveedor" => $data['nombre_proveedor'],
                "apellidos_proveedor" => $data['apellidos_proveedor'],
                "direccion_proveedor" => $data['direccion_proveedor'],
                "telefono_proveedor" => $data['telefono_proveedor'],
                "correo_proveedor" => $data['correo_proveedor']
            ]
        ];
    } else {
        throw new Exception("Proveedor no encontrado.");
    }

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode([
        "error" => "SI",
        "message" => $e->getMessage()
    ]);
}
