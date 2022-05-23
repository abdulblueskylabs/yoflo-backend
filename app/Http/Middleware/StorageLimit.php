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
      $allowed_storage= $user->activeSubscriptions()->first()->max_storage_quantity;

      if (($current_storage_count) > $allowed_storage) {
        $error = ['message' => 'Data storage limit exceed'];
        return $this->sendError($error);
      }
      return $next($request);
    }
  }
