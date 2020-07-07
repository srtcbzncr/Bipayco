<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'image',
        'name',
        'description',
        'price',
        'price_with_discount',
        'datetime', # canlı yayının yapılacağı tarih
        'max_participant',
        'attendee_pw',
        'moderator_pw',
        'record', # default false olacak.
        'duration', # dakika cinsinden
        'completed_at', # eğer canlı yayın yapılmazsa burası null olacak. Canlı yayın yapılırsa yapıldığı tarih-saat buraya eklenecek
        'meeting_id'
    ];
    public $timestamps = true;
    protected $table="live_courses";

    public function entries(){
        return $this->hasMany('App\Models\Live\Entry', 'live_course_id','id');
    }

    public function studentCount(){
        return $this->entries->where('deleted_at',null)->count();
    }
}
