<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index(Request $request): JsonResponse
    {
        $onlyCorner = $request->boolean('corner');

        return response()->json([
            'data' => $this->propertyService->list($onlyCorner),
            'message' => '物件一覧を取得しました。',
        ]);
    }
}
