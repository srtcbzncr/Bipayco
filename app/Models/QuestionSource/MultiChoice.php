<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class MultiChoice extends Model
{
    protected $fillable = [
        'questionId',
        'content',
        'isTrue',
        'type'
    ];

    public $timestamps = true;
}
