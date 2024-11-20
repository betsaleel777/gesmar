<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

interface AutreFactureInterface
{
    public function all(Request $request): JsonResource;
    public function getPaginate(Request $request): JsonResource;
    public function getSearch(Request $request): JsonResource;
    public function show(Request $request): JsonResource;
}
