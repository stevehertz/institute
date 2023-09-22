<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('businessid'); //where is this
            $table->string('transactionid');
            $table->string('status');
            $table->float('amount');
            $table->string('email')->default(null)->nullable();
            $table->string('currency')->default(null)->nullable();
            $table->integer('user_id')->default(null);
            $table->string('tracking_id')->default('1');
            $table->string('payment_method')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
