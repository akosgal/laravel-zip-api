<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;
use App\Models\City;

class CityCountyController extends Controller
{
    public function index()
    {
        $counties = County::all(['id', 'name']);

        return response()->json($counties);
    }

    public function countyName($countyId)
    {
        $county = County::find($countyId);
        if (!$county)
        {
            return response()->json(['error' => 'County not found'], 404);
        }

        return response()->json([
            'county' => [
                'id' => $county->id,
                'name' => $county->name
            ]
        ]);
    }

    public function show($countyId)
    {
        $county = County::find($countyId);
        if (!$county)
        {
            return response()->json(['error' => 'County not found'], 404);
        }

        $cities = City::where('county_id', $countyId)->get(['id', 'name']);

        return response()->json([
            'county' => [
                'id' => $county->id,
                'name' => $county->name
            ],
            'cities' => $cities
        ]);
    }

    public function cityInCounty($countyId, $cityId)
    {
        $county = County::find($countyId);
        if (!$county)
        {
            return response()->json(['error' => 'County not found'], 404);
        }

        $city = City::where('county_id', $countyId)->find($cityId);
        if (!$city)
        {
            return response()->json(['error' => 'City not found in this county'], 404);
        }

        return response()->json([
            'county' => [
                'id' => $county->id,
                'name' => $county->name
            ],
            'city' => [
                'id' => $city->id,
                'name' => $city->name
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $county = County::create($validated);

        return response()->json($county, 201);
    }

    public function destroy($countyId)
    {
        $county = County::findOrFail($countyId);
        $county->delete();

        return response()->json(['message' => 'County deleted successfully']);
    }

    public function createCity(Request $request, $countyId)
    {
        $county = County::findOrFail($countyId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $city = new City($validated);
        $county->cities()->save($city);

        return response()->json($city, 201);
    }

    public function deleteCity($countyId, $cityId)
    {
        $county = County::findOrFail($countyId);
        $city = $county->cities()->findOrFail($cityId);
        $city->delete();

        return response()->json(['message' => 'City deleted successfully']);
    }
}