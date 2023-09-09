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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barcode')->uniqid()->nullable();
            $table->string('name');
            $table->text('details')->nullable();
            $table->decimal('amount', 10)->default(0);
            $table->decimal('price', 10)->default(0);
            $table->decimal('gain')->default(30);
            $table->integer('category_id')->index()->nullable();
            $table->integer('unit_id')->index()->nullable();
            $table->integer('user_id')->references('id')->on('users')->nullable();
            $table->integer('account_id')->references('id')->on('accounts')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('products');
    }
};
