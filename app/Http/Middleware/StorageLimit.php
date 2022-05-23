<?php

  namespace App\Http\Middleware;

  use App\Http\Traits\ResponseTrait;
  use Closure;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class StorageLimit
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

      $user = Auth::user();
      $current_storage_count = \App\Models\File::whereBelongsTo($user)->sum('size') + bytesToMegaBytes($request->file('file')->getSize());
      $current_subscription = $user->activeSubscriptions()->first();

      if (($current_storage_count) > $current_subscription->max_storage_quantity) {
        $error = ['message' => 'Data limit exceed'];
        return $this->sendError($error);
      }
      return $next($request);
    }
  }
