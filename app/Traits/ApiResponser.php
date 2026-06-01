<?php

namespace App\Traits;

trait ApiResponser {
    public function successResponse($data , $code , $message = null ){
        return response()->json([
            'status' => $code ,
            'message' => $message ,
            "data" => $data
        ] , $code);
    }
     public function errorResponse($data , $code , $message = null){
        return response()->json([
            'status' => 'error' ,
            'message' => $message ,
            "data" => $data
        ] , $code);
    }
}