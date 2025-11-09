<?php

use App\Http\Controllers\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityCountyController;
use App\Http\Controllers\CountyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('counties', [CountyController::class, 'index']);
Route::get('counties/{countyId}', [CountyController::class, 'countyName']);
Route::get('counties/{countyId}/cities', [CityController::class, 'show']);
Route::get('counties/{countyId}/cities/{cityId}', [CityController::class, 'cityInCounty']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('counties', [CountyController::class, 'createCounty']);
    Route::put('counties/{countyId}', [CountyController::class, 'updateCounty']);
    Route::delete('counties/{countyId}', [CountyController::class, 'deleteCounty']);
    Route::post('counties/{countyId}/cities', [CityController::class, 'createCity']);
    Route::put('counties/{countyId}/cities/{cityId}', [CityController::class, 'updateCity']);
    Route::delete('counties/{countyId}/cities/{cityId}', [CityController::class, 'deleteCity']);
});