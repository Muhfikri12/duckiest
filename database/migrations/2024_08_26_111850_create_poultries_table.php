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
        Schema::create('poultries', function (Blueprint $table) {
            $table->id();
            $table->string('generation');
            $table->enum('vaccine', ['Vaksin 1', 'Vaksin 2', 'Vaksin 3', 'Belum Vaksin'])->default('Belum Vaksin');
            $table->date('date_of_birth');
            $table->enum('status', ['Terjual', 'Tersedia'])->default('Tersedia');
            $table->enum('category', ['Bebek', 'Itik', 'Ayam', 'Angsa', 'Entog', 'Burung']);
            $table->string('icon');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poultries');
    }
};
