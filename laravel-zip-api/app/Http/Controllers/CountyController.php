<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;

class CountyController extends Controller
{
    // List all counties
    public function index()
    {
        $counties = County::all(['id', 'name']);
        return response()->json($counties);
    }

    // Get a single county by ID
    public function show($countyId)
    {
        $county = County::find($countyId);
        if (!$county) {
            return response()->json(['error' => 'County not found'], 404);
        }

        return response()->json([
            'county' => [
                'id' => $county->id,
                'name' => $county->name,
            ]
        ]);
    }

    // Create a county
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $county = County::create($validated);

        return response()->json($county, 201);
    }

    // Update a county
    public function update(Request $request, $countyId)
    {
        $county = County::findOrFail($countyId);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $county->update($validated);

        return response()->json($county);
    }

    // Delete a county
    public function destroy($countyId)
    {
        $county = County::findOrFail($countyId);
        $county->delete();

        return response()->json(['message' => 'County deleted successfully']);
    }
}