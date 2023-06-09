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
        Schema::create('emlakgorselleri', function (Blueprint $table) {
            $table->id();
            $table->integer('emlak_id');
            $table->string('dosyaadi');    
            $table->string('aciklama');
            $table->integer('sira');
            $table->boolean('vitrin')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emlakgorselleri');
    }
};
