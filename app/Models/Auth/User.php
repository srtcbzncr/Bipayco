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
        'district_id', 'first_name', 'last_name', 'username', 'email', 'phone_number', 'avatar', 'active', 'password'
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
        return $this->hasOne('App\Models\Auth\Student');
    }

    public function instructor(){
        return $this->hasOne('App\Models\Auth\Instructor');
    }

    public function manager(){
        return $this->belongsTo('App\Models\Auth\Manager');
    }

    public function admin(){
        return $this->hasOne('App\Models\Auth\Admin');
    }

    public function guardian(){
        return $this->hasOne('App\Models\Auth\Guardian');
    }

    public function district(){
        return $this->belongsTo('App\Models\Base\District');
    }
}
