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
        $properties = $this->propertyService->list($request->filters()); // paginate(10)

        return PropertyResource::collection($properties)
            ->additional(['message' => '物件一覧を取得しました。'])
            ->response();
    }

    public function store(PropertyStoreRequest $request): JsonResponse
    {
        $property = $this->propertyService->create($request->payload());

        return PropertyResource::make($property)
            ->additional(['message' => '物件を作成しました。'])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Property $property): JsonResponse
    {
        return PropertyResource::make($property)
            ->additional(['message' => '物件詳細を取得しました。'])
            ->response();
    }

    public function update(PropertyUpdateRequest $request, Property $property): JsonResponse
    {
        $property = $this->propertyService->update($property, $request->payload());

        return PropertyResource::make($property)
            ->additional(['message' => '物件を更新しました。'])
            ->response();
    }

    public function destroy(Property $property): JsonResponse
    {
        $this->propertyService->delete($property);

        return response()->json([
            'message' => '物件を削除しました。',
        ], 200);
    }
}
