<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $table = 'bs_cities';
    protected $guarded = ['id'];

    public function country(){
        return $this->belongsTo('App\Models\Base\Country');
    }

    public function districts(){
        return $this->hasMany('App\Models\Base\District');
    }
}
