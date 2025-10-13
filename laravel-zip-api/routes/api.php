<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityCountyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('counties', [CityCountyController::class, 'index']);
Route::get('counties/{countyId}', [CityCountyController::class, 'countyName']);
Route::get('counties/{countyId}/cities', [CityCountyController::class, 'show']);
Route::get('counties/{countyId}/cities/{cityId}', [CityCountyController::class, 'cityInCounty']);