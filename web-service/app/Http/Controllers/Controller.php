<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    const API_VERSION = '1.0.0';

    /**
     * Parse json_format
     *
     * @param  array $data
     * @param  string $statusCode
     * @return JsonResponse
     */
    public function json($data, int $statusCode = 200): JsonResponse
    {
        if (!is_array($data) && !is_object($data)) {
            $data = empty($data) ? [] : [$data];
        }

        if (preg_match('/^[2].{2}$/',$statusCode)) {
            $dataType = 'success';
        }elseif (preg_match('/^[4|5].{2}$/',$statusCode)) {
            $dataType = 'errors';
        }elseif (preg_match('/^[3].{2}$/',$statusCode)) {
            $dataType = 'redirect';
        }else{
            $dataType = 'information';
        }

        $dataFomat = [
            'version' => static::API_VERSION,
            'status'  => $statusCode,
            'api'     => request()->path(),
            'result'  => [
                $dataType => empty($data) ? (object) [] : $data,
            ]
        ];
        return response()->json($dataFomat, $statusCode);
    }
}
