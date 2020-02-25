<?php

namespace App\Http\Controllers\API\Learn\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\Learn\GeneralEducation\LearnRepository;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    // Sections ve Lessons verileri al.
    public function getCourse($id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $resp = $repo->getCourse($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kurs getirilirken hata oluştur.Tekrar deneyin.'
        ],400);
    }

    // Video veya pdf verisini al.
    public function getLesson($course_id,$lesson_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $resp = $repo->getLesson($lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
           'error' => true,
           'message' => 'Ders getirilirken hata oluştu.Tekrar Deneyin.'
        ],400);
    }

    // Source'ları al.
    public function getSources($course_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $resp = $repo->getSources($course_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Kaynaklar başarıyla getirildi.',
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Kaynaklar getirilirken hata oluştu.Tekrar Deneyin.'
        ],400);
    }

    // Eğitmene sorulan sorular ve sorulara verilen cevapları al.
    public function getDiscussions(){

    }
}
