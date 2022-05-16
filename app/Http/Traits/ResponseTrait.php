<?php

  namespace App\Http\Traits;

  trait ResponseTrait
  {
    /**
     * success response method.
     * @return \Illuminate\Http\Response
     */
    public function sendResponse ($payload,)
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
    public function sendError ($error, $code = 404)
    {
      $response = [
        'success' => false,
        'error'   => $error,
      ];

      return response()->json($response, $code);
    }

  }


