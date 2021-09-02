<?php

namespace App\Contracts\Core\Services;

use App\Contracts\Exception\GeneralException;
use App\Contracts\Exception\ValidationRequestException;
use Exception;
use Illuminate\Http\JsonResponse;

class ApiResponseService implements ApiResponseBaseInterfaceServices
{
    public function created($data = null, $message = 'Successfully created'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'response' => $data,
            'message' => $message
        ], 201);
    }

    public function error($data = null, $message = 'Error', $status = 400, $paramError = false): JsonResponse
    {

        if ($data instanceof \Exception) {
            return response()->json([
                'status' => false,
                'response' => $this->mountErrorResponse($data),
                'message' => $data instanceof GeneralException || $data instanceof ValidationRequestException ? $data->getMessage() : $message,
                'paramError' => $data instanceof GeneralException || $data instanceof ValidationRequestException
            ],
                ($data instanceof GeneralException || $data instanceof ValidationRequestException) ? $status : 500);
        }
        return response()->json([
            'status' => false,
            'response' => $data,
            'message' => $message,
            'paramError' => $paramError
        ], $status);
    }

    public function success($data = null, $message = 'Success'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'response' => $data,
            'message' => $message
        ]);
    }

    public function mountErrorResponse(Exception $exception): array
    {
        $response = [$exception->getMessage()];
        if (env('APP_ENV') != 'production')
            array_push($response, $exception->getFile(), $exception->getLine());
        return $response;
    }
}
