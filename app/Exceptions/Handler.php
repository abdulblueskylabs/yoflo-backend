<?php

  namespace App\Exceptions;

  use Illuminate\Auth\AuthenticationException;
  use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
  use Illuminate\Validation\ValidationException;
  use Throwable;
  use Spatie\Permission\Exceptions\UnauthorizedException;

  class Handler extends ExceptionHandler
  {
    /**
     * A list of exception types with their corresponding custom log levels.
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
      //
    ];

    /**
     * A list of the exception types that are not reported.
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
      //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array<int, string>
     */
    protected $dontFlash = [
      'current_password',
      'password',
      'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * @return void
     */
    public function register()
    {
      $this->reportable(function (Throwable $e) {
        if (app()->bound('sentry')) {
          app('sentry')->captureException($e);
        }
      });
    }

    /**
     * Convert an authentication exception into a response.
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
      return $request->expectsJson()
        ? response()->json(['success' => false, 'error' => ['message' => $exception->getMessage()]], 401)
        : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    public function render($request, Throwable $e)
    {
      // Input Validation Exception
      if ($e instanceof ValidationException) {
        //custom response
        $response = [
          'success' => false,
          'error' => $e->errors()
        ];
        return response()->json($response, 422);
      }

      if ($e instanceof UnauthorizedException) {
        $response = [
          'success' => false,
          'error' =>[ 'message'=>$e->getMessage()]
        ];
        return response()->json($response,403);
      }

      return parent::render($request, $e);
    }
  }
