<?php

namespace App\Http\Controllers\API\QuestionSource\Student;

use App\Http\Controllers\Controller;
use App\Repositories\QuestionSource\Student\FirstLastTestStatusRepository;
use Illuminate\Http\Request;

class FirstLastTestStatusController extends Controller
{
    public function create(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new FirstLastTestStatusRepository();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Test sonucu veritabanına başarıyla eklendi.'
            ]);
        }
        return response()->json([
            'error' => false,
            'mesaj' => 'Test sonucu veritabanına eklenirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }
}
