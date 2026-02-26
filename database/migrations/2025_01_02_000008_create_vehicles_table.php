<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxpayer_id')->constrained()->cascadeOnDelete();
            $table->string('plate_number')->index();
            $table->string('registration_number')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_brand')->nullable();
            $table->year('vehicle_year')->nullable();
            $table->date('due_date')->nullable()->index();
            $table->enum('status_payment', ['unpaid', 'paid'])->default('unpaid');
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['plate_number', 'due_date'], 'vehicles_plate_due_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
