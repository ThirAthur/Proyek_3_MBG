<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('schools', function (Blueprint $table) { $table->id(); $table->string('name')->unique(); $table->string('address')->nullable(); $table->timestamps(); });
        Schema::create('sppgs', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('code')->nullable()->unique(); $table->string('address')->nullable(); $table->timestamps(); });
        Schema::create('school_sppg', function (Blueprint $table) { $table->id(); $table->foreignId('school_id')->constrained()->cascadeOnDelete(); $table->foreignId('sppg_id')->constrained()->cascadeOnDelete(); $table->timestamps(); $table->unique(['school_id','sppg_id']); });
        Schema::table('reports', function (Blueprint $table) { $table->foreignId('school_id')->nullable()->after('student_name')->constrained()->restrictOnDelete(); $table->foreignId('sppg_id')->nullable()->after('school_id')->constrained()->restrictOnDelete(); });
        if (Schema::hasColumn('reports', 'school_name')) {
            $names = DB::table('reports')->whereNotNull('school_name')->distinct()->pluck('school_name');
            foreach ($names as $name) {
                $schoolId = DB::table('schools')->insertGetId(['name' => $name, 'created_at' => now(), 'updated_at' => now()]);
                DB::table('reports')->where('school_name', $name)->update(['school_id' => $schoolId]);
            }
            Schema::table('reports', function (Blueprint $table) { $table->dropColumn('school_name'); });
        }
    }
    public function down(): void {
        Schema::table('reports', function (Blueprint $table) { $table->dropConstrainedForeignId('sppg_id'); $table->dropConstrainedForeignId('school_id'); });
        Schema::dropIfExists('school_sppg'); Schema::dropIfExists('sppgs'); Schema::dropIfExists('schools');
    }
};
