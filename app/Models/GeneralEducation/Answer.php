<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    protected $table = 'ge_answers';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function question(){
        return $this->belongsTo('App\Models\GeneralEducation\Question');
    }
}
