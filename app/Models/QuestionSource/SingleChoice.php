<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class SingleChoice extends Model
{
    // type: cevap tipi image ise içinde img url olacak. değilse text bir soru olacak.
    protected $fillable = [
        'questionId',
        'content',
        'isTrue',
        'type'
    ];

    public $timestamps = true;

    public function question(){
        return $this->morphMany('App\Models\QuestionSource\Question', 'questiontable');
    }
}
