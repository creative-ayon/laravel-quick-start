<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        
        return response()->json($response, $code);
    }
    
    public function sendSuccess($success, $successMessages = [], $code = 200)
    {
    	$response = [
            'success' => true,
            'message' => $success,
        ];

        if(!empty($successMessages)){
            $response['data'] = $successMessages;
        }
        
        return response()->json($response, $code);
    }
}
