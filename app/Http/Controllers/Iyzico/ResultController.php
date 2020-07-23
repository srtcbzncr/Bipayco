<?php

namespace App\Http\Controllers\Iyzico;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\BasketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function result($user_id,Request $request){
        // initializing
        $repo = new BasketRepository();
        $data = $request->toArray();
        $data['user_id'] = decrypt($user_id);

        // operations
        $resp = $repo->result($data);
        if($resp->getResult()){
            if($resp->getData()){
                return view('paymentResult')->with('data',true)->with('error', __('auth.payment_successful'));
            }
            else{
                return view('paymentResult')->with('data',false)->with('error', __('auth.payment_error')." - ".$resp->getError());
            }
        }
        else{
            return view('paymentResult')->with('data',false)->with('error', __('auth.payment_error')." - ".$resp->getError());
        }
    }
}
