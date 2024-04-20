<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class PPPoEController extends Controller
{
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $secret = $API->comm('/ppp/secret/print');
            $profile = $API->comm('/ppp/profile/print');
        } else {
            return 'Koneksi Gagal';
        }

        $data = [
            'totalsecret' => count($secret),
            'secret' => $secret,
            'profile' => $profile,
        ];

        //dd($data);

        return view('pppoe.secret', $data);
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

    public function edit($id)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $getuser = $API->comm('/ppp/secret/print', [
                '?.id' => '*' . $id,
            ]);

            $secret = $API->comm('/ppp/secret/print');
            $profile = $API->comm('/ppp/profile/print');

            $data = [
                'user' => $getuser[0],
                'secret' => $secret,
                'profile' => $profile,
            ];
            //dd($getuser);
            return view('pppoe.edit', $data);
        } else {
            return 'Koneksi Gagal';
        }
    }

    public function update(Request $request)
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

        $API->connect($ip, $user, $pass);

        $API->comm('/ppp/secret/set', [
            ".id" => $request['id'],
            "name" => $request['user'] == '' ? '' : $request['user'],
            "password" => $request['password'],
            "service" => $request['service'] == '' ? '' : $request['service'],
            "profile" => $request['profile'] == '' ? '' : $request['profile'],
            "local-address" => $request['localaddress'] == '' ? '' : $request['localaddress'],
            "remote-address" => $request['remoteaddress'] == '' ? '' : $request['remoteaddress'],
            "disabled" => $request['disabled'] == '' ? '' : $request['disabled'],
            "comment" => $request['comment'] == '' ? '' : $request['comment'],
        ]);

        return redirect()->route('pppoe.secret');
    }

    public function delete($id)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {

            $API->comm('/ppp/secret/remove', [
                '.id' => '*' . $id,
            ]);

            return redirect()->route('pppoe.secret');
        } else {
            return 'Koneksi Gagal';
        }
    }
}
