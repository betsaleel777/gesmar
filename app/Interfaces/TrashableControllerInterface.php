<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface TrashableControllerInterface
{
    public function trash(int $id): JsonResponse;

    public function restore(int $id): JsonResponse;

    public function trashed(): JsonResponse;
}
