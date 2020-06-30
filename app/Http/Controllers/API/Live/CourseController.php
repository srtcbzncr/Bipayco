<?php

namespace App\Http\Controllers\API\Live;

use App\Http\Controllers\Controller;
use App\Repositories\Live\CourseRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function goalsPost(Request $request){
        $data = $request->toArray();
        $repo = new CourseRepository();
        $resp = $repo->goalsPost();

        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Kazanımlar başarıyla oluşturuldu.'
            ]);
        }
        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Kazanımlar oluşturulurken bir hata meydana geldi. Tekrar deneyin.'
        ],400);
    }
}
