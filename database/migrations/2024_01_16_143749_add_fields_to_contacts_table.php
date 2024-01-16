<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
            $table->string('last_name')->after('name')->nullable();
            $table->string('organization')->after('email')->nullable();
            $table->string('country')->after('organization')->nullable();
            $table->string('title')->after('country')->nullable();
            $table->string('topic')->after('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
            $table->dropColumn('last_name');
            $table->dropColumn('organization');
            $table->dropColumn('country');
            $table->dropColumn('title');
            $table->dropColumn('topic');
        });
    }
}
