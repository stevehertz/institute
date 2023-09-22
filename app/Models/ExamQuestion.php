<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ExamResultAnswer;
use \App\Models\ExamQuestionsOption;

class ExamQuestion extends Model
{
    use SoftDeletes;
    protected $table ='exam_questions';
    protected $primaryKe ='id';

    protected $fillable = ['question', 'question_image', 'score'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $courses = auth()->user()->courses->pluck('id');
                    $builder->whereHas('exams', function ($q) use ($courses) {
                        $q->whereIn('exams.course_id', $courses);
                    });
                });
            }
        }

        static::deleting(function ($question) { // before delete() method call this
            if ($question->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $question->question_image))) {
                    File::delete(public_path('/storage/uploads/' . $question->question_image));
                }
            }
        });

    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setScoreAttribute($input)
    {
        $this->attributes['score'] = $input ? $input : null;
    }

    public function options()
    {
        return $this->hasMany(ExamQuestionsOption::class, 'question_id');
    }

    public function isAttempted($result_id){
        $result = ExamResultAnswer::where('exams_result_id', '=', $result_id)
            ->where('question_id', '=', $this->id)
            ->first();
        if($result != null){
            return true;
        }
        return false;
    }
    
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'question_exam', 'question_id');
    }

}
