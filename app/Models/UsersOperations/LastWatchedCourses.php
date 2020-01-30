<?php

namespace App\Models\UsersOperations;

use Illuminate\Database\Eloquent\Model;

class LastWatchedCourses extends Model
{
    protected $table = "last_watched_courses";
    public $timestamps = true;

    protected $fillable=[
        'student_id',
        'course_type',
        'course_id'
    ];

    public function students(){
        return $this->morphToMany('App\Models\Auth\Student');
    }

    public function ge(){ // general educations
        return $this->morphToMany('App\Models\GeneralEducation\Course');
    }
    public function pl(){ // preapera lessons
        return $this->morphToMany('App\Models\PrepareLessons\Course');
    }

    // bundan sonra: sınavlara hazırlık (pe), deneme sınavları (pratic_exam) ...

}
