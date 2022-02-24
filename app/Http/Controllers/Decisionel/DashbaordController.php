<?php

namespace App\Http\Controllers\Decisionel;

use App\Http\Controllers\Controller;

class DashbaordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $titre = "Statistiques & données";
        return view('decisionnel.dashboard', compact('titre'));
    }
}
