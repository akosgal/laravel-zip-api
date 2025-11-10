<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;
use App\Models\City;

class CityController extends Controller
{
    // List all cities in a county
    /**
     * @api {get} /api/counties/:county_id/cities Get all cities in a county
     * @apiName GetCities
     * @apiGroup City
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} county_id County ID
     *
     * @apiSuccess {Object} county County info
     * @apiSuccess {Object[]} cities List of cities
     * @apiSuccess {Number} cities.id City ID
     * @apiSuccess {String} cities.name City name
     */
    public function index($countyId)
    {
        $county = County::find($countyId);
        if (!$county) {
            return response()->json(['error' => 'County not found'], 404);
        }

        $cities = $county->cities()->get(['id', 'name']);

        return response()->json([
            'county' => [
                'id' => $county->id,
                'name' => $county->name,
            ],
            'cities' => $cities,
        ]);
    }

    // Show a specific city in a county
    public function show($countyId, $cityId)
    {
        $county = County::find($countyId);
        if (!$county) {
            return response()->json(['error' => 'County not found'], 404);
        }

        $city = $county->cities()->find($cityId);
        if (!$city) {
            return response()->json(['error' => 'City not found in this county'], 404);
        }

        return response()->json([
            'county' => [
                'id' => $county->id,
                'name' => $county->name,
            ],
            'city' => [
                'id' => $city->id,
                'name' => $city->name,
            ]
        ]);
    }

    // Create a city in a county
    public function store(Request $request, $countyId)
    {
        $county = County::findOrFail($countyId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = new City($validated);
        $county->cities()->save($city);

        return response()->json($city, 201);
    }

    // Update a city in a county
    public function update(Request $request, $countyId, $cityId)
    {
        $county = County::findOrFail($countyId);
        $city = $county->cities()->findOrFail($cityId);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $city->update($validated);

        return response()->json($city);
    }

    // Delete a city in a county
    public function destroy($countyId, $cityId)
    {
        $county = County::findOrFail($countyId);
        $city = $county->cities()->findOrFail($cityId);

        $city->delete();

        return response()->json(['message' => 'City deleted successfully']);
    }
}