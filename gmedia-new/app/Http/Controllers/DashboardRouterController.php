<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardRouterController extends Controller
{
    /**
     * Display an interface of mikrotik.
     */
    public function interface()
    {   
        if (!session()->has('address')) {
            return response()->json(['error' => true, 'message' => 'Address not found in session'], Response::HTTP_BAD_REQUEST);
        }

        $ip = session()->get('address');
        $user = session()->get('username');
        $pass = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $interface = $API->comm('/interface/print');
            $traffic = $API->comm('/interface/ethernet/print');

            $datainterface = [
                'menu' => 'Ethernet',
                'interface' => $interface,
                'traffic' => $traffic,
            ];

            return response()->json($datainterface, Response::HTTP_OK);
        } else {
            // Jika gagal terhubung ke router
            return response()->json(['error' => true, 'message' => 'Failed to connect to router'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
