<?php

namespace App\Models\UsersOperations;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = "basket";
    protected $fillable = [
        'user_id',
        'course_id',
        'course_type'
    ];
    public $timestamps = true;
}
