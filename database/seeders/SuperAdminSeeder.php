<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        $role = Role::create(['name' => 'Super-admin']);
        $user = User::create(['name' => "Ahoussou Jean-Chris Arnaud", 'email' => 'shin.ahoussou@gmail.com', 'password' => Hash::make('ahoussou')]);
        $user->assignRole($role);
        $clientUser = User::create(['name' => "Admin Dev Sgmt", 'email' => 'adminDev@sgmt.net', 'password' => Hash::make('adminDev2024')]);
        $clientUser->assignRole($role);
    }
}
