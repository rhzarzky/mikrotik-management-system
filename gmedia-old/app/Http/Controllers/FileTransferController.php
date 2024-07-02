<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use phpseclib3\Net\SFTP;

class FileTransferController extends Controller
{
    public function index()
    {
        return view('file-transfer');
    }

    public function uploadpage1(Request $request)
    {
        return $this->uploadpage('page1');
    }

    public function uploadpage2(Request $request)
    {
        return $this->uploadpage('page2');
    }

    private function uploadpageFiles($pageName, $sftp, $destination)
    {
        $publicPath = public_path($pageName);

        if (!is_dir($publicPath)) {
            throw new Exception("Directory $pageName not found in Laravel public directory.");
        }

        $files = scandir($publicPath);
        if ($files === false) {
            throw new Exception("Failed to list files in $pageName directory.");
        }

        $files = array_diff($files, array('.'));

        foreach ($files as $file) {
            $filePath = $publicPath . '/' . $file;
            if (is_file($filePath)) {
                $sftp->put($destination . $file, file_get_contents($filePath));
            }
        }
    }

    private function uploadpage($pageName)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');

        $destination = '/hotspot/';

        $sftp = new SFTP($ip);
        if (!$sftp->login($user, $pass)) {
            return redirect()->route('file.transfer')->with('error', 'Failed to connect to MikroTik.');
        }

        try {
            // Remove all files in the /hotspot/ directory on MikroTik
            $fileList = $sftp->nlist($destination);
            if ($fileList === false) {
                throw new Exception("Failed to list files in the hotspot directory.");
            }

            foreach ($fileList as $file) {
                if ($file !== '.' && $file !== '..') {
                    $sftp->delete($destination . $file);
                }
            }

            // Upload files from specified page directory
            $this->uploadpageFiles($pageName, $sftp, $destination);

            return redirect()->route('file.transfer')->with('success', 'Login page changed successfully!');
        } catch (Exception $e) {
            return redirect()->route('file.transfer')->with('error', 'Failed to change login page: ' . $e->getMessage());
        }
    }

}
