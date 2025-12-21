<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Http\Requests\PropertyIndexRequest;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index(PropertyIndexRequest $request): JsonResponse
    {
        $filters = [
            'corner' => $request->boolean('corner'),
            'min_sunlight' => $request->integer('min_sunlight') ?: null,
        ];

        $properties = $this->propertyService->list($filters);

        return response()->json([
            'data' => PropertyResource::collection($properties),
            'message' => '物件一覧を取得しました。',
        ]);
    }
}
