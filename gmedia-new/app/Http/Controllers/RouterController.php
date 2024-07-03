<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Router;
use Symfony\Component\HttpFoundation\Response;

class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;

        if ($userRole == 'admin') {
            $routers = Router::all();
        } else {
            $routers = Router::with('user:id,email')->where('user_id', $userId)->get();
        }

        return response()->json(['data' => $routers], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required',
            'routername' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $validated['password'] = Crypt::encryptString($validated['password']);
        $validated['user_id'] = Auth::id();

        try {
            Router::create($validated);
            return response()->json(['success' => true, 'message' => 'Router berhasil ditambahkan'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan Router: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $router = Router::find($id);
        if (!$router) {
            return response()->json(['success' => false, 'message' => 'Router tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }

        $router->routername = $request->input('routername');
        $router->address = $request->input('address');
        $router->username = $request->input('username');

        if ($request->filled('password')) {
            try {
                $router->password = Crypt::encryptString($request->input('password'));
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal mengenkripsi password'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $router->save();
        return response()->json(['success' => true, 'message' => 'Data berhasil diubah'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $router = Router::find($id);
        if (!$router) {
            return response()->json(['success' => false, 'message' => 'Router tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }

        try {
            $router->delete();
            return response()->json(['success' => true, 'message' => 'Router berhasil dihapus'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Router: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
