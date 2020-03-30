<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indexGe(){
        $geCourseRepo = new CourseRepository;

        // Operations
        $gePopularCoursesResp = $geCourseRepo->getPopularCourses();
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

    public function indexPl(){
        $plCourseRepo = new \App\Repositories\PrepareLessons\CourseRepository();

        // Operations
        $plPopularCoursesResp = $plCourseRepo->getPopularCourses();

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

    public function indexPe(){
        $data = [];
        return response()->json([
           'error' => false,
           'data' => $data
        ]);
    }

    public function indexBooks(){
        $data = [];
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function indexExams(){
        $data = [];
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function ge_index(){
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
