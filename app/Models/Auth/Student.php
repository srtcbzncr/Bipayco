<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'auth_students';
    protected $guarded = ['reference_code'];

    public function guardian(){
        return $this->belongsTo('App\Models\Auth\Guardian');
    }

    public function school(){
        return $this->belongsTo('App\Models\Base\School');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }
}
