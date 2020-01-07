<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exceptions\APIException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Illuminate\Http\Response;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // Log it...

        if($exception instanceof APIException){
            $exception->setTraceId("_NOT_CONFIGURED_");
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof APIException) {
            return $e->getResponse();
        } elseif ($e instanceof HttpResponseException) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'type' => 'HttpResponseException',
            ], 500);

        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);

        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());

        } elseif ($e instanceof ValidationException && $e->getResponse()) {

            return new JsonResponse([
                'message' => $e->getMessage(),
                'type' => 'ValidationException',
                'validation' => $e->errors(),
            ], 400);

        } elseif ($e instanceof Exception && $e->getMessage()) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'type' => 'Exception',
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
            ], 500);
        }

        $fe = FlattenException::create($e);

        $handler = new SymfonyExceptionHandler(env('APP_DEBUG', config('app.debug', false)));

        $decorated = $this->decorate($handler->getContent($fe), $handler->getStylesheet($fe));

        $response = new Response($decorated, $fe->getStatusCode(), $fe->getHeaders());

        $response->exception = $e;

        return $response;
    }
}
