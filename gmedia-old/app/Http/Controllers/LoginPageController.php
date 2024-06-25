<?php

namespace App\Http\Controllers;

use App\Models\LoginPage;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LoginPageController extends Controller
{
    public function index()
    {
        $loginPage = LoginPage::first();
        return view('login-page', compact('loginPage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $content = $request->input('content');

        $loginPage = LoginPage::updateOrCreate(
            ['id' => 1], // Update record dengan ID 1, atau buat baru jika tidak ada
            [
                'name' => $request->name,
                'content' => $content,
            ]
        );

        // Simpan konten sebagai file .html di direktori public/hotspot
        $fileName = 'login.html';
        $filePath = public_path('hotspot/' . $fileName);
        File::put($filePath, $content);

        // Upload folder hotspot ke MikroTik
        $this->uploadFolderToMikroTik(public_path('hotspot'));

        return redirect()->route('login-page')->with('success', 'Login page saved and uploaded to MikroTik successfully!');
    }

    private function uploadFolderToMikroTik($folderPath)
    {
        $ip = session()->get('ip');
        $user = session()->get('user');
        $pass = session()->get('pass');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pass)) {
            $this->uploadDirectory($API, $folderPath, 'hotspot');
        } else {
            throw new \Exception('Failed to connect to MikroTik.');
        }
    }

    private function uploadDirectory($API, $localDirectory, $remoteDirectory)
    {
        $files = scandir($localDirectory);

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $localPath = $localDirectory . '/' . $file;
                $remotePath = $remoteDirectory . '/' . $file;

                if (is_dir($localPath)) {
                    // Buat direktori di MikroTik jika tidak ada
                    $this->createRemoteDirectory($API, $remotePath);
                    // Rekursif ke dalam direktori
                    $this->uploadDirectory($API, $localPath, $remotePath);
                } else {
                    $this->uploadFileToRouterOS($API, $remotePath, $localPath);
                }
            }
        }
    }

    private function createRemoteDirectory($API, $remoteDirectory)
    {
        $existingDir = $API->comm('/file/print', [
            '?name' => $remoteDirectory
        ]);

        if (empty($existingDir)) {
            $API->comm('/file/add', [
                'name' => $remoteDirectory,
                'type' => 'directory'
            ]);
        }
    }

    // Mengunggah file ke MikroTik
private function uploadFileToRouterOS($API, $remoteFilePath, $localFilePath)
{
    // Baca konten file lokal
    $fileContents = File::get($localFilePath);

    // Hapus file jika sudah ada
    $existingFile = $API->comm('/file/print', [
        '?name' => $remoteFilePath
    ]);

    if (!empty($existingFile) && isset($existingFile[0]['.id'])) {
        $API->comm('/file/remove', [
            '.id' => $existingFile[0]['.id']
        ]);
    }

    // Buat file baru di MikroTik
    $API->comm('/file/add', [
        'name' => $remoteFilePath
    ]);

    // Tambahkan isi file dalam potongan-potongan
    $chunks = str_split($fileContents, 4000); // Potong konten file menjadi potongan-potongan lebih kecil (misal 4000 byte)

    foreach ($chunks as $chunk) {
        $API->comm('/file/set', [
            'name' => $remoteFilePath,
            'contents' => $chunk
        ]);
    }
}

}
