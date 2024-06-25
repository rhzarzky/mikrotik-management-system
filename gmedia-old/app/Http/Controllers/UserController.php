<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RouterosAPI;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    
    public function user()
    {
        $users = User::all();
        return view('user', ['datausers' => $users]);
    }

    // Add User
    public function adduser(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $validasi = $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' =>'required',
            'level' => 'required'
        ]);

        // Enkripsi kata sandi sebelum menyimpannya ke dalam basis data
        $validasi['password'] = Hash::make($validasi['password']);
        
        // Tambahkan user ke tabel pengguna
        try {
            User::create($validasi);
            return redirect('user')->with('success','User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect('user')->with('error','Gagal menambahkan user: '.$e->getMessage());
        }
    }

    // Update User
    public function ubah(Request $request, $id)
    {
        $user = User::find($id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->level = $request->level;
        $user->update();

        return redirect('/user')->with('success','Data berhasil diubah');
    }

    // Delete User
    public function deleteUser($id)
    {
        $user = user::find($id);
        $user->delete();

        return redirect('/user');
    }
}
