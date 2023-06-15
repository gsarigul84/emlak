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
		//
		Schema::table('emlak', function (Blueprint $table) {
			$table->integer('semt_id')->after('ilce_id');
		});
		Schema::table('mahalleler', function (Blueprint $table) {
			$table->integer('semt_id')->after('ilce_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		//
		Schema::table('emlak', function (Blueprint $table) {
			$table->dropColumn('semt_id');
		});
		Schema::table('mahalleler', function (Blueprint $table) {
			$table->dropColumn('semt_id');
		});
	}
};
