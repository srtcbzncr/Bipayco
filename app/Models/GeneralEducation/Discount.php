<?php

namespace App\Models\GeneralEducation;

use App\Events\GeneralEducation\CreateDiscount;
use App\Events\GeneralEducation\DeleteDiscount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $table = 'ge_discounts';
    protected $guarded = ['id'];
    protected $dispatchesEvents = [
        'created' => CreateDiscount::class,
        'deleting' => DeleteDiscount::class,
    ];

    public function course(){
        return $this->morphTo();
    }
}
