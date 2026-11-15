<?php 
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.log',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias middleware role di sini
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class, // sesuaikan jika nama middleware role Anda berbeda
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();