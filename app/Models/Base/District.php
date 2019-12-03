<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $table = 'bs_districts';
    protected $guarded = [];

    public function city(){
        return $this->belongsTo('App\Models\Base\City');
    }

    public function schools(){
        return $this->hasMany('App\Models\Base\School');
    }

    public function users(){
        return $this->hasMany('App\Models\Auth\User');
    }
}
