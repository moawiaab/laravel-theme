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
        Schema::create('financial_clients', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('take', 15, 2)->nullable();
            $table->decimal('export', 15, 2)->nullable();
            $table->longText('details');
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_id')->references('id')->on('users')->nullable();
            $table->integer('account_id')->references('id')->on('accounts')->nullable();
            $table->integer('client_id')->references('id')->on('clients')->nullable();
            $table->date('payment')->nullable();
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
        Schema::dropIfExists('financial_clients');
    }
};
