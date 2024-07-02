<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserData;
use App\Models\User;

class UserDataController extends Controller
{
    public function index()
    {
        $userData = Auth::user()->load('userData');

        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data' => $userData
        ], 200);
    }

    public function storeOrUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);        

        $userData = $user->userData ?? new UserData;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('avatars');
            // Delete old photo if exists
            if ($userData->photo) {
                Storage::disk('public')->delete($userData->photo);
            }
            $userData->photo = $photoPath;
        }

        $userData->user_id = $user->id;
        $userData->firstname = $request->input('firstname');
        $userData->lastname = $request->input('lastname');
        $userData->organization = $request->input('organization');
        $userData->address = $request->input('address');
        $userData->save();

        return response()->json([
            'success' => true,
            'message' => 'User data saved successfully',
            'data' => $userData,
        ]);
    }
}
