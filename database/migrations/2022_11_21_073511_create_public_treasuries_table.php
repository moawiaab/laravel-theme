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
        Schema::create('public_treasuries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount')->nullable();
            $table->double('take_amount')->nullable();
            $table->double('add_amount')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->integer('account_id')->index()->nullable();
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
        Schema::dropIfExists('public_treasuries');
    }
};
