<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('days_before_due')->comment('Positif = sebelum, negatif = sesudah jatuh tempo');
            $table->string('template_code')->default('default');
            $table->text('template_text')->nullable();
            $table->time('send_window_start')->default('08:00');
            $table->time('send_window_end')->default('16:00');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_rules');
    }
};
