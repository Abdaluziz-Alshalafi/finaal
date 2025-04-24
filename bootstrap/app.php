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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'checkadmin' => \App\Http\Middleware\CheckAdmin::class,
            'user.access' => \App\Http\Middleware\CheckAdmin::class,
            'AdminMiddleware' => \App\Http\Middleware\AdminMiddleware::class,
            'StudentMiddleware' => \App\Http\Middleware\StudentMiddleware::class,
        ]);
    })
    ->withSchedule(function ($schedule) { // هنا تستخدم دالة قابلة للتنفيذ (callback)
        $schedule->command('archive:scheduler')->daily(); // تحديد المهمة المجدولة
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
