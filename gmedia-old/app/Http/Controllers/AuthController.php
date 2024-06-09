<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Router;
use Illuminate\Routing\Route;

class AuthController extends Controller
{
   public function index() {
   		return view('auth.login');
   }


   //login website
   public function login(Request $request)
   {
       $validasi = $request->validate([
           'email' => ['required', 'email'],
           'password' => ['required'],
       ]);
   

       if (Auth::attempt($validasi)) {
            return redirect('router')->with('success','Berhasil login');
       }
   
       // Jika autentikasi gagal, arahkan kembali ke halaman login
       return redirect('login')->with('alert', 'Authentication failed. Please try again.');
   }
    

   //login mikrotik
    public function loginAuth(Request $request)
    {
        $request->validate([
            'ip' => 'required',
            'user' => 'required',
            'password' => 'required',
        ]);

        $ip = $request->post('ip');
        $user = $request->post('user');
        $pass = $request->post('password');

        // Ambil data router berdasarkan IP dan username
        $router = Router::where('address', $ip)->where('username', $user)->first();

        if ($router) {
            try {
                // Dekripsi password yang tersimpan di database
                $decryptedPassword = Crypt::decryptString($router->password);

                // Simpan data dalam session
                $request->session()->put('ip', $ip);
                $request->session()->put('user', $user);
                $request->session()->put('pass', $decryptedPassword);

                // Redirect ke dashboard
                return redirect('dashboard')->with('success', 'Login berhasil');
            } catch (\Exception $e) {
                // Handle dekripsi yang gagal
                return redirect()->back()->with('error', 'Gagal mendekripsi password');
            }
        } else {
            // Router tidak ditemukan
            return redirect()->back()->with('error', 'Router tidak ditemukan');
        }
    }

//    public function loginAuth(Request $request)
//    {
//        $request->validate([
//            'ip' => 'required',
//            'user' => 'required',
//            'password' => 'required', // tambahkan validasi password
//        ]);
   
//        $ip = $request->post('ip');
//        $user = $request->post('user');
//        $pass = $request->post('password');
   
//        // Simpan data dalam session
//        $request->session()->put('ip', $ip);
//        $request->session()->put('user', $user);
//        $request->session()->put('pass', $pass);
   
//        return redirect('dashboard');
//    }
   

   public function logout(Request $request) {

      Auth::logout();

   		$request->session()->forget('ip');
   		$request->session()->forget('user');
   		$request->session()->forget('pass');
        $request->session()->invalidate();

   		return redirect('/login');
   }

}
