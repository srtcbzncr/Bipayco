<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'bs_countries';
    protected $guarded = ['id'];

    public function cities(){
        return $this->hasMany('App\Models\Base\City');
    }
}
