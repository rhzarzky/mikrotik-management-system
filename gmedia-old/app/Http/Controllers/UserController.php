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
        // Validasi data
        $validasi = $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' =>'required',
            'role' => 'required'
        ]);

        // Enkripsi kata sandi sebelum menyimpannya ke dalam basis data
        $validasi['password'] = Hash::make($validasi['password']);
        
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
    
    $validasi = $request->validate([
        'email' => 'required',
        'name' => 'required',
        'password' => 'nullable',
        'role' => 'required'
    ]);
    
    $user->email = $validasi['email'];
    $user->name = $validasi['name'];
    $user->role = $validasi['role'];
    
    // Check if password is provided, then hash and update it
    if (!empty($validasi['password'])) {
        $user->password = Hash::make($validasi['password']);
    }

    try {
        $user->save();
        return redirect('/user')->with('success', 'Data berhasil diubah');
    } catch (\Exception $e) {
        return redirect('/user')->with('error', 'Gagal mengubah data user: '.$e->getMessage());
    }
}

    // Delete User
    public function deleteUser($id)
    {
        $user = user::find($id);
        $user->delete();

        return redirect('/user');
    }
}
