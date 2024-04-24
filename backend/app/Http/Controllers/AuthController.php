<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $validasi = $request->validate([
            'address' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);


        if (Auth::attempt($validasi)) {
            $request->session()->regenerate();
            // dd('berhasi');

            $login = [
                'ip' => $request->address,
                'user' => $request->username,
                'pass' => $request->password
            ];

            $request->session()->put($login);

            return redirect('dashboard');
        } else {
            return back()->with('alert', 'Tidak Dapat Terhubung');
        }
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->forget('ip');
        $request->session()->forget('user');
        $request->session()->forget('pass');

        $request->session()->invalidate();

        return redirect('/');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'ip' => 'required',
    //         'user' => 'required',
    //     ]);

    //     $ip = $request->post('ip');
    //     $user = $request->post('user');
    //     $pass = $request->post('pass');

    //     $data = [
    //         'ip' => $ip,
    //         'user' => $user,
    //         'pass' => $pass,
    //     ];

    //     //dd($data);

    //     $request->session()->put($data);

    //     return redirect()->route('dashboard');
    // }
}
