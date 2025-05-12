<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class Response
{
    public static function success(
        $data = [],
        $message = 'success',
        int $status = \Symfony\Component\HttpFoundation\Response::HTTP_OK
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            status: $status
        );
    }

    public static function created(
        $data = [],
        $message = 'success',
        int $status = \Symfony\Component\HttpFoundation\Response::HTTP_CREATED
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            status: $status
        );
    }

    public static function noContent(
        $data = [],
        $message = 'validation.success',
        int $status = \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            status: $status
        );
    }

    public static function error(
        $data = [],
        $message = 'validation.error',
        $status = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            success: false,
            status: $status
        );
    }

    public static function unprocessableEntity(
        array $data,
        $message = null,
        $status = \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            success: false,
            status: $status
        );
    }

    public static function unauthorized(
        $data = [],
        $message = 'validation.unauthorized',
        $status = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            success: false,
            status: $status
        );
    }

    public static function forbidden(
        $data = [],
        $message = 'validation.forbidden',
        $status = \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            success: false,
            status: $status
        );
    }

    public static function notFound(
        $data = [],
        $message = 'validation.not_found',
        $status = \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND
    ): JsonResponse
    {
        return self::response(
            data: $data,
            message: $message ? __($message) : null,
            success: false,
            status: $status
        );
    }

    public static function paginator(LengthAwarePaginator $data): JsonResponse
    {
        return response()->json([
            'data' => $data->items(),
            'paginator' => [
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'has_more' => $data->hasMorePages(),
            ],
        ]);
    }

    public static function response(
        array  $data = [],
        string $message = null,
        bool   $success = true,
        int    $status = \Symfony\Component\HttpFoundation\Response::HTTP_OK
    ): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => $success,
        ], $status);
    }
}
