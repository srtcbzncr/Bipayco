<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use SoftDeletes;

    protected $table = 'auth_managers';
    protected $guarded = ['id', 'reference_code'];

    public function school(){
        return $this->belongsTo('App\Models\Base\School');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }
}
