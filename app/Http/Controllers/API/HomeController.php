<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indexGe($user_id=null){
        $geCourseRepo = new CourseRepository;

        // Operations
        $gePopularCoursesResp = $geCourseRepo->getPopularCourses($user_id);
        $data = $gePopularCoursesResp->getData();

        if($gePopularCoursesResp->getResult()){
            return response()->json([
               'error' => false,
               'data' => $data,
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $gePopularCoursesResp->getError()
        ],400);

    }

    public function indexPl($user_id=null){
        $plCourseRepo = new \App\Repositories\PrepareLessons\CourseRepository();

        // Operations
        $plPopularCoursesResp = $plCourseRepo->getPopularCourses($user_id);

        $data =  $plPopularCoursesResp->getData();

        if( $plPopularCoursesResp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $data,
            ]);
        }

        return response()->json([
            'error' => true,
            'errorMessage' => $plPopularCoursesResp->getError()
        ],400);

    }

    public function indexPe($user_id=null){
        $data = [];
        return response()->json([
           'error' => false,
           'data' => $data
        ]);
    }

    public function indexBooks($user_id=null){
        $data = [];
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function indexExams($user_id=null){
        $data = [];
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function ge_index($user_id=null){
        // Repo initializations
        $repo = new CategoryRepository;

        // Operations
        $resp = $repo->all();
        $data = [
            'categories' => $resp->getData(),
        ];

        // Response
        if($resp->getResult()){
            return response()->json([
                'error' => false,
                'data' => $data
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Bir hata oluştu.'
        ]);
    }
}
