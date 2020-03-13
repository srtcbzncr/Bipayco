<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class TrueFalse extends Model
{
    // ansewer-> 1: doğru , 0: yanlış
    protected $fillable = [
        'questionId',
        'content',
    ];

    public $timestamps = true;
}
