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

    protected $table = "qs_true_false";

    public $timestamps = true;
}
