<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
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
    
    
    public function editfile(Request $request) {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;
    
        if ($API->connect($ip, $user, $pass)) {
            $API->comm('/file/set', [
                'numbers' => $request->input('id'),
                'contents' => $request->input('contents')
            ]);
    
            return redirect('/file');
        } else {
            return redirect('failed');
        }
    }    
    
    public function deletefile($number) {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;
    
        if ($API->connect($ip, $user, $pass)) {
            $API->comm('/file/remove', [
                'numbers' => $number
            ]);
    
            return redirect('/file');
        } else {
            return redirect('failed');
        }
    }
    
        public function downloadFile()
    {
        $filePath = public_path('hotspot/login.html');
        return response()->download($filePath, 'login.html');
    }

}
