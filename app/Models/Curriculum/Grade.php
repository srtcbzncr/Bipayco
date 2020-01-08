<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    protected $table = 'cr_grades';
    protected $guarded = ['id'];

    public function courses(){
        return $this->hasMany('App\Models\PrepareLessons\Course');
    }
}
