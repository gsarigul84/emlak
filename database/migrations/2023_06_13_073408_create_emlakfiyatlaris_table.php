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
		Schema::create('emlakfiyatlari', function (Blueprint $table) {
			$table->id();
			$table->integer('emlak_id');
			$table->unsignedBigInteger('fiyat');
			$table->string('sembol');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('emlakfiyatlari');
	}
};
