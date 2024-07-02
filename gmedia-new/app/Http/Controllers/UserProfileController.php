<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouterosAPI;

class UserProfileController extends Controller
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
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $hotspotProfiles = $API->comm('/ip/hotspot/user/profile/print');

            return response()->json([
                'hotspotProfiles' => $hotspotProfiles,
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], 500);
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
        $API->debug('false');
    
        if ($API->connect($ip, $user, $pass)) {
            $params = [
                'name' => $request['name'],
            ];

            if ($request->has('shared-users') !== 'unlimited' ) {
                $params['shared-users'] = $request['shared-users'];
            }
    
            if ($request['rate-limit'] !== 'unlimited') {
                $params['rate-limit'] = $request['rate-limit'];
            }
    
            $API->comm('/ip/hotspot/user/profile/add', $params);
    
            return response()->json([
                'message' => 'Profile created successfully',
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], 500);
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
            $params = [
                ".id" => $id,
                'name' => $request['name'],
            ];

            if ($request->has('shared-users') !== 'unlimited' ) {
                $params['shared-users'] = $request['shared-users'];    
            }
    
            if ($request['rate-limit'] !== 'unlimited') {
                $params['rate-limit'] = $request['rate-limit'];
            }
    
            $API->comm("/ip/hotspot/user/profile/set", $params);
    
            return response()->json([
                'message' => 'Profile updated successfully',
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], 500);
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
            $API->comm('/ip/hotspot/user/profile/remove', [
                ".id" => $id,
            ]);

            return response()->json([
                'message' => 'Profile deleted successfully',
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], 500);
        }
    }
}
