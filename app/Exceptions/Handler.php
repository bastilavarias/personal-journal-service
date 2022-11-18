<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Auth\AuthenticationException;
use App\Exceptions\UnauthorizedException;

use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**

 * @since 2020-11-29
 *
 * Extended the render() and unauthenticated() errors to output a unified format based on ExtendedResponse
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            // return your custom response
            return customResponse()
              ->data([])
              ->message('The identifier you are querying does not exist')
              ->slug('no_query_result')
              ->failed(404404)
              ->generate();
        }

        if ($e instanceof AuthorizationException) {
            return customResponse()
              ->data([])
              ->message('You do not have right to access this resource')
              ->slug('forbidden_request')
              ->failed(403)
              ->generate();
        }

        return parent::render($request, $e);
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        return customResponse()
          ->data([])
          ->message('You do not have valid authentication token')
          ->slug('missing_bearer_token')
          ->failed(401)
          ->generate();
    }
}
