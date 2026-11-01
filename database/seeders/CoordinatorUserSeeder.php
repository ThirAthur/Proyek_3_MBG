<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
class CoordinatorUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'koordinator@mbgreport.com'], [
            'name' => 'Koordinator MBG',
            'password' => 'koordinator12345',
            'role' => 'coordinator',
        ]);
    }
}
