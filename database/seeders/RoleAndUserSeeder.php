<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Role Admin
        $adminRole = Role::create(['name' => 'admin']);

        // Membuat Role Kasir
        $kasirRole = Role::create(['name' => 'kasir']);

        // Membuat User Admin
        User::create([
            'name' => 'Admin Valen',
            'username' => 'admin',
            'password' => Hash::make('password'), // passwordnya adalah 'password'
            'role_id' => $adminRole->id
        ]);

        // Membuat User Kasir untuk pengujian
        User::create([
            'name' => 'Kasir Valen',
            'username' => 'kasir',
            'password' => Hash::make('password'), // passwordnya juga 'password'
            'role_id' => $kasirRole->id
        ]);
    }
}
