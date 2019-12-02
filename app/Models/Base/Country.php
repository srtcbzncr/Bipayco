<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'bs_countries';
    protected $guarded = [];

    public function Cities(){
        return $this->hasMany('App\Models\Base\City', 'country_id');
    }
}
