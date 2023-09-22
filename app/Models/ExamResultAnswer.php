<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestResult;
use App\Models\ExamResult;

class ExamResultAnswer extends Model
{
    use HasFactory;
    protected  $table = 'exam_result_answers';
    protected $primaryKey = 'id';
    protected $fillable = ['exams_result_id', 'question_id', 'option_id', 'correct'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function option(){
        return $this->belongsTo(QuestionsOption::class);
    }

    public function examResult(){
        return $this->belongsTo(ExamResult::class);
    }
}
