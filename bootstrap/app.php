<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'auth/google/callback',  // Google is exempted from CSRF token protection. 
            'http://localhost:8000/auth/google/callback',
            'http://example.com/foo/*',
            'http://localhost:8000/auth/google/callback/*',
            'https://accounts.google.com/*',
            '/auth/google/callback',
            '/auth/google/redirect',
            'accounts.google.com/*',
            'stkpush2', // Your specific route
            'http://127.0.0.1:8000/stkpush2', // You can also add the full URI if needed
            'https://773b-2c0f-fe38-2217-be08-1da-30bd-ff89-a658.ngrok-free.app/stkpush2', // Ngrok URI if needed
            'register50',
            'http://127.0.0.1:8000/register50', 
            '/subscribe50',
            '/donate1',
            '/balance', //For the balance api
            '/balance-result', // For the result of the balance accrued. 
            'mpesa/events/register',  //Processing a paid event
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
