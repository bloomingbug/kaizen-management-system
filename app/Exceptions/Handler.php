<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Psr\Log\LogLevel;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * A list of error messages
     *
     * @var array<int, string>
     */
    protected $messages = [
        500 => 'The website is currently unaivailable. Try again later or contact the developer.',
        502 => 'Bad Gateway',
        503 => 'Service unavailable',
        504 => 'Gateway Timeout',
        403 => 'You are unauthorized to see this page.',
        404 => 'The page you are looking not found.',
        405 => 'Method Not Allowed',
        419 => 'Page expired',
        422 => 'Unprocessable Content',
        429 => 'Too many requests',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if (!app()->environment(['local', 'testing'])) {
            if (!array_key_exists($response->getStatusCode(), $this->messages)) {
                return $response;
            }

            if (!$request->isMethod('GET')) {
                return back()->with('error', $this->messages[$response->getStatusCode()]);
            }

            return Inertia::render('Error/Index', ['status' => $response->getStatusCode(), 'message' => $this->messages[$response->getStatusCode()]])
                ->toResponse($request)
                ->setStatusCode($response->getStatusCode());
        } else {
            return $response;
        }
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
