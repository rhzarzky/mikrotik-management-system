<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class HotspotController extends Controller
{
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $hotspotuser = $API->comm('/ip/hotspot/user/print');
            $server = $API->comm('/ip/hotspot/print');
            $profile = $API->comm('/ip/hotspot/user/profile/print');
        } else {
            return 'Koneksi Gagal';
        }

        $data = [
            'totalhotspotuser' => count($hotspotuser),
            'hotspotuser' => $hotspotuser,
            'server' => $server,
            'profile' => $profile,
        ];

        //dd($data);

        return view('hotspot.user', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required',
        ]);

        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $API->comm("/ppp/secret/add", [
                "name" => $request['user'],
                "password" => $request['password'],
                "service" => $request['service'] == '' ? 'any' : $request['service'],
                "profile" => $request['profile'] == '' ? 'default' : $request['profile'],
                "local-address" => $request['local-address'] == '' ? '0.0.0.0' : $request['local-address'],
                "remote-address" => $request['remote-address'] == '' ? '0.0.0.0' : $request['remote-address'],
                "comment" => $request['comment'] == '' ? '' : $request['comment'],
            ]);
        } else {
            return 'Koneksi Gagal';
        }

        return redirect()->route('pppoe.secret');
    }
}
