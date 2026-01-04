<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Resources\PropertyResource;
use App\Http\Requests\PropertyIndexRequest;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
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

    public function store(PropertyStoreRequest $request): JsonResponse
    {
        $property = $this->propertyService->create($request->payload());

        return response()->json([
            'data' => PropertyResource::make($property),
            'message' => '物件を作成しました。',
        ], 201);
    }

    public function update(PropertyUpdateRequest $request, Property $property): JsonResponse
    {
        $property = $this->propertyService->update($property, $request->payload());

        return response()->json([
            'data' => PropertyResource::make($property),
            'message' => '物件を更新しました。',
        ]);
    }
}
