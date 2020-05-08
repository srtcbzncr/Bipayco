<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\ExamRepository;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function createExam(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new ExamRepository();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınav başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınav oluşturulurken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showExams(){
        // initializing
        $repo = new ExamRepository();

        // operations
        $resp = $repo->all();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınav başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınav getirilirken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showExam($examId){
        // initializing
        $repo = new ExamRepository();

        // operations
        $resp = $repo->get($examId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınav başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınav getirilirken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function deleteExam($examId){
        // initializing
        $repo = new ExamRepository();

        // operations
        $resp = $repo->delete($examId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınav başarıyla silindi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınav silinirken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function updateExam($examId,Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new ExamRepository();

        // operations
        $resp = $repo->update($examId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınav başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınav oluşturulurken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
