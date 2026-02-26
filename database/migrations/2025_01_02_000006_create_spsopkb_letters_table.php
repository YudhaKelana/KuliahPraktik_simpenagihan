<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spsopkb_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->string('letter_number')->nullable()->unique();
            $table->date('issued_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->enum('status', ['kandidat', 'terbit', 'lunas'])->default('kandidat');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'issued_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spsopkb_letters');
    }
};
