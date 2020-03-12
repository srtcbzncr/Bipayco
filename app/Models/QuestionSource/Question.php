<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title',
        'content',
        'level',
        'instructorId',
        'question_type',
        'isConfirm',
    ];
    public $timestamps = true;
    protected $table = "question_source_question";

    public function questiontable(){
        return $this->morphTo();
    }

    public function singleChoiceAnswers(){
        return $this->hasMany('App\Models\QuestionSource\SingleChoice','questionId','id');
    }

    public function multiChoiceAnswers(){
        return $this->hasMany('App\Models\QuestionSource\MultiChoice','questionId','id');
    }

    public function gapFillingAnswers(){
        return $this->hasMany('App\Models\QuestionSource\GapFilling','questionId','id');
    }

    public function matchAnswers(){

    }

    public function trueFalseAnswers(){
        return $this->hasOne('App\Models\QuestionSource\TrueFalse','questionId','id');
    }

    public function sortAnswers(){
        return $this->hasMany('App\Models\QuestionSource\Sort','questionId','id');
    }
}
