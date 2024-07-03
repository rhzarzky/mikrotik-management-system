<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserData;
use Symfony\Component\HttpFoundation\Response;

class UserDataController extends Controller
{
    /**
     * Display data user login.
     */
    public function index()
    {
        $userData = Auth::user()->load('userData');

        return response()->json([
            'success' => true,
            'message' => 'User Data List',
            'data' => $userData
        ], Response::HTTP_OK);
    }

    /**
     * Store or update data user.
     */
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

        try {
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = $photo->store('avatars');
                // Delete old photo if exists
                if ($userData->photo) {
                    Storage::delete($userData->photo); // Menghapus foto lama
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
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to save user data',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display photo user.
     */
    public function getUserPhoto()
    {
        $user = Auth::user();
        $userData = $user->userData;

        if (!$userData || !$userData->photo) {
            return response()->json([
                'error' => 'Photo not found',
            ], Response::HTTP_NOT_FOUND);
        }

        // Path absolut ke direktori storage
        $photoPath = storage_path('app/' . $userData->photo);

        try {
            // Ambil foto dari storage
            $photo = file_get_contents($photoPath);
            $photoMime = mime_content_type($photoPath);

            // Return response sebagai file gambar dengan MIME type yang sesuai
            return response($photo)->header('Content-Type', $photoMime);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve photo',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
