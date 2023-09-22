<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdjustTimesOnExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->renameColumn('scheduled_date', 'scheduled_start_time');
            $table->dateTime( 'scheduled_end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            //
            $table->renameColumn('scheduled_start_time', 'scheduled_date');
            $table->dropColumn( 'scheduled_end_time');
        });
    }
}
