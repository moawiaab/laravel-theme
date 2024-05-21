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
        Schema::create('expanse_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->string('details');
            $table->smallInteger('status')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('expanse_id')->nullable();
            $table->integer('locker_id')->nullable();
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
        Schema::dropIfExists('expanse_items');
    }
};
