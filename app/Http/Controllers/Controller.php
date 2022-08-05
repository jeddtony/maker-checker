<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function formatSuccessResponse(string $message, $data)
    {
        return response()->json(
            ['status' => true, 'message' => $message, 'data' => $data], 200);
    }

    public function formatCreatedResponse(string $message, $data)
    {
        return response()->json(
            ['status' => true, 'message' => $message, 'data' => $data], 201);
    }

    public function formatInputErrorResponse(string $message)
    {
        
        return response()->json(['status' => false, 'message' => $message], 422);
    }

    public function notFoundResponse(string $message)
    {
        return response()->json(['status' => false, 'message' => $message], 404);
    }

    public function formatDeletedResponse(string $message)
    {
        return response()->json(['status' => true, 'message' => $message], 200);
    }
}
