<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function indexGe(Request $request){
        $geCourseRepo = new CourseRepository;
        $user_id = null;
        if(isset($request->toArray()['user_id'])){
            $user_id = $request->toArray()['user_id'];
        }

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

    public function indexPl(Request $request){
        $plCourseRepo = new \App\Repositories\PrepareLessons\CourseRepository();
        $user_id = null;
        if(isset($request->toArray()['user_id'])){
            $user_id = $request->toArray()['user_id'];
        }

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

    public function indexPe(Request $request){
        $data = [];
        return response()->json([
           'error' => false,
           'data' => $data
        ]);
    }

    public function indexBooks(Request $request){
        $data = [];
        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function indexExams(Request $request){
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
