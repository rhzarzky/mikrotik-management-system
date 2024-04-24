<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $identitas = $API->comm('/system/identity/print');
            $routermodel = $API->comm('/system/routerboard/print');
        } else {
            return 'Koneksi Gagal';
        }

        $data = [
            'identitas' => $identitas[0]['name'],
            // 'routermodel' => $routermodel[0]['routerboard'],
        ];
        //dd($identitas);

        return view('dashboard', $data);
    }
}
