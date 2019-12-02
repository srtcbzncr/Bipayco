<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'auth_admins';
    protected $guarded = ['reference_code'];

    public function User(){
        return $this->morphOne('App\Models\Auth\User', 'profile');
    }

    public function Authority(){
        return $this->belongsTo('App\Models\Auth\Authority', 'authority_id');
    }
}
