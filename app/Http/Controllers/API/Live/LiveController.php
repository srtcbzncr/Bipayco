<?php

namespace App\Http\Controllers\API\Live;

use App\Http\Controllers\Controller;
use App\Repositories\Live\LiveRepository;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    public function createLiveOnBipayco(Request $request){
        $data = $request->toArray();
        $repo = new LiveRepository();

        $resp = $repo->createLiveOnBipayco($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Canlı yayın başarıyla oluşturuldu.'
            ]);
        }
        return response()->json([
            'error' => true,
            'errorMessage', $resp->getError(),
            'message' => 'Canlı yayın oluşturulurken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }

    public function createLiveOnBBB($user_id,$meeting_id){
        $repo = new LiveRepository();

        $resp=$repo->createLiveOnBBB($user_id,$meeting_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data', $resp->getData(),
                'message' => 'Canlı yayın başlatıldı.'
            ]);
        }
        return response()->json([
            'error' => true,
            'errorMessage', $resp->getError(),
            'message' => 'Canlı yayın başlatılırken bir hata meydana geldi.Tekrar deneyin.'
        ],400);
    }
}
