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
        Schema::create('supplier_order_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('num', 10)->nullable();
            $table->double('amount')->nullable();
            $table->double('price', 10)->nullable();
            $table->double('last_amount', 10)->nullable();
            $table->decimal('last_num', 10)->nullable()->default(0);
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('order_id')->nullable()->index();
            $table->integer('supplier_id')->nullable()->index();
            $table->integer('client_id')->nullable()->index();
            $table->integer('user_id')->nullable()->index();
            $table->integer('product_id')->nullable()->index();
            $table->integer('store_id')->nullable()->index();
            $table->integer('account_id')->nullable()->index();
            $table->integer('user_check_id')->nullable()->index();
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
        Schema::dropIfExists('supplier_order_items');
    }
};
