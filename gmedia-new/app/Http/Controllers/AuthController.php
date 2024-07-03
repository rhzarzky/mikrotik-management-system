<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Router;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function index(Request $request)
    {
        dd($request->session()->all());
    }

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
                return response()->json(['success' => true], Response::HTTP_OK);
            }

            return response()->json(['success' => false, 'error' => 'Invalid credentials. Please try again.'], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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

                return response()->json(['success' => true], Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => 'Gagal mendekripsi password'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'Router tidak ditemukan'], Response::HTTP_NOT_FOUND);
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

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Log out router.
     */
    public function logoutRouter(Request $request)
    {
        $request->session()->forget('address');
        $request->session()->forget('username');
        $request->session()->forget('password');

        return response()->json(['success' => true], Response::HTTP_OK);
    }

    /**
     * Get user data.
     */
    public function getUserData()
    {
        $user = auth()->user();

        $firstname = $user->userData ? $user->userData->firstname : $user->username;
        $lastname = $user->userData ? $user->userData->lastname : null;
        $organization = $user->userData ? $user->userData->organization : null;
        $address = $user->userData ? $user->userData->address : null;
        $photo = $user->userData ? $user->userData->photo : null;

        return response()->json([
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'user_data' => [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'organization' => $organization,
                'address' => $address,
                'photo' => $photo
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Get router data.
     */
    public function getRouterData(Request $request)
    {
        return response()->json([
            'id' => session('id'),
            'address' => session('address'),
            'username' => session('username'),
            'password' => session('password'),
        ], Response::HTTP_OK);
    }
}
