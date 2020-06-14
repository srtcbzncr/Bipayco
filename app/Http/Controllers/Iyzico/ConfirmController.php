<?php

namespace App\Http\Controllers\Iyzico;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Payment\Payment;
use App\Models\Iyzico\BasketItems;

class ConfirmController extends Controller
{
    public function confirm(Request $request){
        $payment = new Payment();
        $today = $this->getDatetimeNow();
        $count = 0;
        $max_date = date_sub($today, date_interval_create_from_date_string('1 month'));
        $items = BasketItems::where('transaction_status', 1)->where('created_at', '<', $max_date->format('Y-m-d H:i:s'))->get();
        foreach ($items as $item){
            $result = $payment->confirm($item->payment_transaction_id);

            if($result->getStatus() == 'success'){
                $item->transaction_status = 2;
                $item->save();
                $count += 1;
            }
        }
        return response($count);
    }

    function getDatetimeNow() {
        $tz_object = new DateTimeZone('Asia/Istanbul');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime;
    }

    public function register(Request $request){
        $instructors = Instructor::all();
        $payment = new Payment();
        $count = 0;

        foreach($instructors as $instructor){
            if($instructor->sub_merchant_key == null){
                $result = $payment->createSubMerchant($instructor);
                if($result->getStatus() == 'success'){
                    $instructor->sub_merchant_key = $result->getSubMerchantKey();
                    $instructor->save();
                    $count += 1;
                }
            }
        }
        return response($count);
    }
}
