<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../src/Presentation/Routes/web.php',
        api: __DIR__.'/../src/Presentation/Routes/api.php',
        commands: __DIR__.'/../src/Infrastructure/Routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom exception handling za JSON odgovore
        $exceptions->render(function (Throwable $e, $request) {
            // Za API rute, uvek vraćaj JSON odgovor
            if ($request->is('api/*') || $request->expectsJson()) {
                // Validation exceptions
                if ($e instanceof ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validacione greške',
                        'errors' => $e->errors()
                    ], 422);
                }

                // 404 Not Found
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Resurs nije pronađen'
                    ], 404);
                }

                // 405 Method Not Allowed
                if ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Metoda nije dozvoljena'
                    ], 405);
                }

                // Default error response
                $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                
                $response = [
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Došlo je do greške'
                ];

                // U development modu, dodaj detalje o grešci
                if (config('app.debug')) {
                    $response['exception'] = get_class($e);
                    $response['file'] = $e->getFile();
                    $response['line'] = $e->getLine();
                    $response['trace'] = $e->getTraceAsString();
                }

                return response()->json($response, $statusCode);
            }
        });
    })
    ->create();

