<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->propertyService->list(),
            'message' => '物件一覧を取得しました。',
        ]);
    }
}
