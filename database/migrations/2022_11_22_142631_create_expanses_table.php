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
            $table->string('beneficiary')->nullable();;
            $table->longText('details');
            $table->longText('feeding')->nullable();

            $table->integer('budget_id')->index()->references('id')->on('budgets');
            $table->integer('stage_id')->index()->references('id')->on('stages');
            $table->integer('user_id')->index()->references('id')->on('users');
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
