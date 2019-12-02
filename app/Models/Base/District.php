<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $table = 'bs_districts';
    protected $guarded = [];

    public function City(){
        return $this->belongsTo('App\Models\Base\City', 'city_id');
    }

    public function Schools(){
        return $this->hasMany('App\Models\Base\School', 'district_id');
    }

    public function Instructors(){
        return $this->hasMany('App\Models\Auth\Instructor', 'district_id');
    }

    public function Managers(){
        return $this->hasMany('App\Models\Auth\Manager', 'district_id');
    }

    public function Students(){
        return $this->hasMany('App\Models\Auth\Student', 'district_id');
    }

    public function Guardians(){
        return $this->hasMany('App\Models\Auth\Guardian', 'district_id');
    }
}
