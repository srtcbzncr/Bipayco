<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'auth_admins';
    protected $guarded = ['reference_code'];

    public function authority(){
        return $this->belongsTo('App\Models\Auth\Authority');
    }

    public function user(){
        return $this->hasOne('App\Models\Auth\User');
    }
}
