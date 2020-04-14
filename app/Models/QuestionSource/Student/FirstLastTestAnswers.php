<?php

namespace App\Models\QuestionSource\Student;

use Illuminate\Database\Eloquent\Model;

class FirstLastTestAnswers extends Model
{
    # bu tabloda öğrencinin f/l testlerine verdiği cevaplar tutulacak.
    protected $table = "qs_student_first_last_test_answers";
    protected $fillable = [
        'studentId',
        'questionId',
        'result',
    ];

    public $timestamps = true;
}
