<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class SingleChoice extends Model
{
    protected $fillable = [
        'questionId',
        'answer',
        'isTrue',
    ];

    public $timestamps = true;

    public function question(){
        return $this->morphMany('App\Models\QuestionSource\Question', 'questiontable');
    }
}
