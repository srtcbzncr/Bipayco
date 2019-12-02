<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Authority extends Model
{
    use SoftDeletes;

    protected $table = 'auth_authorities';
    protected $guarded = [];

    public function Admins(){
        return $this->hasMany('App\Models\Auth\Admin', 'authority_id');
    }
}
