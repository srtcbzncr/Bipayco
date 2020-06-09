<?php

namespace App\Http\Controllers\Iyzico;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Repositories\UserOperations\BasketRepository;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function billing(Request $request){
        $data = $request->toArray();
        $data['is_discount'] = false;
        if($data['coupon'] != "null"){
            $instructor = Instructor::where('reference_code',$data['coupon'])->where('active',true)->where('deleted_at',null)->first();
            if($instructor != null){
                $data['is_discount'] = true;
            }
        }
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
        else{
            return redirect()->back();
        }

       /* return response()->json([
            'error' => true,
            'message' => 'Fatura bilgileri kontrol edilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);*/


    }
}
