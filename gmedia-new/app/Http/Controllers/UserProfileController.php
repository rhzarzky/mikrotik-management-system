<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouterosAPI;
use Symfony\Component\HttpFoundation\Response;

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
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $hotspotProfiles = $API->comm('/ip/hotspot/user/profile/print');

            return response()->json([
                'hotspotProfiles' => $hotspotProfiles,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $params = [
                'name' => $request['name'],
            ];

            if ($request->has('shared-users') && $request['shared-users'] !== 'unlimited') {
                $params['shared-users'] = $request['shared-users'];
            }

            if ($request->has('rate-limit') && $request['rate-limit'] !== 'unlimited') {
                $params['rate-limit'] = $request['rate-limit'];
            }

            $API->comm('/ip/hotspot/user/profile/add', $params);

            return response()->json([
                'message' => 'Profile created successfully',
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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

            if ($request->has('shared-users') && $request['shared-users'] !== 'unlimited') {
                $params['shared-users'] = $request['shared-users'];
            }

            if ($request->has('rate-limit') && $request['rate-limit'] !== 'unlimited') {
                $params['rate-limit'] = $request['rate-limit'];
            }

            $API->comm('/ip/hotspot/user/profile/set', $params);

            return response()->json([
                'message' => 'Profile updated successfully',
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'Failed to connect to router',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
