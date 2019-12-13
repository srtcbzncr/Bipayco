<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
    use SoftDeletes;

    protected $table = 'ge_requirements';
    protected $guarded = ['id'];

    public function course(){
        return $this->belongsTo('App\Models\GeneralEducation\Course');
    }
}
