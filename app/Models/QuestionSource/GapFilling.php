<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class GapFilling extends Model
{
    protected $fillable = [
        'questionId',
        'content',
        'no',
        'type'
    ];

    public $timestamps = true;
}
