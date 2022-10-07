<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseData($data, int $code = 200, array $headers = [])
    {
        $dataArray = ['success' => true];

        if ($data instanceof AnonymousResourceCollection) {
            $collectionArrayResponse = json_decode($data->response()->content(), true);
            $dataArray = array_merge($dataArray, $collectionArrayResponse);
        } else {
            $dataArray['data'] = $data;
        }

        return response()->json($dataArray, $code, $headers);
    }

    public function responseMessage(string $message, int $code = 200, array $headers = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $code, $headers);
    }

    public function responseCreated()
    {
        return $this->responseMessage(__('message.created'));
    }

    public function responseUpdated()
    {
        return $this->responseMessage(__('message.updated'));
    }

    public function responseSuccess()
    {
        return $this->responseMessage(__('message.success'));
    }

    public function responseDeleted()
    {
        return $this->responseMessage(__('message.deleted'));
    }

    public function responseGranted()
    {
        return $this->responseMessage(__('message.granted'));
    }
}
