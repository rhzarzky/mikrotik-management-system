<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RouterosAPI;
use Symfony\Component\HttpFoundation\Response;

class UserHotspotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $hotspotuser = $API->comm('/ip/hotspot/user/print');
            $profile = $API->comm('/ip/hotspot/user/profile/print');

            $data = [
                'hotspotuser' => $hotspotuser,
                'profile' => $profile,
            ];
           
            return response()->json(['data' => $data], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;
    
        if ($API->connect($ip, $user, $pass)) {
            $timelimit = $request['limit-uptime'] ?: '0';
    
            $API->comm('/ip/hotspot/user/add', [
                'name' => $request['name'],
                'password' => $request['password'],
                'profile' => $request['profile'],
                'limit-uptime' => $timelimit,
                'disabled' => 'false',
            ]);
    
            return response()->json(['message' => 'User created successfully'], Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }    

    /**
     * Display a listing of active hotspot users.
     */
    public function active()
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $active = $API->comm('/ip/hotspot/active/print');

            return response()->json(['data' => $active], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $API->comm('/ip/hotspot/user/set', [
                '.id' => $id,
                'name' => $request['name'],
                'password' => $request['password'],
                'profile' => $request['profile'],
                'limit-uptime' => $request['limit-uptime'],
            ]);

            return response()->json(['message' => 'User updated successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }

        /**
     * Update the specified resource in storage.
     */
    public function activation(Request $request, string $id)
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $API->comm('/ip/hotspot/user/set', [
                '.id' => $id,
                'disabled' => $request['disabled'],
            ]);

            return response()->json(['message' => 'User updated successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $API->comm('/ip/hotspot/user/remove', ['.id' => $id]);

            return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Generate multiple vouchers.
     */
    public function voucher(Request $request)
    {
        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $timelimit = $request['timelimit'] ?: '0';

            for ($i = 0; $i < $request['jum']; $i++) {
                $API->comm('/ip/hotspot/user/add', [
                    'name' => Str::random(4),
                    'password' => Str::random(4),
                    'profile' => $request['profile'],
                    'limit-uptime' => $timelimit,
                    'disabled' => $request['disabled'],
                ]);
            }

            return response()->json(['message' => 'Vouchers generated successfully'], Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => 'Failed to connect to RouterOS'], Response::HTTP_BAD_REQUEST);
        }
    }
}
