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
        Schema::create('private_lockers', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->nullable();
            $table->integer('status')->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->integer('admin_id')->index()->nullable();
            $table->integer('account_id')->index()->nullable();
            $table->double('problem')->nullable();
            $table->double('on_open')->nullable();
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
        Schema::dropIfExists('private_lockers');
    }
};
