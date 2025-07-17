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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2);
            $table->decimal('expense_amount', 15, 2)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('budget_id')->foreign('budget_id')->references('id')->on('budget_names');
            $table->bigInteger('account_id')->references('id')->on('accounts');
            $table->bigInteger('user_id')->references('id')->on('users');
            $table->bigInteger('stage_id')->references('id')->on('stages');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
