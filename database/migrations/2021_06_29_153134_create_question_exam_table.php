<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('question_exam')) {
            Schema::create('question_exam', function (Blueprint $table) {
                $table->integer('question_id')->unsigned()->nullable();
                $table->foreign('question_id', 'fk_p_54420__exam_que_596eeef70992fa')->references('id')->on('exam_questions')->onDelete('cascade');
                $table->bigInteger('exam_id')->unsigned()->nullable();
                $table->foreign('exam_id', 'fk_p_54422_question_596eeef7099af')->references('id')->on('exams')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_exam');
    }
}
