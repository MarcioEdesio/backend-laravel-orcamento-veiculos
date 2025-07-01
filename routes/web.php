<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/orcamento', 'OrcamentoController@enviar');

$router->options('/{any:.*}', function () {
    return response('', 204);
});


