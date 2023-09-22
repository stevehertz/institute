<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResultAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_result_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exams_result_id')->unsigned()->nullable();
            $table->foreign('exams_result_id')->references('id')->on('exam_results')->onDelete('cascade');
            $table->integer('question_id')->unsigned()->nullable();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->integer('option_id')->unsigned()->nullable();
            $table->foreign('option_id')->references('id')->on('questions_options')->onDelete('cascade');
            $table->tinyInteger('correct')->default(0);
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
        Schema::dropIfExists('exam_result_answers');
    }
}
