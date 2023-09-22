<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('exam_questions_options')) {
            Schema::create('exam_questions_options', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('question_id')->unsigned()->nullable();
                $table->foreign('question_id', '54421_596eee8745a1eyt')->references('id')->on('exam_questions')->onDelete('cascade');
                $table->text('option_text');
                $table->tinyInteger('correct')->nullable()->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->index(['deleted_at']);
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
        Schema::dropIfExists('exam_questions_options');
    }
}
