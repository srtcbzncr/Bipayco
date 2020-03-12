<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    // TODO: burası kesin değil henüz
    protected $fillable = [
        'questionId',
        'answer',
    ];

    public $timestamps = true;
}
