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
        // Initializations
        $courseRepo = new CourseRepository;

        //Operations
        $resp = $courseRepo->getPopularCourses();

        // Response
        if($resp->getResult()){
            return view('home', $resp->getData());
        }
        else{
            return view('home');
        }

    }

    public function error(){
        return view('error');
    }
}
