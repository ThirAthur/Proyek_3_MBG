<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CoordinatorUserSeeder::class,
            UserSeeder::class,

            SchoolSeeder::class,
            SppgSeeder::class,
            SchoolSppgSeeder::class,
        ]);
    }
}
