<?php

namespace App\Http\Controllers\API\Purchases;

use App\Http\Controllers\Controller;
use App\Repositories\Purchases\PurchasesRepository;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function getPurchases($user_id){
        $repo = new PurchasesRepository();

        $resp = $repo->get($user_id);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError()
        ]);
    }

}
