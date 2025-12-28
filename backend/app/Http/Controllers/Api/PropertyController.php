<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Http\Requests\PropertyIndexRequest;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index(PropertyIndexRequest $request): JsonResponse
    {
        $properties = $this->propertyService->list($request->filters());

        return response()->json([
            'data' => PropertyResource::collection($properties),
            'message' => '物件一覧を取得しました。',
        ]);
    }
}
