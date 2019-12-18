<?php

namespace App\Models\GeneralEducation;

use App\Events\GeneralEducation\NewPurchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $table = 'ge_purchases';
    protected $guarded = ['id'];
    protected $dispatchesEvents = [
        'created' => NewPurchase::class,
    ];

    public function course(){
        return $this->belongsTo('App\Models\GeneralEducation\Course');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function student(){
        return $this->belongsTo('App\Models\Auth\Student');
    }
}
