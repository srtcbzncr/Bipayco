<?php

namespace App\Models\PrepareLessons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'pl_courses';
    protected $guarded = ['id'];

    public function lesson(){
        return $this->belongsTo('App\Models\PrepareLessons\Lesson');
    }

    public function grade(){
        return $this->belongsTo('App\Models\PrepareLessons\Grade');
    }

    public function subject(){
        return $this->belongsTo('App\Models\PrepareLessons\Subject');
    }

    public function sections(){
        return $this->hasMany('App\Models\PrepareLessons\Section');
    }

    public function instructors(){
        return $this->morphToMany('App\Models\Auth\Instructor', 'course', 'ge_courses_instructors', 'course_id', 'instructor_id')->withPivot(['is_manager', 'percent']);
        //return $this->belongsToMany('App\Models\Auth\Instructor', 'ge_courses_instructors', 'course_id', 'instructor_id')->withPivot('is_manager', 'percent');
    }

    public function achievements(){
        return $this->morphMany('App\Models\GeneralEducation\Achievement', 'course');
    }

    public function requirements(){
        return $this->morphMany('App\Models\GeneralEducation\Requirement', 'course');
    }

    public function comments(){
        return $this->morphMany('App\Models\GeneralEducation\Comment', 'course');
    }

    public function commentCount(){
        return $this->comments->count();
    }

    public function discounts(){
        return $this->morphMany('App\Models\GeneralEducation\Discount', 'course');
    }

    public function notices(){
        return $this->morphMany('App\Models\GeneralEducation\Notice', 'course');
    }

    public function favorites(){
        return $this->morphMany('App\Models\GeneralEducation\Favorite', 'course');
    }

    public function tags(){
        return $this->morphMany('App\Models\GeneralEducation\Tag', 'course');
    }

    public function purchases(){
        return $this->morphMany('App\Models\GeneralEducation\Purchase', 'course');
    }

    public function entries(){
        return $this->morphMany('App\Models\GeneralEducation\Entry', 'course');
    }

    public function studentCount(){
        return $this->entries()->count();
    }

    public function lastWatchedCourses(){
        return $this->morphMany('App\Models\UsersOperations\LastWatchedCourses','course');
    }
}
