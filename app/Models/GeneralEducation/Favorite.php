<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use SoftDeletes;

    protected $table = 'ge_favorites';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function course(){
        return $this->belongsTo('App\Models\GeneralEducation\Course');
    }
}
