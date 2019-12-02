<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'auth_students';
    protected $guarded = [];

    public function User(){
        return $this->morphOne('App\Models\Auth\User', 'profile');
    }

    public function Guardian(){
        return $this->belongsTo('App\Models\Auth\Guardian', 'guardian_id');
    }

    public function School(){
        return $this->belongsTo('App\Models\Base\School', 'school_id');
    }

    public function District(){
        return $this->belongsTo('App\Models\Base\District', 'district_id');
    }
}
