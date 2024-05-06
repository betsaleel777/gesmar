<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileDownloadManager extends Controller
{
    public function index(Request $request): BinaryFileResponse
    {
        return response()->file(public_path() . Str::after($request->query('path'), env('APP_URL')));
    }
}
