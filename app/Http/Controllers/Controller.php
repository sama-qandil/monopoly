<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    /**
     * Return a success JSON response.
     */
    protected function success(
        mixed $data = null,
        ?string $message = null,
        int $statusCode = Response::HTTP_OK,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => true,
            'message' => $message ?? 'Operation completed successfully',
        ];

        if (! is_null($data)) {
            // Handle pagination automatically
            if ($data instanceof AnonymousResourceCollection) {
                $response['data'] = $data->collection;
                if ($data->resource instanceof LengthAwarePaginator) {
                    $response['pagination'] = $this->paginationMeta($data->resource);
                }
            } elseif ($data instanceof LengthAwarePaginator) {
                $response['data'] = $data->items();
                $response['pagination'] = $this->paginationMeta($data);
            } else {
                $response['data'] = $data;
            }
        }

        if (! empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return an error JSON response.
     */
    protected function error(
        ?string $message = null,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        mixed $errors = null,
        array $meta = []
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message ?? 'An error occurred',
        ];

        if (! is_null($errors)) {
            $response['errors'] = $errors;
        }

        if (! empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a created resource response.
     */
    protected function created(
        mixed $data = null,
        ?string $message = null
    ): JsonResponse {
        return $this->success(
            $data,
            $message ?? 'Resource created successfully',
            Response::HTTP_CREATED
        );
    }

    /**
     * Return a no content response.
     */
    protected function noContent(?string $message = null): JsonResponse
    {
        return $this->success(
            null,
            $message ?? 'Operation completed successfully',
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * Return a not found response.
     */
    protected function notFound(?string $message = null): JsonResponse
    {
        return $this->error(
            $message ?? 'Resource not found',
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Return an unauthorized response.
     */
    protected function unauthorized(?string $message = null): JsonResponse
    {
        return $this->error(
            $message ?? 'Unauthorized access',
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Return a forbidden response.
     */
    protected function forbidden(?string $message = null): JsonResponse
    {
        return $this->error(
            $message ?? 'Access forbidden',
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * Return a validation error response.
     */
    protected function validationError(
        mixed $errors,
        ?string $message = null
    ): JsonResponse {
        return $this->error(
            $message ?? 'Validation failed',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $errors
        );
    }

    /**
     * Return a server error response.
     */
    protected function serverError(?string $message = null): JsonResponse
    {
        return $this->error(
            $message ?? 'Internal server error',
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Handle a result array (for backward compatibility or service layer responses).
     */
    protected function result(array $result): JsonResponse
    {
        $success = $result['success'] ?? false;
        $data = $result['data'] ?? null;
        $message = $result['message'] ?? null;
        $statusCode = $result['status'] ?? $result['status_code'] ?? ($success ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        $errors = $result['errors'] ?? null;
        $meta = $result['meta'] ?? [];

        return $success
            ? $this->success($data, $message, $statusCode, $meta)
            : $this->error($message, $statusCode, $errors, $meta);
    }

    /**
     * Generate pagination metadata from a LengthAwarePaginator instance.
     */
    protected function paginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'total' => $paginator->total(),
            'count' => $paginator->count(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'total_pages' => $paginator->lastPage(),
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ];
    }

    /**
     * Return a paginated response.
     */
    protected function paginated(
        LengthAwarePaginator $paginator,
        ?string $message = null
    ): JsonResponse {
        return $this->success($paginator, $message);
    }
}
