<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTimeline extends Model
{
    use HasFactory;
    protected $table = "exam_timeline";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
