<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // type: soru tipini belirtir.Single mi multimi vb.
    protected $fillable = [
        'text',
        'imgUrl',
        'level',
        'type',
        'crLessonId',
        'crSubjectId',
        'instructorId',
        'isConfirm',
    ];
    public $timestamps = true;
    protected $table = "question_source_question";

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
        return $this->hasMany('App\Models\QuestionSource\Match','questionId','id');
    }

    public function trueFalseAnswers(){
        return $this->hasMany('App\Models\QuestionSource\TrueFalse','questionId','id');
    }

    public function sortAnswers(){
        return $this->hasMany('App\Models\QuestionSource\Order','questionId','id');
    }
}
