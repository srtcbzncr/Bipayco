<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $table = 'bs_schools';
    protected $guarded = ['code'];

    public function district(){
        return $this->belongsTo('App\Models\Base\District');
    }

    public function students(){
        return $this->hasMany('App\Models\Auth\Student');
    }

    public function instructors(){
        return $this->hasMany('App\Models\Auth\Instructor');
    }

    public function managers(){
        return $this->hasMany('App\Models\Auth\Manager');
    }
}
