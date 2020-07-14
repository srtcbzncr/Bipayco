<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\CourseRepository;

class CourseController extends Controller
{
    public function geAllCourses($user_id){
        $repo = new CourseRepository();

        $resp = $repo->geAllCourses($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Genel eğitimler başarıyla getirildi',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
           'error' => true,
           'message' => 'Genel eğitimler getirilirken bir hata meydana geldi.Tekrar deneyin.',
           'errorMessage' => $resp->getError()
        ],400);
    }

    public function plAllCourses($user_id){
        $repo = new CourseRepository();

        $resp = $repo->plAllCourses($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Derslere hazırlık kursları başarıyla getirildi',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
            'error' => true,
            'message' => 'Derslere hazırlık kursları getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function peAllCourses($user_id){
        $repo = new CourseRepository();

        $resp = $repo->peAllCourses($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Sınavlara hazırlık kursları başarıyla getirildi',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
            'error' => true,
            'message' => 'Sınavlara hazırlık kursları getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function liveAllCourses($user_id){
        $repo = new CourseRepository();

        $resp = $repo->liveAllCourses($user_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Canlı yayınlar başarıyla getirildi',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
            'error' => true,
            'message' => 'Canlı yayınlar getirilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function activeGeCourse($user_id,$course_id){
        $repo = new CourseRepository();

        $resp = $repo->activeGeCourse($user_id,$course_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Aktif etme başarılı',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
            'error' => true,
            'message' => 'Aktif edilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function activePlCourse($user_id,$course_id){
        $repo = new CourseRepository();

        $resp = $repo->activePlCourse($user_id,$course_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Aktif etme başarılı',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
            'error' => true,
            'message' => 'Aktif edilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }

    public function activePeCourse($user_id,$course_id){
        $repo = new CourseRepository();

        $resp = $repo->activePeCourse($user_id,$course_id);
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'message' => 'Aktif etme başarılı',
                'data' => $resp->getData()
            ],200);
        }
        return response()->json([
            'error' => true,
            'message' => 'Aktif edilirken bir hata meydana geldi.Tekrar deneyin.',
            'errorMessage' => $resp->getError()
        ],400);
    }
}
