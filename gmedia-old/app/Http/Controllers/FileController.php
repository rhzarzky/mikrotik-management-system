<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class FileController extends Controller
{
    //File Mikrotik
    public function file() {
    $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
    	$API = new RouterosAPI();
    	$API->debug('false');

        
    	if($API->connect($ip, $user, $pass)){
    	
            $file = $API->comm('/file/print');
            
            $data = [
                'file' => $file,
               
            ];
            //dd($data);
            return view('file', $data);
        }
      
    }


    // edit file
   public function editfile(Request $request)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {

			$API->comm('/file/set', [
                ".id" => $request['id'],
                'contents' => $request['contents']
			]);
			
			return redirect('/file');
		} else {

			return redirect('failed');
		}
	}

    	


     //delete file

	public function deletefile($id){
		$ip = session()->get('ip');
		$user = session()->get('user');
		$pass = session()->get('pass');
		$API = new RouterosAPI();
		$API->debug = false;

		if ($API->connect($ip, $user, $pass)) {
			$API->comm('/file/remove', [
				'.id' => '*' . $id
			]);
			
			return redirect('/file');
		} else {

			return redirect('failed');
		}
	}
}
