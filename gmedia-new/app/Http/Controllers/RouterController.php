<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Router;

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

        return response()->json(['data' => $routers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'address' => 'required',
            'routername' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $validasi['password'] = Crypt::encryptString($validasi['password']);
        $validasi['user_id'] = Auth::id();

        try {
            Router::create($validasi);
            return response()->json(['success' => true, 'message' => 'Router berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan Router: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Router::find($id);
        $item->routername = $request->routername;
        $item->address = $request->address;
        $item->username = $request->username;

        if ($request->filled('password')) {
            try {
                $item->password = Crypt::encryptString($request->password);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal mengenkripsi password']);
            }
        }

        $item->save();
        return response()->json(['success' => true, 'message' => 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Router::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Router berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Router tidak ditemukan']);
        }
    }
}
