<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'auth_students';
    protected $guarded = [];

    public function guardian(){
        return $this->belongsTo('App\Models\Auth\User', 'guardian_id');
    }

    public function school(){
        return $this->belongsTo('App\Models\Base\School');
    }

    public function user(){
        return $this->hasOne('App\Models\Auth\User');
    }
}
