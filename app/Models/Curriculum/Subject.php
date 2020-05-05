<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'cr_subjects';
    protected $guarded = ['id'];

    public function sections(){
        return $this->hasMany('App\Models\PrepareLessons\Section');
    }

}
