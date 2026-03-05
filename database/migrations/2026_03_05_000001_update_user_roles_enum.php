<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite / MySQL enum change
        // Drop the old enum and recreate with new values
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_new')->default('petugas_penagihan')->after('password');
        });

        // Migrate old role values to new
        DB::table('users')->where('role', 'admin')->update(['role_new' => 'administrator_sistem']);
        DB::table('users')->where('role', 'supervisor')->update(['role_new' => 'koordinator_penagihan']);
        DB::table('users')->where('role', 'operator')->update(['role_new' => 'petugas_penagihan']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_new', 'role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_old')->default('operator')->after('password');
        });

        DB::table('users')->where('role', 'administrator_sistem')->update(['role_old' => 'admin']);
        DB::table('users')->where('role', 'koordinator_penagihan')->update(['role_old' => 'supervisor']);
        DB::table('users')->where('role', 'petugas_penagihan')->update(['role_old' => 'operator']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_old', 'role');
        });
    }
};
