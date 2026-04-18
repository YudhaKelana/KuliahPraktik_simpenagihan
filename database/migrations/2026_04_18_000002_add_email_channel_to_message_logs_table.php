<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('message_logs', function (Blueprint $table) {
            $table->string('channel')->default('email')->after('provider');
            $table->string('recipient_email')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('message_logs', function (Blueprint $table) {
            $table->dropColumn(['channel', 'recipient_email']);
        });
    }
};
