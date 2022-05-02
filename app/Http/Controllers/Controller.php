<?php

  namespace App\Http\Controllers;

  use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
  use Illuminate\Foundation\Bus\DispatchesJobs;
  use Illuminate\Foundation\Validation\ValidatesRequests;
  use Illuminate\Routing\Controller as BaseController;

  class Controller extends BaseController
  {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * success response method.
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($payload, )
    {
      $response = [
        'success' => true,
        'payload' => $payload,

      ];

      return response()->json($response, 200);
    }

    /**
     * return error response.
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 404)
    {
      $response = [
        'success' => false,
        'error' => $error,
      ];

      return response()->json($response, $code);
    }

  }
