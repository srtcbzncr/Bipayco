<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Instructor;
use App\Repositories\Auth\InstructorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class InstructorController extends Controller
{
    public function courses(){
        $data = array();
        $repo = new InstructorRepository();
        $data['ge'] = $repo->getLastGeCourses()->getData();
        $data['pl'] = $repo->getLastPlCourses()->getData();
        $data['pe'] = $repo->getLastPeCourses()->getData();
        View::share('data',$data);
        return view('instructor.courses');
    }

    public function books(){
        return view('instructor.books');
    }

    public function exams(){
        return view('instructor.exams');
    }

    public function homeworks(){
        return view('instructor.homeworks');
    }

    public function performance(){
        // performans verileri çekeceğiz.

        return view('instructor.performance');
    }

    public function questions(){
        return view('instructor.questions');
    }
}
