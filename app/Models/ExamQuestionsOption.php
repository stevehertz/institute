<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestionsOption extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'exam_questions_options';

    protected $fillable = ['option_text', 'correct', 'explanation', 'question_id'];


    /**
     * Set to null if empty
     * @param $input
     */
    public function setQuestionIdAttribute($input)
    {
        $this->attributes['question_id'] = $input ? $input : null;
    }

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id')->withTrashed();
    }

    public function answered($result_id)
    {
        $result = ExamResultAnswer::where('exams_result_id', '=', $result_id)
            ->where('option_id', '=', $this->id)
            ->first();

        if ($result) {
            if ($result->correct == 1) {
                return 1;
            } elseif($result->correct == 0){
                return 2;
            }
        }
        return 0;
    }

}
