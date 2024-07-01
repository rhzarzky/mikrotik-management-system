<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use phpseclib3\Net\SFTP;

class UploadController extends Controller
{
    public function index()
    {
        return view('uploadmanual');
    }

    public function uploadManual(Request $request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'file',
        ]);

        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');

        $files = $request->file('files');
        $destination = '/hotspot/';

        $sftp = new SFTP($ip);
        if (!$sftp->login($user, $pass)) {
            return redirect()->route('file.transfer')->with('error', 'Failed to connect to MikroTik.');
        }

        try {
            // List and delete all files in the /hotspot/ directory
            $fileList = $sftp->nlist($destination);
            if ($fileList === false) {
                throw new Exception("Failed to list files in the hotspot directory.");
            }

            foreach ($fileList as $file) {
                if ($file != '.' && $file != '..') {
                    $sftp->delete($destination . $file);
                }
            }

            // Upload new files
            foreach ($files as $file) {
                $relativePath = $file->getClientOriginalName();
                $sftp->put($destination . $relativePath, file_get_contents($file->getPathname()));
            }

            return redirect()->route('upload')->with('success', 'Files uploaded successfully!');
        } catch (Exception $e) {
            return redirect()->route('upload')->with('error', 'Failed to upload files: ' . $e->getMessage());
        }
    }
}