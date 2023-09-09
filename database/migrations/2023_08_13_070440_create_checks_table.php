<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('num');
            $table->string('bank')->nullable();
            $table->string('details')->nullable();
            $table->decimal('amount', 15, 2);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type')->default(1);
            $table->date('date');
            $table->bigInteger('account_id')->references('id')->on('accounts');
            $table->bigInteger('user_id')->references('id')->on('users');
            $table->bigInteger('supplier_id')->references('id')->on('suppliers')->nullable();
            $table->bigInteger('client_id')->references('id')->on('clients')->nullable();
            $table->integer('bank_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checks');
    }
};
