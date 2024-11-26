<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // Add exception types you don't want to report
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Custom logic for reporting exceptions
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isApiRequest($request)) {
            return $this->handleApiException($exception);
        }

        return $this->handleWebException($request, $exception);
    }

    /**
     * Determine if the request is for an API endpoint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isApiRequest(Request $request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    /**
     * Handle API exceptions and return JSON responses.
     *
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleApiException(Throwable $exception): JsonResponse
    {
        $statusCode = 500;
        $error = 'Internal Server Error';
        $message = !empty($exception->getMessage()) ? $exception->getMessage() : 'An unexpected error occurred. Please try again later.';

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $statusCode = 422;
            $error = 'Validation Error';
            $message = $exception->validator->errors()->first();
        } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $statusCode = 401;
            $error = 'Unauthorized';
            $message = $exception->getMessage();
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $statusCode = 404;
            $error = 'Not Found';
            $message = 'Resource not found.';
        } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            $statusCode = 405;
            $error = 'Method Not Allowed';
            $message = 'The requested method is not allowed for this resource.';
        }

        return new JsonResponse([
            'error' => $error,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Handle web exceptions and return HTML error pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function handleWebException(Request $request, Throwable $exception): Response|RedirectResponse
    {
        // Check if the exception is an instance of AuthenticationException
        if ($exception instanceof AuthenticationException) 
        {
            $guards = $exception->guards();

            // Check the guards and decide the redirect URL
            if (in_array('vendor', $guards)) 
            {
                // Redirect to vendor login route
                return redirect()->route('vendor.login'); // Adjust to your route
            }

            // Redirect to frontend vendors route
            return redirect()->route('frontend.vendors');
        }
    
        // Handle HTTP exceptions
        if ($this->isHttpException($exception)) 
        {
            $statusCode = $exception->getStatusCode();
    
            // Customize error view based on status code
            if (view()->exists("errors.{$statusCode}")) 
            {
                return response()->view("errors.{$statusCode}", ['exception' => $exception], $statusCode);
            }
        }
    
        // Default Laravel behavior for handling other exceptions
        return parent::render($request, $exception);
    }
}
