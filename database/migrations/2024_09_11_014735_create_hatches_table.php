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
        Schema::create('hatches', function (Blueprint $table) {
            $table->id();
            $table->string('generation');
            $table->date('date_of_birth');
            $table->enum('type_eggs', ['Panen', 'Tidak Panen']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hatches');
    }
};
