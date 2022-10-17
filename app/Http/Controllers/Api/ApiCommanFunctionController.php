<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ApiCommanFunctionController extends Controller
{   

    /**
     * [sendResponse This function is used to send api response data]
     * @param  [type] $status  [description]
     * @param  [type] $result  [description]
     * @param  [type] $message [description]
     * @return [type]          [description]
     * @author Chirag
     */
    public function sendResponse($status,$result, $message)
    {
    	$response = [
            'status' => $status,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * [sendError This function is used for send error message during api call]
     * @param  [type]  $error         [description]
     * @param  array   $errorMessages [description]
     * @param  integer $code          [description]
     * @return [type]                 [description]
     * @author Chirag
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => $code,
            'message' => $error,
            'data' => (object)[]
        ];
        if(!empty($errorMessages)){
            $response['data'] = $error;
        }
        return response()->json($response, $code);
    }
}