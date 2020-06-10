<?php

namespace App\Models\Iyzico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasketItems extends Model
{
    use SoftDeletes;

    protected $table = "iyzico_basket_items";
    protected $fillable = [
        'iyzico_basket_id',
        'purchase_id',
        'item_id',
        'course_type',
        'course_id',
        'price',
        'payment_transaction_id',
        'transaction_status',
        'confirmation'
    ];

    public $timestamps = true;

}
