<?php

namespace App\Models\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'auth_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function student(){
        return $this->belongsTo('App\Models\Auth\Student');
    }

    public function instructor(){
        return $this->belongsTo('App\Models\Auth\Instructor');
    }

    public function manager(){
        return $this->belongsTo('App\Models\Auth\Manager');
    }

    public function admin(){
        return $this->belongsTo('App\Models\Auth\Admin');
    }

    public function district(){
        return $this->belongsTo('App\Models\Base\District');
    }
}
