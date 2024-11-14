<?php

$ruc = isset($_POST["ruc"]) ? $_POST["ruc"] : "";

$params = json_encode(['ruc' => "$ruc"]);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiperu.dev/api/ruc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer 63d260ac2cf542aaf91d8a2221af0da11f8d15ccde587ba73b85b482d897b386'
    ],
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

header('Content-Type: application/json');

if ($err) {
    // En caso de error, devuelve un JSON con el mensaje de error
    echo json_encode(['success' => false, 'error' => $err]);
} else {
    // Decodifica la respuesta de la API para procesarla en PHP
    $apiResponse = json_decode($response, true);

    // Verifica si la API devolvió éxito
    if ($apiResponse['success']) {
        // Devuelve solo los datos necesarios como JSON
        echo json_encode(['success' => true, 'data' => $apiResponse['data']]);
    } else {
        // Si la API no tuvo éxito, devuelve el error
        echo json_encode(['success' => false, 'error' => 'Error en la respuesta de la API']);
    }
}

?>