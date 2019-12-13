<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use SoftDeletes;

    protected $table = 'auth_guardians';
    protected $guarded = ['id', 'reference_code'];

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function students(){
        return $this->hasMany('App\Models\Auth\Student');
    }
}
