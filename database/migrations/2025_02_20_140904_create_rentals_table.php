<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('rentals', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

			$table->unsignedBigInteger('car_id');
			$table->foreign('car_id')->references('id')->on('cars')->cascadeOnUpdate()->cascadeOnDelete();

			$table->date('start_date');
			$table->date('end_date');
			$table->decimal('total_cost', 10, 2);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('rentals');
	}
};
