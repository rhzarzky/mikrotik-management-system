<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\RouterosAPI;
use App\Models\Router;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

class RouterController extends Controller
{
    public function router(){

        session()->forget(['ip', 'user', 'pass']);
        $userId = Auth::id();
    
        $userLevel = Auth::user()->role;
    
        if ($userLevel == 'admin') {

            $routers = Router::all();
        } else {
            //ambil daftar router yang terkait dengan pengguna yang login
            $routers = Router::with('user:id,email')->where('user_id', $userId)->get();    
        }
    
        return view('router', ['datausers' => $routers]);    
    }


    public function addrouter(Request $request) {
        $validasi = $request->validate([
            'address' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        // Enkripsi password sebelum disimpan
        $validasi['password'] = Crypt::encryptString($validasi['password']);

        $userId = Auth::id();

        $validasi['user_id'] = $userId;
    
        try {
            router::create($validasi);
            return redirect('router')->with('success', 'Router berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect('router')->with('error', 'Gagal menambahkan Router: ' . $e->getMessage());
        }
    }

    //Update
    public function ubah(Request $request, $id)
    {
        $item = router::find($id);
        $item->name = $request->name;
        $item->address = $request->address;
        $item->username = $request->username;

        if ($request->filled('password')) {
            try {
                
                $item->password = Crypt::encryptString($request->password);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return redirect()->back()->with('error', 'Gagal mendekripsi password');
            }
        }

        $item->save();

        return redirect('/router')->with('success', 'Data berhasil diubah');
    }

    //delete
    public function deleteRouter($id){
        $item = router::find($id);
        $item->delete();

        return redirect('/router');
    }
}