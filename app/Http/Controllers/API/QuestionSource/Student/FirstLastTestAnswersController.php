<?php

namespace App\Http\Controllers\API\QuestionSource\Student;

use App\Http\Controllers\Controller;
use App\Repositories\QuestionSource\Student\FirstLastTestAnswersRepository;
use Illuminate\Http\Request;

class FirstLastTestAnswersController extends Controller
{
    public function create(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new FirstLastTestAnswersRepository();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getError(),
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
