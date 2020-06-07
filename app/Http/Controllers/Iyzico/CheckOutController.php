<?php

namespace App\Http\Controllers\Iyzico;

use App\Http\Controllers\Controller;
use App\Repositories\UserOperations\BasketRepository;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function billing(Request $request){
        $data = $request->toArray();
        return view('invoice_information')->with('data',$data);
    }

    public function checkOut(Request $request){
        // initializing
        $repo = new BasketRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->checkOut($data);
        if($resp->getResult()){
            return view('payment_checkout')->with('data',$resp->getData());
           /* return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Fatura bilgileri başarıyla kontrol edildi.',
            ]);*/
        }
        return redirect()->back();
       /* return response()->json([
            'error' => true,
            'message' => 'Fatura bilgileri kontrol edilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);*/


    }
}
