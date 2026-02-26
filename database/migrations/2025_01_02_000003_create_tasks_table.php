<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arrears_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['new', 'in_progress', 'done'])->default('new');
            $table->date('assigned_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'employee_id']);
            $table->index('assigned_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
