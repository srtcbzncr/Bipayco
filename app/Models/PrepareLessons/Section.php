<?php

namespace App\Models\PrepareLessons;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $table = 'pl_sections';
    protected $guarded = ['id'];

    public function course(){
        return $this->belongsTo('App\Models\PrepareLessons\Course');
    }

    public function lessons(){
        return $this->hasMany('App\Models\PrepareLessons\Lesson');
    }
}
