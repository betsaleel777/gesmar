<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Bordereau;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BordereauController extends Controller
{
    public function all(): JsonResponse
    {
        $bordereaux = Bordereau::all();
        return response()->json(['bordereaux' => $bordereaux]);
    }
}
