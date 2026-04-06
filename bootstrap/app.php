<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin'       => \App\Http\Middleware\IsAdmin::class,
            'super_admin' => \App\Http\Middleware\IsSuperAdmin::class,
            'module'      => \App\Http\Middleware\CheckModuleAccess::class,
            'permission'  => \App\Http\Middleware\CheckPermission::class,
            'rbac'        => \App\Http\Middleware\RbacMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
