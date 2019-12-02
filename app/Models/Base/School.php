<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $table = 'bs_schools';
    protected $guarded = ['code'];

    public function District(){
        return $this->belongsTo('App\Models\Base\District', 'district_id');
    }

    public function Students(){
        return $this->hasMany('App\Models\Auth\Student', 'school_id');
    }

    public function Instructors(){
        return $this->hasMany('App\Models\Auth\Instructor', 'school_id');
    }

    public function Managers(){
        return $this->hasMany('App\Models\Auth\Manager','school_id');
    }
}
