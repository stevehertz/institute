<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeExtraPriceFieldToDeciType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->decimal('KES_cost', 15, 2)->change();
            $table->decimal('USD_cost', 15, 2)->change();
            $table->decimal('AUD_cost', 15, 2)->change();
            $table->decimal('EUR_cost', 15, 2)->change();
            $table->decimal('GBP_cost', 15, 2)->change();
            $table->decimal('CAD_cost', 15, 2)->change();
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
