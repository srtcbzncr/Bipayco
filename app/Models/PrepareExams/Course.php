<?php

namespace App\Models\PrepareExams;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = "pe_courses";
    protected $guarded = ['id'];

    protected $fillable =  [
        'exam_id',
        'image',
        'name',
        'description',
        'access_time',
        'certificate',
        'long',
        'price',
        'price_with_discount',
        'point',
        'purchase_count',
        'score',
        'active'
    ];

    public $timestamps = true;
}
