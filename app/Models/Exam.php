<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'exams';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'payment_status',
        'course_id',
        'max_allocated_time',
        'pass_mark',
        'total_score',
        'fail_mark',
        'exam_status',
        'scheduled_end_time',
        'scheduled_start_time',
        'scheduled_time',
        'status',
        'supervisor_id',
        'course_id',
        'uniqueExamId',
        'exam_instructions',
        'examinationType',

    ];
    protected $dates = [
        'scheduled_date',
    ];



    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        if(auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('course', function ($q) {
                        $q->whereHas('teachers', function ($t) {
                            $t->where('course_user.user_id', '=', auth()->user()->id);
                        });
                    });
                });
            }
        }

    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setCourseIdAttribute($input)
    {
        $this->attributes['course_id'] = $input ? $input : null;
    }


    /**
     * Set to null if empty
     * @param $input
     */

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }

    public function questions()
    {
        return $this->belongsToMany(ExamQuestion::class, 'question_exam', 'exam_id', 'question_id')->withTrashed();
    }
    public function supervisor()
    {
        return $this->belongsToMany(User::class, 'exam_user')->withPivot('user_id');
    }

    public function chapterStudents()
    {
        return $this->morphMany(ChapterStudent::class,'model');
    }

    public function examTimeline()
    {
        return $this->hasMany(ExamTimeline::class);
    }

    public function isCompleted(){
        $isCompleted = $this->chapterStudents()->where('user_id', \Auth::id())->count();
        if($isCompleted > 0){
            return true;
        }
        return false;

    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'exam_student')->withTimestamps();
    }
    public function examResults()
    {
        return $this->hasMany(ExamResult::class, 'exam_id');
    }
}
