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
        Schema::create('excuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('excuse_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('reason');
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Canceled'])->default('Pending');
            $table->foreignId('created_by')->constrained('users', 'id')->cascadeOnDelete();
            $table->text('remark')->nullable();
            $table->boolean('with_deduction')->default(false);
            $table->float('deduction_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excuses');
    }
};
