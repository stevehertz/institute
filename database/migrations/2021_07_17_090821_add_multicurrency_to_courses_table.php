<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMulticurrencyToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('KES_cost')->nullable();
            $table->string('USD_cost')->nullable();
            $table->string('AUD_cost')->nullable();
            $table->string('EUR_cost')->nullable();
            $table->string('GBP_cost')->nullable();
            $table->string('CAD_cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
            $table->dropColumn('KES_cost');
            $table->dropColumn('USD_cost');
            $table->dropColumn('AUD_cost');
            $table->dropColumn('EUR_cost');
            $table->dropColumn('GBP_cost');
            $table->dropColumn('CAD_cost');
        });
    }
}
