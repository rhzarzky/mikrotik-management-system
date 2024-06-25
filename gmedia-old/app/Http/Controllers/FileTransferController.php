<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib3\Net\SFTP;
use Illuminate\Support\Facades\Session;

class FileTransferController extends Controller
{
    public function index()
    {
        return view('file-transfer');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'destination' => 'required|string',
        ]);

        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');

        $file = $request->file('file');
        $destination = $request->destination;

        $sftp = new SFTP($ip);
        if (!$sftp->login($user, $pass)) {
            return redirect()->route('file.transfer')->with('error', 'Failed to connect to MikroTik.');
        }

        try {
            $sftp->put($destination, file_get_contents($file->getPathname()));
            return redirect()->route('file.transfer')->with('success', 'File uploaded successfully!');
        } catch (Exception $e) {
            return redirect()->route('file.transfer')->with('error', 'Failed to upload file: ' . $e->getMessage());
        }
    }
}
