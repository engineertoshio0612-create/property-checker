<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dusk/properties', function () {
    $res = Http::get(url('/api/properties'), ['corner' => 1]);
    $json = $res->json();

    $count = is_array($json['data'] ?? null) ? count($json['data']) : 0;

    return "corner_count={$count}";
});