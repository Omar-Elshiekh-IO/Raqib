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
        Schema::table('leaves', function (Blueprint $table) {
            $table->date('approved_on')->nullable()->after('status');
            $table->boolean('with_deduction')->default(false);
            $table->float('deduction_amount')->nullable();
            $table->date('start_deduction_date')->nullable();
            $table->date('end_deduction_date')->nullable();
            $table->integer('total_deduction_months')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('approved_on');
            $table->dropColumn('with_deduction');
            $table->dropColumn('deduction_amount');
            $table->dropColumn('total_deduction_months');
            $table->dropColumn('start_deduction_date');
            $table->dropColumn('end_deduction_date');
        });
    }
};
