<?php

namespace App\Traits;

trait HttpResponses
{
    /**
     * Return success response
     *
     * @param [type] $data
     * @param [type] $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, $message = null, $code = 200, $reload = false)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'reload' => $reload
        ], $code);
    }

    /**
     * Return error response
     *
     * @param [type] $data
     * @param [type] $message
     * @param [type] $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($data, $message = null, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
