<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'ge_sub_categories';
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo('App\Models\GeneralEducation\Category');
    }

    public function courses(){
        return $this->hasMany('App\Models\GeneralEducation\Course');
    }
}
