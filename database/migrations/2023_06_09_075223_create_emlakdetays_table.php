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
        Schema::create('emlakdetay', function (Blueprint $table) {
            $table->id();
            $table->integer('emlak_id');
            $table->string('dilkodu');
            $table->string('sef');
            $table->string('baslik');
            $table->text('aciklama');
            $table->mediumText('detay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emlakdetay');
    }
};
