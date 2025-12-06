<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all users from the database
        $users = User::with('preferences')->orderBy('created_at', 'desc')->paginate(10);

        // Return the users as a JSON response
        return response()->json($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //Return a specific user by ID
        $user->load(['preferences', 'consults']);

        // Return the user data as JSON
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //Return a specific user for editing
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //Validate the incoming data...
        $validated = $request->validate([
            'active' => 'required|boolean',
        ]);

        //Update the user with the validated data...
        $user->update([
            'active' => $validated['active'],
        ]);

        //Return the updated user as JSON...
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->only(['id', 'name', 'active'])
        ]);
    }
}
