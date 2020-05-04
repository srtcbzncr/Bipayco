<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $table = "cr_exams";
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'symbol'
    ];
    public $timestamps = true;

    public function courses(){
        return $this->hasMany('App\Models\PrepareExams\Course');
    }
}
