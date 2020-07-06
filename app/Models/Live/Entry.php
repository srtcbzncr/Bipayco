<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'student_id',
        'live_course_id',
        'password' # attendee or moderator
    ];
    public $timestamps = true;
    protected $table="live_entries";

    public function student(){
        return $this->belongsTo('App\Models\Auth\Student','student_id','id');
    }
}
