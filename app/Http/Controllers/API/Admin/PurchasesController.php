<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\PurchasesRepository;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function getPurchases($user_id){
        $repo = new PurchasesRepository();
        $resp = $repo->getPurchases($user_id);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
               'message' => 'Satın alımlar başarılı bir şekilde getirildi.',
               'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Satın alımlar getirilirken bir hata meydana geldi.Tekrar deneyin',
            'errorMessage'=>$resp->getError()
        ],400);
    }

    public function getPurchaseDetail($payment_id){
        $repo = new PurchasesRepository();
        $resp = $repo->getPurchaseDetail($payment_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Satın alım detayı başarılı bir şekilde getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Satın alım detayı getirilirken bir hata meydana geldi.Tekrar deneyin',
            'data' => $resp->getData()
        ],400);
    }

    public function getPurchasesAsDate($user_id){
        $repo = new PurchasesRepository();
        $resp = $repo->getPurchasesAsDate($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Tarih bazında satın alımlar başarılı bir şekilde getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Tarih bazında satın alımlar getirilirken bir hata meydana geldi.Tekrar deneyin',
            'data' => $resp->getData()
        ],400);
    }
}
