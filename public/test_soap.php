<?php
// Script rápido de prueba
$url = "http://tu-dominio.local/api/soap-server"; // Cambia por tu URL local
$params = ['termino' => 'ABC-123']; // Una placa que exista en tu DB

try {
    $cliente = new SoapClient(null, [
        'location' => $url,
        'uri'      => $url,
        'trace'    => 1
    ]);

    $resultado = $cliente->obtenerHistorialVehiculo($params['termino']);
    echo "<h2>Resultado SOAP:</h2><pre>" . $resultado . "</pre>";
} catch (SoapFault $e) {
    echo "Error SOAP: " . $e->getMessage();
}
