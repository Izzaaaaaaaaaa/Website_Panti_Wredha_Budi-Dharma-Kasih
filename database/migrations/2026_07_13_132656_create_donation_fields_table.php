<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // snake_case name for frontend
            $table->string('label'); // human readable label
            $table->enum('type', ['text', 'textarea', 'number', 'select'])->default('text');
            $table->string('options')->nullable(); // comma separated if select
            $table->boolean('is_required')->default(false);
            $table->enum('form_type', ['Tunai', 'Barang', 'Semua'])->default('Semua');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_fields');
    }
};
