<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expanses', function (Blueprint $table) {
            $table->id();
            $table->double('amount', 15, 2)->nullable();
            $table->string('text_amount')->nullable();
            $table->string('beneficiary');
            $table->longText('details');
            $table->longText('feeding')->nullable();
            $table->tinyText('stage')->default('new');

            $table->integer('budget_id')->index()->references('id')->on('budgets');
            $table->integer('stage_id')->index()->references('id')->on('stages');
            $table->integer('account_id')->index()->references('id')->on('accounts');
            $table->integer('user_id')->index()->references('id')->on('users');
            $table->integer('administrative_id')->index()->references('id')->on('users')->nullable();
            $table->integer('executive_id')->index()->references('id')->on('users')->nullable();
            $table->integer('financial_id')->index()->references('id')->on('users')->nullable();
            $table->integer('accountant_id')->index()->references('id')->on('users')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expanses');
    }
};
