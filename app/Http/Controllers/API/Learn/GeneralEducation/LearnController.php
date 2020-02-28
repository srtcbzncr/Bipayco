<?php

namespace App\Http\Controllers\API\Learn\GeneralEducation;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\LessonRepository;
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
            'message' => 'Kaynaklar getirilirken hata oluştu.Tekrar Deneyin.',
        ],400);
    }

    // Eğitmene sorulan sorular ve sorulara verilen cevapları al.
    public function getDiscussions($course_id,$lesson_id){
        // initialization
        $repo = new LearnRepository();

        // Operations
        $resp = $repo->getDiscussion($lesson_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
           'error' => true,
           'message' => 'Sorular ve cevaplar getirilirken hata oluştu.Tekrar Deneyin'
        ]);
    }

    // Eğitmene soru sor
    public function askQuestion($course_id,$lesson_id,Request $request){
        // initialization
        $repo = new LearnRepository();
        $data = $request->toArray();

        // Operations
        $resp = $repo->askQuestion($lesson_id,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Soru sorma işlmei başarılı'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Soru sorma işlemi başarısız.Tekrar Deneyin'
        ]);
    }

    public function answerQuestion($course_id,$lesson_id,$question_id,Request $request){
        // initialization
        $repo = new LearnRepository();
        $data = $request->toArray();

        // Operations
        $resp = $repo->answerQuestion($question_id,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Cevap verme işlmei başarılı'
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Cevap verme işlemi başarısız.Tekrar Deneyin'
        ]);
    }

    public function completeLesson($course_id,$lesson_id,Request $request){
        // initialization
        $repo = new LessonRepository();

        // Operations
        $resp = $repo->completeLesson($lesson_id,$request->toArray());
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Ders tamamlama başarılı.',
                'data' => $resp->getData()
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Ders tamamlanmadı.Tekrar Deneyin'
        ]);
    }
}
