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
            'prepare_for_lessons' => null,
            'prepare_for_exams' => null,
            'books' => null,
            'exams' => null,
        ];
        return view('home', $data);
    }

    public function error(){
        return view('error');
    }
}
