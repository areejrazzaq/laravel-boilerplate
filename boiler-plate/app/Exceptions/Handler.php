<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // public function unauthenticated($request, AuthenticationException $exception)
    // {
    //     // Return a JSON response for API requests
    //     if ($request->expectsJson()) {
    //         return response()->json(['message' => 'Unauthorized. Please provide a valid token.'], 401);
    //     }

    //     // For web requests, you may want to redirect to the login page (optional)
    //     return redirect()->guest(route('login'));
    // }

    public function render($request, Throwable $exception)
{
    // Handle AuthorizationException
    if ($exception instanceof AuthorizationException) {
        return response()->json([
            'message' => 'This action is unauthorized.'
        ], 403);
    }

    return parent::render($request, $exception);
}
}
