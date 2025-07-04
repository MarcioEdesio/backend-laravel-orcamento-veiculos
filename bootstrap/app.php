<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));


$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades(true, [
    Illuminate\Support\Facades\Mail::class => 'Mail',
]);

// $app->withEloquent();
$app->register(Illuminate\Validation\ValidationServiceProvider::class);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->configure('app');
$app->configure('mail');

$app->register(Illuminate\Mail\MailServiceProvider::class);

$app->withFacades(true, [
    Illuminate\Support\Facades\Mail::class => 'Mail',
]);

$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);





return $app;
