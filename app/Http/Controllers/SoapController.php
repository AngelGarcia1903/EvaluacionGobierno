<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VehiculoSoapService;
use SoapServer;

class SoapController extends Controller
{
    public function handle(Request $request)
    {
        // Configuramos el servidor SOAP en modo Non-WSDL
        $options = [
            'uri' => url('/api/soap-server')
        ];

        $server = new SoapServer(null, $options);

        // Le pasamos la clase que contiene las funciones que el cliente puede usar
        $server->setClass(VehiculoSoapService::class);

        // Capturamos la salida en XML que genera PHP nativamente y la devolvemos
        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response)->header('Content-Type', 'text/xml; charset=utf-8');
    }
}
