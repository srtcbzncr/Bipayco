<?php

namespace App\Http\Controllers;

use App\Repositories\GeneralEducation\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function error(){
        return view('error');
    }
}
