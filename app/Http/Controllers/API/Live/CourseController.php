<?php

namespace App\Http\Controllers\API\Live;

use App\Http\Controllers\Controller;
use App\Repositories\Live\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function goalsPost($course_id,Request $request){
        $data = $request->toArray();
        $repo = new CourseRepository();
        $resp = $repo->goalsPost($course_id,$data);

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

    public function goalsGet($course_id){
        $repo = new CourseRepository();
        $resp = $repo->goalsGet($course_id);

        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Kazanımlar başarıyla getirildi.'
            ]);
        }
        return response()->json([
            'error' => true,
            'errorMessage' => $resp->getError(),
            'message' => 'Kazanımlar getirilirken bir hata meydana geldi. Tekrar deneyin.'
        ],400);
    }

    public function show($id, Request $request){
        // Repo initialization
        $repo = new CourseRepository;
        $user_id = null;
        if(isset($request->toArray()['user_id'])){
            $user_id = $request->toArray()['user_id'];
        }

        // Operations
        $resp = $repo->get_api($id,$user_id);
        $entriesResp = $repo->getStudents($id);
        $data = [
            'course' => $resp->getData(),
            'entries' => $entriesResp->getData(),
            'student_count' => count($entriesResp->getData()),
        ];

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $data,
                'message' => 'Kurs verileri başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => false,
            'mesage' => 'Kurs verileri getirilirken hata oluştu.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    /*public function buy($courseId,Request $request){
        // initializing
        $repo = new CourseRepository();
        $data = $request->toArray();

        // operations
        $resp = $repo->buy($courseId,$data);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData()
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Satın alma başarısız.Tekrar deneyin',
            'errorMessage' => $resp->getError()
        ]);
    }*/

    public function inBasket($user_id,$course_id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->inBasket($user_id,$course_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'inBasket' => $resp->getData(),
                'message' => 'Basket kontrol bilgisi başarıyla getirildi.'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function simularCourses($course_id,$user_id=null){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->getSimilarCourses($course_id,$user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message' => 'Benzer kurslar başarıyla getirildi'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.Tekrar deneyin.',
            'errorMessage'=>$resp->getError()
        ]);
    }

    public function deleteCourse($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->delete($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message'=>'Kurs başarıyla silindi'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

    public function instructorsGet($id){
        // Initializing
        $repo = new CourseRepository();

        // Operations
        $resp = $repo->instructorsGet($id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $resp->getData(),
                'message'=>'Eğitmenler başarıyla getirildi'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ]);
    }

}
