<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes;

    protected $table = 'ge_sources';
    protected $guarded = ['id'];

    public function lesson(){
        return $this->morphTo();
    }
}
