<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // global middlewares
    ];

    protected $middlewareGroups = [
        'api' => [
            \Illuminate\Http\Middleware\HandleCors::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
    

    protected $routeMiddleware = [
        // middlewares que podem ser usados nas rotas
    ];
}
