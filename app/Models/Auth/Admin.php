<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'auth_admins';
    protected $guarded = ['id', 'reference_code'];

    public function authority(){
        return $this->belongsTo('App\Models\Auth\Authority');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }
}
