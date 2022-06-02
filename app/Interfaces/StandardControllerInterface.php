<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface StandardControllerInterface
{
    public function all();
    public function store(Request $request);
    public function update(int $id, Request $request);
    public function trash(int $id);
    public function restore(int $id);
    public function trashed();
    public function show(int $id);
}
