<?php

namespace App\Http\Controllers\API\Learn\PrepareLessons;

use App\Http\Controllers\Controller;
use App\Repositories\Learn\PrepareLessons\LearnRepository;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function getSources($course_id,$lesson_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $resp = $repo->getSources($lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kaynaklar başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kaynaklar getirilirken hata oluştu.Tekrar Deneyin.',
        ],400);
    }

    public function getDiscussions(){

    }
}
