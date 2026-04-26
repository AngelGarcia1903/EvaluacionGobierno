<?php
// Script rápido de prueba

// 1. CAMBIA ESTO por la URL exacta con la que entras a tu proyecto en el navegador.
// Por ejemplo, si usas la URL de Laragon:
$url = "http://evaluacionfinal.test/api/soap-server";
// O si usas php artisan serve: $url = "http://localhost:8000/api/soap-server";

// 2. Pon una placa que SÍ EXISTA en tu base de datos (Ej: la de la captura que me mandaste)
$params = ['termino' => 'GTO-3498'];

try {
    $cliente = new SoapClient(null, [
        'location' => $url,
        'uri'      => $url,
        'trace'    => 1
    ]);

    $resultado = $cliente->obtenerHistorialVehiculo($params['termino']);
    // Cambiamos a print_r para imprimir el objeto completo
    echo "<h2>Resultado SOAP de Plataforma Irapuato:</h2><pre>" . print_r($resultado, true) . "</pre>";
} catch (SoapFault $e) {
    echo "Error SOAP: " . $e->getMessage();
}
