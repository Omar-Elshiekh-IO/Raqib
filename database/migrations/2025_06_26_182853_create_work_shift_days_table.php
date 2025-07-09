<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('work_shift_days', function (Blueprint $table) {
      $table->id();
      $table->foreignId('work_shift_id')->constrained()->cascadeOnDelete();
      $table->tinyInteger('day'); // 0 = Sunday, 6 = Saturday
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('work_shift_days');
  }
};
