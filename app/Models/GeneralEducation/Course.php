<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'ge_courses';
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo('App\Models\GeneralEducation\Category');
    }

    public function subCategory(){
        return $this->belongsTo('App\Models\GeneralEducation\SubCategory');
    }

    public function sections(){
        return $this->hasMany('App\Models\GeneralEducation\Section');
    }

    public function instructors(){
        return $this->belongsToMany('App\Models\Auth\Instructor', 'ge_courses_instructors', 'course_id', 'instructor_id')->withPivot('is_manager', 'percent');
    }

    public function achievements(){
        return $this->hasMany('App\Models\GeneralEducation\Achievement');
    }

    public function requirements(){
        return $this->hasMany('App\Models\GeneralEducation\Requirement');
    }

    public function comments(){
        return $this->hasMany('App\Models\GeneralEducation\Comment');
    }

    public function commentCount(){
        return $this->comments->count();
    }

    public function discounts(){
        return $this->hasMany('App\Models\GeneralEducation\Discount');
    }

    public function notices(){
        return $this->hasMany('App\Models\GeneralEducation\Notice');
    }

    public function favorites(){
        return $this->hasMany('App\Models\GeneralEducation\Favorite');
    }

    public function tags(){
        return $this->hasMany('App\Models\GeneralEducation\Tag');
    }

    public function purchases(){
        return $this->hasMany('App\Models\GeneralEducation\Purchase');
    }

    public function entries(){
        return $this->hasMany('App\Models\GeneralEducation\Entry');
    }
}
