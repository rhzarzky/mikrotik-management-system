<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
    	$API = new RouterosAPI();
    	$API->debug('false');

    	if($API->connect($ip, $user, $pass)){
    	
            $hotspotprofile = $API->comm('/ip/hotspot/user/profile/print');

            $data = [
                'hotspotprofile' => $hotspotprofile,
               
            ];
            // dd($data);
            return view('profil', $data);

        } else {

            return redirect('failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
    	$API = new RouterosAPI();
    	$API->debug('false');

    	if ($API->connect($ip, $user, $pass)){
    		
        $API->comm('/ip/hotspot/user/profile/add', array(
    		'name' => $request['name'],
    		'shared-users' => $request['sharedusers'],
    		'rate-limit' => $request['ratelimit'],

    		));

          // $data = [
          //   'add' => $add
          // ];

          // dd($data);

    		return redirect('/hotspot/profile')->with('success','Profile voucher berhasil dibuat');

    	}else{
    		return redirect('failed');
    	}
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if($API->connect($ip, $user, $pass)){

        $API->comm("/ip/hotspot/user/profile/set", [

                ".id" => $request['id'],
                'name' => $request['name'],
                'shared-users' => $request['sharedusers'],
                'rate-limit' => $request['ratelimit'],
            ]);

          // $data = [
          //   'update' => $update
          // ];

          // dd($data);

            return redirect('/hotspot/profile')->with('success','Profile voucher berhasil diubah');

        }else{

            return redirect('failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ip = session()->get('ip');
		$user = session()->get('user');
		$pass = session()->get('pass');
		$API = new RouterosAPI();
		$API->debug = false;

		if ($API->connect($ip, $user, $pass)) {

			$API->comm('/ip/hotspot/user/profile/remove', [
				'.id' => '*' . $id
			]);
			
			return redirect('/hotspot/profile');
		} else {

			return redirect('failed');
		}
    }
}
