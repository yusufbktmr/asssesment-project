<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context(): array
    {
        return [
            'url' => request()->fullUrl(),
            'parameters' => request()->all(),
            'headers' => collect(request()->headers)->only(
                [
                    'operation-id',
                    'request-id',
                    'user-agent',
                    'x-client-ip',
                    'x-real-ip',
                    'referer',
                    'accept',
                    'referer-ip',
                    'sync-user-agent'
                ])->toArray(),
        ];
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Log or perform actions for reported exceptions here if needed.
        });

        $this->levels = config('log.levels');
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|
     */
    public function render($request, Throwable $e)
    {
        $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR; // Default to 500 Internal Server Error
        $message = 'An unexpected error occurred.';
        $errors = [];

        switch (true) {
            case ($e instanceof ModelNotFoundException):
                $key = key($request->route()->parameters());
                $message = __('message.not_found.model', ['model' => __('model.' . $key)]);
                $code = ResponseAlias::HTTP_NOT_FOUND;
                break;

            case ($e instanceof NotFoundHttpException):
                $message = __('message.not_found.url');
                $code = ResponseAlias::HTTP_NOT_FOUND;
                break;

            case ($e instanceof ValidationException):
                $message = __('message.failed.validation');
                $code = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
                $errors = $e->validator->errors()->toArray();
                break;

            default:
                // Log unexpected exceptions
                report($e);
                $message = $e->getMessage();
                $code = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }

        // Example JSON response (replace with your custom response handler if needed)
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
