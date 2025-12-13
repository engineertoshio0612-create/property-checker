<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    //
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => [
                [
                'id' => 1,
                'name' => 'サンプル物件A',
                'is_corner' => true,
                'distance_convenience_store' => 120,
                'sunlight_source' => 4,
                'notice_source' => 2.
                ],
            ],
        ]);
    }
}
