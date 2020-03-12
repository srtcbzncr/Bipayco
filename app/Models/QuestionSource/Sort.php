<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    protected $fillable = [
        'questionId',
        'answer',
        'order',
    ];

    public $timestamps = true;
}
