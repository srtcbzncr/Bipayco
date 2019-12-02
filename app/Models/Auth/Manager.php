<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use SoftDeletes;

    protected $table = 'auth_managers';
    protected $guarded = ['reference_code'];

    public function User(){
        return $this->morphOne('App\Models\Auth\User', 'profile');
    }

    public function School(){
        return $this->belongsTo('App\Models\Base\School', 'school_id');
    }

    public function District(){
        return $this->belongsTo('App\Models\Base\District', 'district_id');
    }
}
