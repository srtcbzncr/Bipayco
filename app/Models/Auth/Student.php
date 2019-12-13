<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'auth_students';
    protected $guarded = ['id', 'reference_code'];

    public function guardian(){
        return $this->belongsTo('App\Models\Auth\Guardian');
    }

    public function school(){
        return $this->belongsTo('App\Models\Base\School');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function geCompleted(){
        return $this->belongsToMany('App\Models\GeneralEducation\Lesson', 'ge_students_completed_lessons', 'student_id', 'lesson_id');
    }

    public function geEntries(){
        return $this->hasMany('App\Models\GeneralEducation\Entry');
    }

    public function gePurchases(){
        return $this->hasMany('App\Models\GeneralEducation\Purchase');
    }
}
