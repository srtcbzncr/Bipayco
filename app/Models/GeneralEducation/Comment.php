<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'ge_comments';
    protected $guarded = ['id'];

    public function course(){
        return $this->belongsTo('App\Models\GeneralEducation\Course');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }
}
