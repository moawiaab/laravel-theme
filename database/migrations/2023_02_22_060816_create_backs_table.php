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
        Schema::create('backs', function (Blueprint $table) {
            $table->id();
            $table->string('details')->nullable();
            $table->integer('pro_id')->references('id')->on('products');
            $table->integer('order_id')->references('id')->on('orders');
            $table->integer('item_id')->references('id')->on('order_items');
            $table->integer('store_id')->references('id')->on('product_store');
            $table->decimal('amount')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->decimal('num')->nullable();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('account_id')->references('id')->on('accounts');
            $table->integer('updated_id')->references('id')->on('users')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backs');
    }
};
