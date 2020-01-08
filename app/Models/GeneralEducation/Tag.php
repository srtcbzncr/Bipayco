<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'ge_tags';
    protected $guarded = ['id'];

    public function course(){
        return $this->morphTo();
    }
}
