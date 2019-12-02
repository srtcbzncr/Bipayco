<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $table = 'bs_cities';
    protected $guarded = [];

    public function Country(){
        return $this->belongsTo('App\Models\Base\Country', 'country_id');
    }

    public function Districts(){
        return $this->hasMany('App\Models\Base\District', 'city_id');
    }
}
