<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use SoftDeletes;

    protected $table = 'auth_guardians';
    protected $guarded = [];

    public function User(){
        return $this->morphOne('App\Models\Auth\User', 'profile');
    }

    public function Guardians(){
        return $this->hasMany('App\Models\Auth\Student', 'guardian_id');
    }

    public function District(){
        return $this->belongsTo('App\Models\Base\District', 'district_id');
    }
}
