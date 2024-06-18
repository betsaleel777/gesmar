<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileDownloadManager extends Controller
{
    public function index(Request $request): BinaryFileResponse
    {
        $destinationPath = public_path() . Str::after($request->query('path'), env('APP_URL'));
        if (File::exists($destinationPath)) {
            return response()->file(public_path() . Str::after($request->query('path'), env('APP_URL')));
        } else {
            return response()->json(['message' => 'Ce fichier n\'existe pas', 'success' => false], 404);
        }
    }
}
