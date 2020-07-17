<?php

namespace App\Http\Controllers;

use App\Models\Live\Course;
use App\Repositories\Curriculum\ExamRepository;
use App\Repositories\Curriculum\LessonRepository;
use App\Repositories\GeneralEducation\CategoryRepository;
use App\Repositories\GeneralEducation\CourseRepository;
use App\Repositories\Live\LiveRepository;
use App\Repositories\PrepareLessons\CurriculumRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        // Repo initializations
        $repo = new LiveRepository();

        // Operations
        $resp = $repo->all();

        // Response
        if($resp->getResult()){
            return view('live.index')->with('course_count',count($resp->getData()));
        }
        else{
            return view('error');
        }
    }

    public function end_meeting($meeting_id){
        try {
            $live = Course::where('meeting_id',$meeting_id)->where('deleted_at',null)->first();
            $now = Carbon::now();
            $live->completed_at = $now;
            $live->save();
        }catch(\Exception $e){
            print_r("hata: "+$e->getMessage());
        }

    }
}
