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
        Schema::create('hatch_treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blocks_id')->constrained('blocks')->cascadeOnDelete();
            $table->enum('fase', ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4']);
            $table->integer('temperature');
            $table->integer('humadity');
            $table->integer('died_qty')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hatch_treatments');
    }
};
