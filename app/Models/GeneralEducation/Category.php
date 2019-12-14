<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'ge_categories';
    protected $guarded = ['id'];

    public function subCategories(){
        return $this->hasMany('App\Models\GeneralEducation\SubCategory');
    }

    public function courses(){
        return $this->hasMany('App\Models\GeneralEducation\Course');
    }
}
