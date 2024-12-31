<?php

namespace App\Traits;

trait ResponseTrait
{
    public static function dataSuccess($data,$message)
    {
        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ], 200);
    }
    public static function dataFailed($message)
    {
        return response()->json([
            "status" => false,
            "message" => $message,
        ],401);
    }
}
