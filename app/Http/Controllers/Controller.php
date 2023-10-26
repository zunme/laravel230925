<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
	
	protected function success($data=[], $message = null, $code = 200)
    {
      return response()
        ->json([
        'status' => 'Success',
        'message' => $message,
        'data' => $data
      ], $code,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
    }
    protected function error($message, $code = 422, $data = null)
    {
      return response()->json([
        'status' => 'Error',
        'message' => $message,
        'data' => $data,
      ], $code,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
    }
}
