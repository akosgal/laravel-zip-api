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
}