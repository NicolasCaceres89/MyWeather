<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('location')
            ->get();

        return response()->json([
            'data' => $favorites,
            'message' => 'Favorites retrieved successfully'
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
        ]);

        try {
            $favorite = Favorite::firstOrCreate([
                'user_id' => Auth::id(),
                'location_id' => $validated['location_id'],
            ]);

            $location = Location::find($validated['location_id']);

            return response()->json([
                'data' => $favorite->load('location'),
                'message' => 'Favorite location added successfully',
                'location_name' => $location->cityName ?? $location->name,
                'coordinates' => [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar favorito',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->find($id);

        if (!$favorite) {
            return response()->json([
                'error' => 'Favorite not found'
            ], 404);
        }

        return response()->json([
            'data' => $favorite->load('location')
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
        $favorite = Favorite::where('user_id', Auth::id())
            ->find($id);

        if (!$favorite) {
            return response()->json([
                'error' => 'Favorite not found'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Favorite location removed successfully'
        ]);
    }
}
