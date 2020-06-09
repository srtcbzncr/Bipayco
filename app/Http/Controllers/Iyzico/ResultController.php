<?php

namespace App\Http\Controllers\Iyzico;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\BasketRepository;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function result(Request $request){
        // initializing
        $repo = new BasketRepository();
        $data = $request->toArray();

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
