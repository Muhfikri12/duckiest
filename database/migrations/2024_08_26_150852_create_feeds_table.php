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
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Bebek', 'Itik', 'Ayam', 'Angsa', 'Entog', 'Burung']);
            $table->enum('type', ['Basah', 'Kering']);
            $table->enum('method', ['Kukus', 'Original']);
            $table->text('composition');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
