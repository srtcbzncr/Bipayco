<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $geCourseRepo = new CourseRepository;
        $plCourseRepo = new \App\Repositories\PrepareLessons\CourseRepository();

        // Operations
        $gePopularCoursesResp = $geCourseRepo->getPopularCourses();
        $plPopularCoursesResp = $plCourseRepo->getPopularCourses();

        $data = [
            'general_education' => $gePopularCoursesResp->getData(),
            'prepare_for_lessons' => $plPopularCoursesResp->getData(),
            'prepare_for_exams' => [],
            'books' => [],
            'exams' => [],
        ];

        if($gePopularCoursesResp->getResult() and $plPopularCoursesResp->getResult()){
            return response()->json([
               'error' => false,
               'data' => $data,
            ]);
        }

        if(!$gePopularCoursesResp->getResult()){
            return response()->json([
                'error' => true,
                'errorMessage' => $gePopularCoursesResp->getError()
            ],400);
        }
        else if(!$plPopularCoursesResp->getResult()){
            return response()->json([
                'error' => true,
                'errorMessage' => $plPopularCoursesResp->getError()
            ],400);
        }

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
