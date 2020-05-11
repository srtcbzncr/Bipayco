<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class GuardianUser extends Model
{
    protected $table = "auth_guardian_user";
    protected $fillable = [
        'guardian_id',
        'user_id',
        'active'
    ];
    public $timestamps = true;
}
