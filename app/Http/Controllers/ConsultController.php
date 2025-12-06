<?php

namespace App\Http\Controllers;

use App\Models\Consult;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ConsultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $consults = Consult::where('user_id', Auth::id())
            ->with('location')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($consult) {
                return [
                    'id' => $consult->id,
                    'search_term' => $consult->search_term,
                    'location' => $consult->location ? [
                        'id' => $consult->location->id,
                        'cityName' => $consult->location->cityName,
                        'name' => $consult->location->name,
                        'country' => $consult->location->country,
                        'latitude' => $consult->location->latitude,
                        'longitude' => $consult->location->longitude,
                    ] : null,
                    'was_successful' => $consult->was_successful,
                    'created_at' => $consult->created_at,
                    'updated_at' => $consult->updated_at,
                ];
            });

        return response()->json([
            'data' => $consults,
            'count' => $consults->count(),
            'message' => 'Consults retrieved successfully'
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
            'location_id' => 'required|exists:locations,id',
            'search_term' => 'nullable|string|max:255',
            'was_successful' => 'boolean',
        ]);

        try {
            $consult = Consult::create([
                'user_id' => Auth::id(),
                'location_id' => $validated['location_id'],
                'search_term' => $validated['search_term'] ?? null,
                'was_successful' => $validated['was_successful'] ?? false,
            ]);

            $location = Location::find($validated['location_id']);

            return response()->json([
                'data' => $consult->load('location'),
                'message' => 'Consult created successfully',
                'location_details' => [
                    'cityName' => $location->cityName,
                    'name' => $location->name,
                    'country' => $location->country,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar consulta',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $consult = Consult::where('user_id', Auth::id())
            ->with('location')
            ->find($id);

        if (!$consult) {
            return response()->json([
                'error' => 'Consult not found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $consult->id,
                'search_term' => $consult->search_term,
                'location' => $consult->location ? [
                    'id' => $consult->location->id,
                    'cityName' => $consult->location->cityName,
                    'name' => $consult->location->name,
                    'country' => $consult->location->country,
                    'latitude' => $consult->location->latitude,
                    'longitude' => $consult->location->longitude,
                ] : null,
                'was_successful' => $consult->was_successful,
                'created_at' => $consult->created_at,
                'updated_at' => $consult->updated_at,
            ]
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
    public function destroy(string $id): JsonResponse
    {
        $consult = Consult::where('user_id', Auth::id())
            ->find($id);

        if (!$consult) {
            return response()->json([
                'error' => 'Consult not found'
            ], 404);
        }

        $consult->delete();

        return response()->json([
            'message' => 'Consult deleted successfully'
        ]);
    }
}
