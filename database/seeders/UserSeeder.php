<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@mbgreport.com'],
            [
                'name' => 'User MBG',
                'password' => 'user12345',
                'role' => 'user',
            ]
        );
    }
}
