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
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'reload' => false,
            'sections' => []
        ], $code);
    }

    protected function successWithReload($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'reload' => true,
            'sections' => []
        ], $code);
    }

    protected function successWithReloadSections($data, $message = null, $code = 200, $sections = [])
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'reload' => true,
            'sections' => $sections
        ], $code);
    }

    protected function successWithReloadSectionsInModal($data, $message = null, $code = 200, $modaltitle, $url)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'reload' => true,
            'url' => $url,
            'inmodal' => true,
            'modaltitle' => $modaltitle,
        ], $code);
    }

    protected function reloadSectionsOnly($sections = [])
    {
        return response()->json([
            'reload' => true,
            'sections' => $sections
        ], 200);
    }

    /**
     * Return error response
     *
     * @param [type] $data
     * @param [type] $message
     * @param [type] $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
