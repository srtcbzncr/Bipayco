<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'questionId',
        'content',
        'type',
        'answer'
    ];

    protected $table = "qs_match";
    public $timestamps = true;
}
