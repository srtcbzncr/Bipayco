<?php

namespace App\Models\UsersOperations;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table="favorite";
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'course_id',
        'course_type'
    ];
}
