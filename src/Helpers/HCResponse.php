<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Helpers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class HCResponse
 * @package HoneyComb\Starter\Helpers
 */
class HCResponse
{
    /**
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function success(string $message = 'OK', $data = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function error(
        string $message,
        array $errors = [],
        int $status = JsonResponse::HTTP_BAD_REQUEST
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'status' => $status,
        ], $status);
    }
}
