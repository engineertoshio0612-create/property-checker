<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $toApi404 = function (Request $request) {
            return $request->is('api/*')
                ? response()->json(['message' => 'リソースが見つかりません。'], 404)
                : null;
        };

        $exceptions->render(function (ModelNotFoundException $e, Request $request) use ($toApi404) {
            return $toApi404($request);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) use ($toApi404) {
            return $toApi404($request);
        });
    })->create();
