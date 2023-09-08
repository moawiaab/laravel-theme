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
        Schema::create('open_days', function (Blueprint $table) {
            $table->id();
            $table->decimal('on_open');
            $table->decimal('problem');
            $table->decimal('amount');
            $table->string('details')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->integer('account_id')->index()->nullable();
            $table->integer('locker_id')->index()->nullable();
            $table->integer('user_updated_id')->index()->nullable();
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
        Schema::dropIfExists('open_days');
    }
};
