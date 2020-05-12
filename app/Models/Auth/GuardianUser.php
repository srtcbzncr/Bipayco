<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuardianUser extends Model
{
    use SoftDeletes;

    protected $table = "auth_guardian_user";
    protected $fillable = [
        'guardian_id',
        'user_id',
        'active'
    ];
    public $timestamps = true;
}
