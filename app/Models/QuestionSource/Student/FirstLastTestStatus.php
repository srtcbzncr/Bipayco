<?php

namespace App\Models\QuestionSource\Student;

use Illuminate\Database\Eloquent\Model;

class FirstLastTestStatus extends Model
{
    # bu tabloda öğrencinin f/l testlerini geçip geçmediği tutulacak.
    protected $table = "qs_student_first_last_test_status";
    protected $fillable = [
        'studentId',
        'sectionId',
        'sectionType', // pl kursumu yoksa soru bankasının vb.
        'testType', // ön test mi son test mi: 0: ön test, 1: son test
        'score',
        'result'
    ];

    public $timestamps = true;

}
