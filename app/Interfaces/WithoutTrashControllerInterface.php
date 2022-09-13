<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface WithoutTrashControllerInterface
{
    public function all(): JsonResponse;

    public function store(Request $request): JsonResponse;

    public function update(int $id, Request $request): JsonResponse;

    public function show(int $id): JsonResponse;
}
