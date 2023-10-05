<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run():void
    {
        $user = User::create([
            'name' => "Ahoussou Jean-Chris Arnaud",'email' => 'shin.ahoussou@gmail.com','password' => Hash::make('ahoussou')
        ]);
        $role = Role::create(['name' => 'Super-admin']);
        $user->assignRole($role);
    }
}
