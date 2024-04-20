<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class BandwidthController extends Controller
{
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $queue = $API->comm('/queue/simple/print');
        } else {
            return 'Koneksi Gagal';
        }

        $data = [
            'totalqueue' => count($queue),
            'queue' => $queue,
        ];

        //dd($data);

        return view('bandwidth.queue', $data);
    }

    public function add(Request $request)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $API->comm(
                "/queue/simple/add",
                array(
                    "name" => $request['name'],
                    "target" => $request['target'],
                    "max-limit" => $request['max-limit'] == '' ? '0/0' : $request['max-limit'],
                    "comment" => $request['comment'] == '' ? '' : $request['comment'],
                )
            );
        } else {
            return 'Koneksi Gagal';
        }

        return redirect()->route('bandwidth.queue');
    }
}
