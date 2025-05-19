<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN ACCOUNT
        User::create([
            'name' => 'Admin Account',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('asdfghjkl'), // CHANGE THIS TO A SECURE PASSWORD
            'is_admin' => true, 
            'address' => 'Admin Address',
            'phone' => '09123456789',
        ]);

        // TEST USER ACCOUNT
        User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('asdfghjkl'), // CHANGE THIS TO A SECURE PASSWORD
            'is_admin' => false,
            'address' => 'User Address',
            'phone' => '09987654321',
        ]);
    }
}
