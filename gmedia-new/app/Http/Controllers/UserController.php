<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;

        if ($userRole == 'admin') {
        $users = User::with('userData')->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data' => $users
        ], 200);
        } else {
        }
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
    public function store(Request $request)
    {
    // Validasi data yang diterima dari formulir
    $validated = $request->validate([
        'email' => 'required',
        'username' => 'required',
        'password' =>'required',
        'role' => 'required'
    ]);
    $validated['password'] = Hash::make($validated['password']);
    // Tambahkan user ke tabel pengguna
    try {
        User::create($validated);
        return response()->json(['message' => 'User successfully created', 'user' => $user], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to create user', 'error' => $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $user = User::find($id);
        if ($user) {
            $user->email = $request->email;
            $user->username = $request->username; // Use 'username' instead of 'name'
            $user->role = $request->role; // Use 'role' instead of 'level'
            $user->save(); // Use save() instead of update()

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ], 404);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password changed successfully']);
    }
}
