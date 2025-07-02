<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Allow-Credentials' => 'true'
        ];

        // Responde diretamente a requisições OPTIONS
        if ($request->getMethod() === "OPTIONS") {
            return response()->json('OK', 200, $headers);
        }

        // Continua fluxo normal da aplicação
        $response = $next($request);

        // Adiciona os headers na resposta
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
