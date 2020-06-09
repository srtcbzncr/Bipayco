<?php

namespace App\Http\Controllers\Iyzico;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\BasketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function result(Request $request){
        // initializing
        $repo = new BasketRepository();
        $data = $request->toArray();
        dd($data);
        //$data['user_id'] = Auth::id();

        // operations
        $resp = $repo->result($data);
        if($resp->getResult()){
            return view('paymentResult');
        }
        else{
            return redirect()->back();
        }
    }
}
