<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->integer('payment_status')->default(0);
            $table->time('max_allocated_time')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('pass_mark');
            $table->integer('fail_mark');
            $table->string('exam_status')->nullable()->comment('scheduled, ongoing, completed, cancelled, postponed, paused');
            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_time')->nullable();
            $table->integer('status')->default(1)->comment('1-active, 0-inactive');
            $table->integer('supervisor_id')->unsigned();
            $table->foreign('supervisor_id')->references('id')->on('users');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
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
        Schema::dropIfExists('exams');
    }
}
