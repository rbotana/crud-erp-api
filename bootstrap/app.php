<?php

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Notification\NotificationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        $exceptions->renderable(function (NotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);            
        });

        $exceptions->renderable(function (EntityValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);            
        });

        $exceptions->renderable(function (NotificationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);            
        });

    })->create();
