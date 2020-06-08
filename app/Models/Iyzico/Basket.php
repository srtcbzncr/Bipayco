<?php

namespace App\Models\Iyzico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Basket extends Model
{

    use SoftDeletes;

    protected $table = "iyzico_basket";
    protected $fillable = [
        'price',
        'token',
        'status',
        'payment_status',
        'error_message',
        'payment_id',
        'fraud_status',
        'iyzico_comission_fee'
    ];
    public $timestamps = true;

    public function BasketItems(){
        $this->hasMany('App\Models\Iyzico\BasketItems','iyzico_basket_id','id');
    }
}
