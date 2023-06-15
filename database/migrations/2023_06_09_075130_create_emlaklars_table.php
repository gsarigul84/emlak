<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('emlak', function (Blueprint $table) {
			$table->id();
			$table->integer('grup_id');
			$table->integer('tip_id');
			$table->integer('il_id');
			$table->integer('ilce_id');
			$table->integer('mahalle_id');
			$table->string('ilan_no')->nullable();
			$table->string('ilantipi');
			$table->json('koordinatlar');
			$table->boolean('durum');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('emlak');
	}
};
