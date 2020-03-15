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
    protected $table = "qs_multi_choice";
    public $timestamps = true;
}
