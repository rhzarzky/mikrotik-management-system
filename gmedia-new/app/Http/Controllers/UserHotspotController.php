<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RouterosAPI;
use App\Models\User;


class UserHotspotController extends Controller
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
    	
        $hotspotuser = $API->comm('/ip/hotspot/user/print');
        $profile = $API->comm('/ip/hotspot/user/profile/print');

        //User berdasrkan ID
            $item = user::all();

            foreach ($item as $item1) {
                if ($item1->username == auth()->user()->username) {
                    $item1->id;
             
                    $data = [
                        'hotspotuser' => $hotspotuser,
                        'profile' => $profile,
                        'item1' => $item1->id,
                    ];
                }
                
            }
           
            return view('voucher', $data, ['datausers' => $item]);

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

         //User berdasarkan ID
            $item = user::all();
            
            foreach ($item as $item1) {
                if ($item1->username == auth()->user()->username) {
                    $item1->id;
              

    	//timelimit
    		if ($request['timelimit'] == '') {
    			$timelimit = '0';
    		}else{
    			$timelimit = $request['timelimit'];
    		}

    		$API->comm('/ip/hotspot/user/add', array(
        		'name' => $request['user'],
        		'password' => $request['password'],
        		'profile' => $request['profile'],
        		'limit-uptime' => $timelimit,
                'comment' => $item1->id,
                'disabled' => $request['disabled'],
    		));

                 }
               
            }

            //dd($data);

    		return redirect('/hotspot/voucher')->with('success','Voucher berhasil dibuat');

    	}else{
    		return redirect('failed');
    	}
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function active()
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {

    	    $active = $API->comm('/ip/hotspot/active/print');

            $data = [
                // 'totalhotspotactive' => count($hotspotactive),
                'hotspotactive' => $active,
                // 'time' => $active['session-time-left'],
            ];

            // dd($data);
            
            return view('active', $data);

        } else {

            return redirect('failed');
        }
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

             //User berdasrkan ID
                $item = user::all();
                
                foreach ($item as $item1) {
                    if ($item1->username == auth()->user()->username) {
                    $item1->id;

            $API->comm("/ip/hotspot/user/set", [
                ".id" => $request['id'],
                'name' => $request['user'],
                'password' => $request['password'],
                'profile' => $request['profile'],
                'limit-uptime' => $request['timelimit'],
                'disabled' => $request['disabled'] == '' ? $request['disabled'] : $request['disabled'],
                'comment' => $item1->id,
            ]);
        }
    }

          // dd($data);

            return redirect('/hotspot/voucher')->with('success','Voucher berhasil diubah');

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

			$API->comm('/ip/hotspot/user/remove', [
				'.id' => '*' . $id,
			]);

			
			return redirect('/hotspot/voucher');
		} else {

			return redirect('failed');
		}
    }

    public function voucher(Request $request){
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)){


        //timelimit
            if ($request['timelimit'] == '') {
                $timelimit = '0';
            }else{
                $timelimit = $request['timelimit'];
            }

        //User berdasrkan ID
            $item = user::all();
            
            foreach ($item as $item1) {
                if ($item1->username == auth()->user()->username) {
                $item1->id;

            for ($id=0; $id < $request['jum'] ; $id++) { 
           
            $API->comm('/ip/hotspot/user/add', array(
                'name' => Str::random(4),
                'password' => Str::random(4),
                'profile' => $request['profile'],
                'limit-uptime' => $timelimit,
                'comment' => $item1->id,
                'disabled' => $request['disabled'],
                ));
              }
           }
       }
              // dd($data);

            return redirect('/hotspot/voucher')->with('success','Generate Voucher berhasil');

        }else{
            return redirect('failed');
        }
    }
}
