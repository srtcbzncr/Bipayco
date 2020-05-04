<?php

namespace App\Models\PrepareExams;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $table = 'pe_sections';
    public $timestamps = true;
    protected $fillable = [
      'course_id',
      'lesson_id',  // cr_lesson tablosundan
      'subject_id', // cr_subject tablosundan
      'no',
      'name',
      'active',
    ];

    public function course(){
        return $this->belongsTo('App\Models\PrepareExams\Course');
    }

    public function exam(){
        return $this->belongsTo('App\Models\Curriculum\Exam');
    }

    public function lessons(){
        return $this->hasMany('App\Models\PrepareExams\Lesson');
    }
}
