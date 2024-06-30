<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class DashboardRouterController extends Controller
{
    public function interface()
    {	
		if (!session()->has('address')) {
			return response()->json(['error' => true, 'message' => 'Address not found in session']);
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
				"once" => "",
				"traffic" => $traffic	
            ];

            return response()->json($datainterface);
        } else {
            return response()->json(['error' => true, 'message' => 'Data not found']);
			return redirect('router') -> with('alert','Tidak Dapat Terhubung');
        }
		
    }

}
