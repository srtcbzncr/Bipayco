<?php

namespace App\Http\Controllers\API\Iyzico;

use App\Http\Controllers\Controller;
use App\Repositories\Iyzico\RebateRepository;
use Illuminate\Http\Request;

class RebateController extends Controller
{
    public function rebateCourse(Request $request){
        $repo = new RebateRepository();
        $data = $request->toArray();

        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'İade başarıyla oluşturuldu.'
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => "Hata: ".$resp->getError(),
            'message' => 'İade oluşturulurken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }
}
