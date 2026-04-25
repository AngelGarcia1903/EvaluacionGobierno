<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SoapService;
use SoapServer;

class SoapController extends Controller
{
    public function handle(Request $request)
    {
        // El servidor SOAP necesita una URL absoluta
        $options = [
            'uri' => url('/api/soap-server')
        ];

        $server = new SoapServer(null, $options);
        $server->setClass(SoapService::class);

        ob_start();
        $server->handle();
        $response = ob_get_clean();

        return response($response)->header('Content-Type', 'text/xml; charset=utf-8');
    }
}
