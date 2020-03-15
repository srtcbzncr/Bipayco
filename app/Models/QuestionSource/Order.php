<?php

namespace App\Models\QuestionSource;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'questionId',
        'content',
        'no',
    ];

    protected $table = "qs_order";

    public $timestamps = true;
}
