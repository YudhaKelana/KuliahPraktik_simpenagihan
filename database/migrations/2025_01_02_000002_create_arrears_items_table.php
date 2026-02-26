<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arrears_items', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->index();
            $table->string('registration_number')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('district')->nullable()->comment('Kecamatan');
            $table->string('sub_district')->nullable()->comment('Kelurahan');
            $table->string('postal_code')->nullable();
            $table->decimal('arrears_amount', 15, 2)->default(0);
            $table->integer('arrears_years')->default(0);
            $table->date('calculation_date')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_brand')->nullable();
            $table->year('vehicle_year')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('flag_phone_invalid')->default(false);
            $table->boolean('flag_address_suspect')->default(false);
            $table->string('import_batch')->nullable();
            $table->timestamps();

            $table->unique(['plate_number', 'calculation_date'], 'arrears_plate_date_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arrears_items');
    }
};
