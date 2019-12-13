<?php

namespace App\Models\GeneralEducation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rebate extends Model
{
    use SoftDeletes;

    protected $table = 'ge_rebates';
    protected $guarded = ['id'];

    public function purchase(){
        return $this->belongsTo('App\Models\GeneralEducation\Purchase');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }
}
