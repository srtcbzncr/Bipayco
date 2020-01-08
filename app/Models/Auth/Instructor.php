<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $table = 'auth_instructors';
    protected $guarded = ['id', 'reference_code'];

    public function socialMedias(){
        return $this->belongsToMany('App\Models\Base\SocialMedia', 'bs_instructors_social_medias', 'instructor_id', 'social_media_id')->withPivot('url');
    }

    public function school(){
        return $this->belongsTo('App\Models\Base\School');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function geCourses(){
        return $this->morphedByMany('App\Models\GeneralEducation\Course', 'course','ge_courses_instructors', 'instructor_id', 'course_id')->withPivot('is_manager', 'percent');
        //return $this->belongsToMany('App\Models\GeneralEducation\Course', 'ge_courses_instructors', 'instructor_id', 'course_id')->withPivot('is_manager', 'percent');
    }

    public function plCourses(){
        return $this->morphedByMany('App\Models\PrepareLessons\Course', 'course', 'ge_courses_instructors', 'instructor_id', 'course_id')->withPivot('is_manager', 'percent');
        //return $this->belongsToMany('App\Models\GeneralEducation\Course', 'ge_courses_instructors', 'instructor_id', 'course_id')->withPivot('is_manager', 'percent');
    }

    public function courseCount(){
        return $this->geCourses->count();
    }
}
