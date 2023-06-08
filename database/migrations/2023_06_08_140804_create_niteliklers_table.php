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
        Schema::create('nitelikler', function (Blueprint $table) {
            $table->id();
            $table->string('nitelikadi');
            $table->boolean('secimli')->default(false);
            $table->json('degerler');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nitelikler');
    }
};
