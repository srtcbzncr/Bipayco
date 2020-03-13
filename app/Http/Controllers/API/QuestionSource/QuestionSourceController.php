<?php

namespace App\Http\Controllers\API\QuestionSource;

use App\Http\Controllers\Controller;
use App\Repositories\QuestionSource\QuestionSourceRepository;
use Illuminate\Http\Request;

class QuestionSourceController extends Controller
{
    public function create(Request $request){
        // Initializing
        $repo = new QuestionSourceRepository();
        $data = $request->toArray();

        // Operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru oluşturulurken hata meydana geldi.Tekrar deneyin',
        ],400);
    }

    public function delete($id){
        // Initializing
        $repo = new QuestionSourceRepository();

        // Operations
        $resp = $repo->delete($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru başarıyla silindi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru silinirken hata meydana geldi.Tekrar deneyin',
        ],400);
    }
}
