<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $locations = Location::all();

        return response()->json([
            'data' => $locations,
            'count' => $locations->count(),
            'message' => 'Locations retrieved successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cityName' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        try {
            $location = Location::firstOrCreate(
                ['latitude' => $validated['latitude'], 'longitude' => $validated['longitude']],
                [
                    'cityName' => $validated['cityName'],
                    'name' => $validated['name'] ?? $validated['cityName'],
                    'country' => $validated['country'] ?? null,
                ]
            );

            return response()->json([
                'data' => $location,
                'message' => 'Location created or retrieved successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar location',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'error' => 'Location not found'
            ], 404);
        }

        return response()->json([
            'data' => $location
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
