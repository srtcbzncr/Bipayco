<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;

    protected $table = 'ge_entries';
    protected $guarded = ['id'];

    public function student(){
        return $this->belongsTo('App\Models\Auth\Student');
    }

    public function course(){
        return $this->morphTo();
    }
}
