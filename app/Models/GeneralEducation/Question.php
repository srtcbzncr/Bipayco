<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $table = 'ge_questions';
    protected $guarded = ['id'];

    public function lesson(){
        return $this->belongsTo('App\Models\GeneralEducation\Lesson');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function answers(){
        return $this->hasMany('App\Models\GeneralEducation\Answer');
    }
}
