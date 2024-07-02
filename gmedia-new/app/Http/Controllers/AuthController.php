<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;
use App\Models\Router;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function index(Request $request)
    {
        dd($request->session()->all());    }

    /**
     * Login user.
     */
    public function loginUser(Request $request)
    {
        try {
            $validasi = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            if (Auth::attempt($validasi)) {
                // Load userData
                $user = Auth::user()->load('userData');
    
                // Store the user object in the session
                $request->session()->put('user', $user);
    
                $request->session()->regenerate();
                return response()->json(['success' => true]);
            }
    
            return response()->json(['success' => false, 'error' => 'Invalid credentials. Please try again.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }    
    

    /**
     * Login Mikrotik.
     */
    public function loginRouter(Request $request)
    {
        $validasi = $request->validate([
            'address' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
        ]);
    
        $ip = $request->post('address');
        $user = $request->post('username');
        $pass = $request->post('password');
    
        $router = Router::where('address', $ip)->where('username', $user)->first();
        if ($router) {
            try {
                
                $decryptedPassword = Crypt::decryptString($router->password);
    
                $request->session()->put('id', $router->id);
                $request->session()->put('address', $router->address);
                $request->session()->put('username', $router->username);
                $request->session()->put('password', $decryptedPassword);
    
                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => 'Gagal mendekripsi password']);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'Router tidak ditemukan']);
        }
    }

    /**
     * Log out all.
     */
    public function logout(Request $request)
    {
        Auth::logout();
  
        $request->session()->forget('address');
        $request->session()->forget('username');
        $request->session()->forget('password');
        $request->session()->invalidate();
  
        return response()->json(['success' => true]);
    }

    /**
     * Log out router.
     */
    public function logoutRouter(Request $request)
    {
  
        $request->session()->forget('address');
        $request->session()->forget('username');
        $request->session()->forget('password');
  
        return response()->json(['success' => true]);
    }
}
