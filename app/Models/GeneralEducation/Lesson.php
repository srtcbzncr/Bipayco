<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $table = 'ge_lessons';
    protected $guarded = ['id'];

    public function section(){
        return $this->belongsTo('App\Models\GeneralEducation\Section');
    }

    public function sources(){
        return $this->hasMany('App\Models\GeneralEducation\Source');
    }

    public function questions(){
        return $this->hasMany('App\Models\GeneralEducation\Question');
    }

    public function completed(){
        return $this->belongsToMany('App\Models\Auth\Student', 'ge_students_completed_lessons', 'lesson_id', 'student_id');
    }
}
