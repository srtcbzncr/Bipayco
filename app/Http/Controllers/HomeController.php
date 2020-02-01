<?php

namespace App\Http\Controllers;

use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pbmedia\LaravelFFMpeg\FFMpegFacade as FFMpeg;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        //FFMpeg::open('wwdc_2006.mp4');
        // Repo initializations
        $geCourseRepo = new CourseRepository;

        // Operations
        $gePopularCoursesResp = $geCourseRepo->getPopularCourses();
        $data = [
            'general_education' => $gePopularCoursesResp->getData(),
            'prepare_for_lessons' => [],
            'prepare_for_exams' => [],
            'books' => [],
            'exams' => [],
        ];

        // Response
        return view('home', $data);
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
            return view('general_education.index', $data);
        }
        else{
            return view('error');
        }
    }

    public function error(){
        return view('error');
    }
}
