<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\GradeRepository;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function createGrade(Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new GradeRepository();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınıf başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
           'error' => true,
           'message' => 'Sınıf oluşturulurken hata meydane geldi.Tekrar deneyin.',
           'errorMessage' => $resp->getError()
        ]);
    }

    public function showGradies(){
        // initializing
        $repo = new GradeRepository();

        // operations
        $resp = $repo->all();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınıflar başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınıflar getirilirken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function showGrade($gradeId){
        // initializing
        $repo = new GradeRepository();

        // operations
        $resp = $repo->get($gradeId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınıf başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınıf getirilirken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function deleteGrade($gradeId){
        // initializing
        $repo = new GradeRepository();

        // operations
        $resp = $repo->delete($gradeId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınıf başarıyla silindi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınıf silinirken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function updateGrade($gradeId,Request $request){
        // initializing
        $data = $request->toArray();
        $repo = new GradeRepository();

        // operations
        $resp = $repo->update($gradeId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınıf başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Sınıf oluşturulurken hata meydane geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }
}
