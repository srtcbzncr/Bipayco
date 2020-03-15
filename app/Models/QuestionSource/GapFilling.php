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

    protected $table = "qs_gap_filling";

    public $timestamps = true;
}
