<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['telepon', 'kunjungan'])->default('telepon');
            $table->date('followup_date');
            $table->text('notes')->nullable();
            $table->string('result')->nullable()->comment('Hasil tindak lanjut singkat');
            $table->timestamps();

            $table->index(['task_id', 'followup_date']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followups');
    }
};
