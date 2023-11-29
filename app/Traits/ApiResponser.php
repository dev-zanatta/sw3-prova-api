<?php

namespace App\Traits;


trait ApiResponser
{

  protected function successResponse($result = null, $code = 200, $message = null)
  {

    $response = [
      'success' => true,
    ];

    if (\is_iterable($result)) {
      $response['amount'] = \sizeof($result);
    }

    if ($result) {
      $response['result'] = $result;
    }

    if ($message) {
      $response['message'] = $message;
    }

    return response()->json($response, $code);
  }

  protected function errorResponse($message = null, $code, $result = null)
  {
    $response = [
      'success' => false,
      'message' => $message,
    ];

    if ($result) {
      $response['result'] = $result;
    }

    return response()->json($response, $code);
  }
}
