<?php

namespace App\Models\PrepareExams;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $table = 'pl_lessons';
    public $timestamps = true;
    protected $fillable = [
        'section_id',
        'is_video',
        'no',
        'name',
        'long',
        'preview',
        'file_path',
        'active',
    ];

    public function section(){
        return $this->belongsTo('App\Models\PrepareExams\Section');
    }

    public function sources(){
        return $this->morphMany('App\Models\GeneralEducation\Source', 'lesson');
    }

    public function questions(){
        return $this->morphMany('App\Models\GeneralEducation\Question', 'lesson');
    }

    public function completed(){
        return $this->morphToMany('App\Models\Auth\Student', 'lesson','ge_students_completed_lessons', 'lesson_id', 'student_id')->withPivot(['is_completed']);
        //return $this->belongsToMany('App\Models\Auth\Student', 'ge_students_completed_lessons', 'lesson_id', 'student_id')->withPivot(['is_completed']);
    }
}
