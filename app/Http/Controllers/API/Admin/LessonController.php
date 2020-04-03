<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\LessonRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function createLesson(Request $request){
        // initializing
        $repo = new LessonRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->create($data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders başarıyla oluşturuldu.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Ders oluşturulurken hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showLessons(){
        // initializing
        $repo = new LessonRepository();

        // operations
        $resp = $repo->all();
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Dersler başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Dersler getirilirken hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function showLesson($lessonId){
        // initializing
        $repo = new LessonRepository();

        // operations
        $resp = $repo->get($lessonId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Ders getirilirken hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function deleteLesson($lessonId){
        // initializing
        $repo = new LessonRepository();

        // operations
        $resp = $repo->delete($lessonId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Ders getirilirken hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function updateLesson($lessonId,Request $request){
        // initializing
        $repo = new LessonRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->update($lessonId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders başarıyla güncellendi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Ders güncellenirken hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function getSubjects($lessonId){
        // initializing
        $repo = new LessonRepository();

        // operations
        $resp = $repo->getSubjectsOfLesson($lessonId);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Derse ait konular başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Derse ait konular getirilirken hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
