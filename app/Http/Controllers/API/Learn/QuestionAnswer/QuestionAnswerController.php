<?php

namespace App\Http\Controllers\API\Learn\QuestionAnswer;

use App\Http\Controllers\Controller;
use App\Repositories\Learn\QuestionAnswer\QuestionAnswerRepository;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function getNotAnsweredQuestions($userId){
        $repo = new QuestionAnswerRepository();
        $resp = $repo->getNotAnsweredQuestions($userId);
        if($resp->getResult()){
            return response()->json([
               'error' => false,
               'message' => 'Cevaplanmamış sorular başarıyla getirildi.',
               'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Cevaplanmamış sorular getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function getAnsweredQuestions($userId){
        $repo = new QuestionAnswerRepository();
        $resp = $repo->getAnsweredQuestions($userId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Cevaplanmamış sorular başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Cevaplanmamış sorular getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }
}
