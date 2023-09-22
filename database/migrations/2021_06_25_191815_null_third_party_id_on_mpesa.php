<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullThirdPartyIdOnMpesa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mpesa_payments', function (Blueprint $table) {
            $table->string('ThirdPartyTransID')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mpesa_payments', function (Blueprint $table) {
            //
            $table->dropColumn('ThirdPartyTransID');
        });
    }
}
