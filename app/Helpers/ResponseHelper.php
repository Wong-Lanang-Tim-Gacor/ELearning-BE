<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    /**
     * API Response
     *
     * @var array
     */
    public static array $response = [
        'meta' => [
            'code' => null,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    /**
     * Create a JSON response.
     *
     * @param string $status
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonResponse($status = 'success', $message = 'Berhasil', $data = null, $code = 200)
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * Give success response.
     * @param mixed|null $data
     * @param mixed|null $message
     * @param int $code
     * @return JsonResponse
     */
    public static function success(mixed $data = null, string $message = null, int $code = Response::HTTP_OK): JsonResponse
    {
        self::$response['meta']['message'] = $message;
        self::$response['meta']['code'] = $code;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

}
