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
        Schema::create('sabiticerik_detay', function (Blueprint $table) {
            $table->id();
            $table->integer('icerik_id');
            $table->string('dilkodu');
            $table->string('sef')->nullable();
            $table->string('aciklama')->nullable();
            $table->string('baslik')->nullable();
            $table->mediumText('icerik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sabiticerik_ceviriler');
    }
};
