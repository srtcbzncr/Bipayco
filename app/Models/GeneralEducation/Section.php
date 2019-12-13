<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $table = 'ge_sections';
    protected $guarded = ['id'];

    public function course(){
        return $this->belongsTo('App\Models\GeneralEducation\Course');
    }

    public function lessons(){
        return $this->hasMany('App\Models\GeneralEducation\Lesson');
    }
}
