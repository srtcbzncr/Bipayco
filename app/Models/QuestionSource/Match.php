<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'questionId',
        'content',
        'type',
        'answerId'
    ];

    public $timestamps = true;
}
