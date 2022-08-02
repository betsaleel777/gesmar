<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface StandardControllerInterface
{
    public function all(): JsonResponse;

    public function store(Request $request): JsonResponse;

    public function update(int $id, Request $request): JsonResponse;

    public function trash(int $id): JsonResponse;

    public function restore(int $id): JsonResponse;

    public function trashed(): JsonResponse;

    public function show(int $id): JsonResponse;
}
