
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereIn('role', ['pelapor', 'pemantau', 'koordinator'])
            ->update(['role' => 'user']);
    }

    public function down(): void
    {
        // Tidak mengembalikan role lama.
    }
};
