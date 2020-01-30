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
        return $this->belongsTo('App\Models\Auth\Student');
    }

    public function lastWatchedCourse(){
        return $this->morphTo();
    }
}
