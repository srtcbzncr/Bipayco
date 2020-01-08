<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use SoftDeletes;

    protected $table = 'ge_achievements';
    protected $guarded = ['id'];

    public function course(){
        return $this->morphTo();
    }
}
