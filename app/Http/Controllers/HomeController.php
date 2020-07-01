<?php

namespace App\Http\Controllers;

use App\Repositories\Curriculum\ExamRepository;
use App\Repositories\Curriculum\LessonRepository;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use App\Repositories\PrepareLessons\CurriculumRepository;
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
        // Repo initializations
        $geCourseRepo = new CourseRepository;
        $plCourseRepo = new \App\Repositories\PrepareLessons\CourseRepository();
        $peCourseRepo = new \App\Repositories\PrepareExams\CourseRepository();


        // Operations
        $user_id = Auth::id();
        $gePopularCoursesResp = $geCourseRepo->getPopularCourses($user_id);
        $plPopularCoursesResp = $plCourseRepo->getPopularCourses($user_id);
        $pePopularCoursesResp = $peCourseRepo->getPopularCourses($user_id);

        $data = [
            'general_education' => $gePopularCoursesResp->getData(),
            'prepare_for_lessons' => $plPopularCoursesResp->getData(),
            'prepare_for_exams' => $pePopularCoursesResp->getData(),
            'books' => [],
            'exams' => [],
        ];


        // Response
        return view('home',$data);
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

    public function pl_index(){
        // Repo initializations
        $repo = new LessonRepository();

        // Operations
        $resp = $repo->all();
        $data = [
            'lessons' => $resp->getData(),
        ];

        // Response
        if($resp->getResult()){
            return view('prepare_for_lesson.index', $data);
        }
        else{
            return view('error');
        }
    }

    public function pe_index(){
        // Repo initializations
        $repo = new ExamRepository();

        // Operations
        $resp = $repo->all();
        $data = [
            'exams' => $resp->getData(),
        ];

        // Response
        if($resp->getResult()){
            return view('prepare_for_exams.index', $data);
        }
        else{
            return view('error');
        }
    }

    public function live_index(){

    }
}
