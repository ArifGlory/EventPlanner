<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{

    /**
     * @param int $code
     * @param bool $status
     * @param string $message
     * @param array $data
     * @param array $additional
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseApi(int $code = 200, bool $status = true, string $message = 'Berhasil', array $data = [], array $additional = [])
    {
        return response()->json(array_merge([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $additional), $code);
    }
}
