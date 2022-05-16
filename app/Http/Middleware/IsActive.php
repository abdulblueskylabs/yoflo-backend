<?php

  namespace App\Http\Middleware;

  use App\Http\Traits\ResponseTrait;
  use Closure;
  use Illuminate\Http\Request;
  use Sentry\Laravel\Tracing\Middleware;

  class IsActive
  {
    use ResponseTrait;
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle (Request $request, Closure $next)
    {
      // Check whether user is active
      if (auth()->user()->is_active == 0) {
        $error=['message'=>'User is not active'];
        return $this->sendError($error);
      }
      return $next($request);

    }
  }
