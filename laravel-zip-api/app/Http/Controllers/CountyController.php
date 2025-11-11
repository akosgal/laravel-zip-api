<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;

class CountyController extends Controller
{
    // List all counties
    /**
     * @api {get} /api/counties Get all counties
     * @apiName GetCounties
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiSuccess {Number} id County ID
     * @apiSuccess {String} name County name
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * [
     *   { "id": 1, "name": "Fejér" },
     *   { "id": 2, "name": "Jász-Nagykun-Szolnok" }
     * ]
     */
    public function index(Request $request)
    {
        $query = County::select('*');

        $needle = $request->get('needle');
        if($needle) {
            $query->where('name', 'like', "%{$needle}%");
        }

        $entities = $query->orderBy('name')->get();

        return response()->json([
            'data' => [
                'counties' => $entities
            ]
        ]);
    }

    // Get a single county by ID
    /**
     * @api {get} /api/counties/:id Get county details
     * @apiName GetCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id County unique ID
     *
     * @apiSuccess {Number} id County ID
     * @apiSuccess {String} name County name
     *
     * @apiError CountyNotFound County not found
     *
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 404 Not Found
     * { "error": "County not found" }
     */
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
    /**
     * @api {post} /api/counties Create a new county
     * @apiName CreateCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiBody {String{1..255}} name County name
     *
     * @apiSuccess {Number} id County ID
     * @apiSuccess {String} name County name
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 201 Created
     * { "id": 1, "name": "Fejér" }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $county = County::create($validated);

        return response()->json($county, 201);
    }

    // Update a county
    /**
     * @api {put} /api/counties/:id Update county
     * @apiName UpdateCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id County ID
     * @apiBody {String{1..255}} name County name
     *
     * @apiSuccess {Number} id County ID
     * @apiSuccess {String} name Updated name
     */
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
    /**
     * @api {delete} /api/counties/:id Delete county
     * @apiName DeleteCounty
     * @apiGroup County
     * @apiVersion 1.0.0
     *
     * @apiParam {Number} id County ID
     *
     * @apiSuccess {String} message Success message
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * { "message": "County deleted successfully" }
     */
    public function destroy($countyId)
    {
        $county = County::findOrFail($countyId);
        $county->delete();

        return response()->json(['message' => 'County deleted successfully'], 410);
    }
}