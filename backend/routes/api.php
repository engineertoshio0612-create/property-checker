<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthCheckController;
use App\Http\Controllers\Api\PropertyController;

Route::get('/health', HealthCheckController::class);
Route::apiResource('properties', PropertyController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

