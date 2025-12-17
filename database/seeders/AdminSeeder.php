<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRole;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Tamim Amin',
            'email' => 'tamimamin@gmail.com',
            'password' => Hash::make('tamim102239'),
        ]);

        UserRole::create([
            'user_id' => $admin->id,
            'role' => 'admin',
        ]);

        echo "Admin created: tamimamin@gmail.com / tamim102239\n";
    }
}