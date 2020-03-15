<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class SingleChoice extends Model
{
    // type: cevap tipi image ise content içinde img url olacak. değilse text bir soru olacak.
    protected $fillable = [
        'questionId',
        'content',
        'isTrue',
        'type'
    ];

    public $timestamps = true;

    protected $table = "qs_single_choice";
}
