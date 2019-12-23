<?php

namespace App\Http\Controllers;

use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $geCourseRepo = new CourseRepository;
        $gePopularCoursesResp = $geCourseRepo->getPopularCourses();
        $data = [
            'general_education' => $gePopularCoursesResp->getData(),
            'prepare_for_lessons' => [],
            'prepare_for_exams' => [],
            'books' => [],
            'exams' => [],
        ];
        return view('home', $data);
    }

    public function error(){
        return view('error');
    }
}
