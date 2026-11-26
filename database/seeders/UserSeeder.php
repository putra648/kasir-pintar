<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kasirpintar.test'],
            [
                'name' => 'Admin',
                'role' => User::ROLE_ADMIN,
                'password' => 'password123',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@kasirpintar.test'],
            [
                'name' => 'Kasir',
                'role' => User::ROLE_KASIR,
                'password' => 'kasir123',
            ]
        );
    }
}
