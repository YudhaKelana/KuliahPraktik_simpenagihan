<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxpayers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->nullable()->unique();
            $table->string('phone_e164')->nullable()->index();
            $table->text('address')->nullable();
            $table->string('district')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('opt_out')->default(false);
            $table->timestamp('opt_out_at')->nullable();
            $table->boolean('flag_phone_invalid')->default(false);
            $table->boolean('flag_address_suspect')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxpayers');
    }
};
